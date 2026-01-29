<header class="shadow-md">
  <!-- topnav -->
<div class="bg-white px-6 py-3">
  <div class="flex items-center justify-between flex-wrap">

    <!-- logo -->
    <div class="flex items-center space-x-2 mb-2 sm:mb-0">
      <img src="{{ asset('assets/images/logo2.jpg') }}" alt="Logo" class="h-10 w-10">
      <a class="text-xl font-bold text-gray-800" href="{{ route('home') }}">
        Los Pawlos Hermanos
      </a>
    </div>

    <!-- Search Bar -->
    <form action="{{ route('products.index') }}" method="get" class="flex flex-grow sm:flex-grow-0 items-center w-full sm:w-1/2 max-w-lg mb-2 sm:mb-0 sm:mx-4">
      <input 
        type="text" 
        name="search" 
        value="{{ request('search') }}"
        placeholder="Search products..." 
        class="flex-grow border border-black border-r-0 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
      >
      <button 
        type="submit" 
        class="border border-black border-l-0 bg-orange-400 text-white px-4 py-2 rounded-r-lg hover:bg-orange-600"
      >
        🔍
      </button>
    </form>

    <!-- Auth & Cart -->
    <div class="flex items-center space-x-4">
      @auth
        <a href="{{ route('account.index') }}" class="text-gray-700 hover:text-orange-500 font-semibold">
          {{ Auth::user()->name }}
        </a>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-gray-700 hover:text-orange-500">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500">Login</a>
        <a href="{{ route('register') }}" class="text-gray-700 hover:text-orange-500">Register</a>
      @endauth

      <!-- Cart -->
      <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-orange-500 text-2xl">
        🛒
        @php
            $cartQty = 0;
            $cart = session('cart', []);
            foreach($cart as $item) {
                $cartQty += $item['quantity'] ?? $item['qty'] ?? 0;
            }
        @endphp
        @if ($cartQty > 0)
          <span id="cart-count" class="absolute -top-2 -right-3 bg-orange-500 text-white text-xs px-2 py-0.5 rounded-full">
            {{ $cartQty }}
          </span>
        @endif
      </a>
    </div>
  </div>
</div>


  <!-- 2ndnav -->
  <nav class="bg-orange-500 text-white">
    <ul class="flex justify-center space-x-8 py-3 text-sm font-semibold">
    <li><a href="{{ route('products.index') }}" class="hover:underline">All Products</a></li>
    <li><a href="{{ route('products.index', ['category' => 'Food']) }}" class="hover:underline">Food</a></li>
    <li><a href="{{ route('products.index', ['category' => 'Toys']) }}" class="hover:underline">Toys</a></li>
    <li><a href="{{ route('products.index', ['category' => 'Grooming']) }}" class="hover:underline">Grooming</a></li>
    <li><a href="{{ route('products.index', ['category' => 'Accessories']) }}" class="hover:underline">Accessories</a></li>
    </ul>
  </nav>
</header>
