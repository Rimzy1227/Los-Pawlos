@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">
 <!-- Back Button -->
<div class="mb-6">
  <a 
    href="javascript:history.back()" 
    class="inline-flex items-center px-4 py-2 border border-black rounded-md bg-white text-black hover:bg-black hover:border-black hover:text-white transition duration-200"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back
  </a>
</div>
  <h1 class="text-3xl font-bold mb-8 text-gray-800">My Account</h1>

  <div x-data="{ tab: 'profile' }" class="space-y-6">
    <div class="flex border-b text-gray-600 font-medium">
      <button @click="tab = 'profile'" 
              :class="tab === 'profile' ? 'border-orange-500 text-orange-600' : 'hover:text-orange-500'"
              class="pb-3 px-6 border-b-2 transition">
        Profile
      </button>
      <button @click="tab = 'orders'" 
              :class="tab === 'orders' ? 'border-orange-500 text-orange-600' : 'hover:text-orange-500'"
              class="pb-3 px-6 border-b-2 transition">
        Orders
      </button>
      <button @click="tab = 'addresses'" 
              :class="tab === 'addresses' ? 'border-orange-500 text-orange-600' : 'hover:text-orange-500'"
              class="pb-3 px-6 border-b-2 transition">
        Addresses
      </button>
    </div>

    <div x-show="tab === 'profile'" class="bg-white shadow rounded-lg p-6">
  <h2 class="font-semibold text-lg mb-4 text-gray-800">Profile Information</h2>

  @if (request('edit'))
   
    <form action="{{ route('account.update') }}" method="post" class="space-y-4 max-w-md">
        @csrf
        <label class="block">
            Full Name:
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border p-2 rounded" />
        </label>

        <label class="block">
            Email Address:
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border p-2 rounded" />
        </label>

        <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Save Changes</button>
    </form>

    <a href="{{ route('account.index') }}" class="inline-block mt-4 text-sm text-blue-600 hover:underline">← Cancel</a>
  
  @else
   
    <div class="space-y-2 text-gray-700">
        <p><span class="font-medium">Full Name:</span> {{ $user->name }}</p>
        <p><span class="font-medium">Email Address:</span> {{ $user->email }}</p>
        <p><span class="font-medium">Account Type:</span> {{ $user->role ?? 'Customer' }}</p>
    </div>

    <a href="{{ route('account.index', ['edit' => 1]) }}" 
       class="mt-6 inline-block px-5 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
        ✏️ Edit Profile
    </a>
  @endif
</div>

    <div x-show="tab === 'orders'" class="bg-white shadow rounded-lg p-6" style="display: none;">
      <h2 class="font-semibold text-lg mb-4 text-gray-800">My Orders</h2>
      @if($user->orders && $user->orders->count() > 0)
        <ul>
            @foreach($user->orders as $order)
                <li class="mb-4 border-b pb-4">
                    <p class="font-semibold">Order #{{ $order->id }}</p>
                    <p>Total: ${{ number_format($order->total, 2) }}</p>
                    <p>Status: {{ ucfirst($order->status) }}</p>
                </li>
            @endforeach
        </ul>
      @else
        <p class="text-gray-600">You haven’t placed any orders yet.</p>
      @endif
    </div>

    <div x-show="tab === 'addresses'" class="bg-white shadow rounded-lg p-6" style="display: none;">
      <h2 class="font-semibold text-lg mb-4 text-gray-800">Saved Addresses</h2>
      <p class="text-gray-600">No addresses saved yet.</p>
      <a href="#" 
         class="mt-4 inline-block px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
        Add Address
      </a>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
