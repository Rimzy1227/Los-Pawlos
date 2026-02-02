<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if($user){
                $user->update([
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                ]);
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'role' => 'customer',
                    'password' => null, // No password for Google users initially
                ]);
            }

            Auth::login($user);

            return redirect('/')->with('success', 'Logged in with Google!');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // ASSIGNMENT FEATURE: Incognito Gatekeeper (Security Exception)
        if ($request->input('is_incognito') === 'true') {
            return back()->withErrors([
                'email' => 'SECURITY EXCEPTION: Unauthorized access attempt detected via Incognito/Private mode. For database integrity and forensic tracking, login is prohibited in this mode.'
            ])->onlyInput('email');
        }

        // ASSIGNMENT FEATURE: Proactive Security Block
        // We detect common SQL injection patterns before they even reach the database
        $userInput = $request->input('email') . ' ' . $request->input('password');
        $patterns = ["' OR", "'OR", "1=1", "1 = 1", "--", "DROP TABLE", "UNION SELECT"];
        
        foreach ($patterns as $pattern) {
            if (stripos($userInput, $pattern) !== false) {
                \Illuminate\Support\Facades\Log::warning("SQL Injection attempt blocked: " . $userInput);
                return back()->withErrors([
                    'email' => 'SECURITY THREAT DETECTED: Malicious characters detected. For your security, this attempt has been logged and blocked.'
                ])->onlyInput('email');
            }
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // HASHES THE PASSWORD
            'role' => 'customer'
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
