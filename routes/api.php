<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- Authentication Routes ---

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'role' => 'nullable|string|in:customer,admin' 
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role ?? 'customer',
    ]);

    // Role-based token ability assignment
    $abilities = $user->role === 'admin' ? ['admin'] : ['read'];
    $token = $user->createToken('auth_token', $abilities)->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Assign abilities based on user's actual role in DB
    $abilities = $user->role === 'admin' ? ['admin'] : ['read'];

    $token = $user->createToken($request->device_name ?? 'api_token', $abilities)->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
});

// --- Protected Routes ---

Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Token revoked successfully']);
    });

    // Shared Routes (User & Admin)
    Route::get('/products', function (Request $request) {
         // Both can view products if they have 'read' or 'admin' ability
         if ($request->user()->tokenCan('read') || $request->user()->tokenCan('admin')) {
             return Product::all();
         }
         return response()->json(['message' => 'Forbidden'], 403);
    });

    Route::get('/products/{id}', function ($id) {
        return Product::findOrFail($id);
    });

    // Admin Only Routes
    Route::middleware('ability:admin')->group(function () {
        Route::post('/products', function (Request $request) {
            $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'image' => 'nullable|string',
                'stock' => 'required|integer',
                'category_id' => 'nullable|integer'
            ]);
            return Product::create($request->all());
        });

        Route::put('/products/{id}', function (Request $request, $id) {
            $product = Product::findOrFail($id);
            $product->update($request->all());
            return $product;
        });

        Route::delete('/products/{id}', function ($id) {
            Product::destroy($id);
            return response()->json(['message' => 'Product deleted successfully']);
        });

        // admin list
        Route::get('/users-list', function () {
            return User::all();
        });
    });
});

// --- Security Demonstration Routes ---

/**
 * SQL Injection vulnerability demonstration and fix.
 * 
 * Usage in Postman:
 * GET http://localhost:8000/api/vuln-sql?email=' OR '1'='1
 */
Route::get('/vuln-sql', function (Request $request) {
    $email = $request->input('email');

    // SECURE: The '?' placeholder ensures parameterized queries, preventing SQL injection.
    // Laravel's Eloquent/Query Builder uses this under the hood.
    $users = DB::select("SELECT * FROM users WHERE email = ?", [$email]); 
    
    return $users;
});

Route::get('/generate-my-token', function (Request $request) {
    if (!auth()->check()) {
        return response()->json(['error' => 'Please login to the website first in another tab.'], 401);
    }
    
    // This is the Sanctum magic:
    $token = auth()->user()->createToken('AssignmentProofToken')->plainTextToken;
    
    return response()->json([
        'message' => 'SUCCESS! A row has been added to personal_access_tokens table.',
        'token' => $token,
        'database_proof' => 'Check your personal_access_tokens table now!'
    ]);
});
