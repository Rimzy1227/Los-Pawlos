@extends('layouts.admin')

@section('header', 'Add New Admin')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <form action="{{ route('admin.settings.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Full Name</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Email Address</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.settings.index') }}" class="text-gray-600 mr-4 py-2">Cancel</a>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Add Admin</button>
        </div>
    </form>
</div>
@endsection
