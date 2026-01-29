@extends('layouts.admin')

@section('header', 'Edit Admin')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <form action="{{ route('admin.settings.update', $admin->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Full Name</label>
            <input type="text" name="name" value="{{ $admin->name }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Email Address</label>
            <input type="email" name="email" value="{{ $admin->email }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mt-8 mb-4 border-t pt-4">
            <h3 class="text-lg font-semibold mb-4">Change Password</h3>
            <p class="text-sm text-gray-500 mb-4">Leave blank if you don't want to change the password.</p>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">New Password</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.settings.index') }}" class="text-gray-600 mr-4 py-2">Cancel</a>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Update Admin</button>
        </div>
    </form>
</div>
@endsection
