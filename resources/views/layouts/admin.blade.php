<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Dashboard - Los Pawlos</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .admin-link {
        display: block;
        padding: 0.75rem 1rem;
        color: #d1d5db; /* gray-300 */
        border-radius: 0.375rem;
        transition: all 0.2s;
    }
    .admin-link:hover, .admin-link.active {
        background-color: #374151; /* gray-700 */
        color: white;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
  <div class="flex h-screen overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
      <div class="h-16 flex items-center justify-center border-b border-gray-800">
        <h1 class="text-xl font-bold">Los Pawlos Admin</h1>
      </div>
      
      <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" class="admin-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('admin.products.index') }}" class="admin-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Products</a>
        <a href="{{ route('admin.categories.index') }}" class="admin-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Categories</a>
        <a href="{{ route('admin.orders.index') }}" class="admin-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">Orders</a>
        <a href="{{ route('admin.customers.index') }}" class="admin-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">Customers</a>
        <a href="{{ route('admin.settings.index') }}" class="admin-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">Settings</a>
      </nav>

      <div class="p-4 border-t border-gray-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded">Logout</button>
        </form>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Header -->
      <header class="bg-white shadow h-16 flex items-center justify-between px-6">
        <h2 class="text-xl font-semibold text-gray-800">
            @yield('header', 'Dashboard')
        </h2>
        <div class="flex items-center">
            <span class="text-gray-600 mr-4">Welcome, {{ Auth::user()->name }}</span>
            <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="Avatar">
        </div>
      </header>

      <!-- Content Body -->
      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
        @yield('content')
      </main>
    </div>

  </div>
</body>
</html>
