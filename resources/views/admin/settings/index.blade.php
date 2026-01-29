@extends('layouts.admin')

@section('header', 'Settings & Admins')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-xl font-semibold text-gray-800">Admin Users</h3>
        <p class="text-sm text-gray-500">Manage who has access to the admin dashboard.</p>
    </div>
    <a href="{{ route('admin.settings.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
        + Add New Admin
    </a>
</div>

<div class="bg-white rounded shadow overflow-x-auto mb-8">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b text-gray-600 uppercase text-xs">
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3">Created At</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-sm">
            @foreach($admins as $admin)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-800">
                    {{ $admin->name }}
                    @if(Auth::id() === $admin->id)
                        <span class="ml-2 px-2 py-0.5 rounded text-xs bg-green-100 text-green-800">You</span>
                    @endif
                </td>
                <td class="px-6 py-4">{{ $admin->email }}</td>
                <td class="px-6 py-4">{{ $admin->created_at->format('Y-m-d') }}</td>
                <td class="px-6 py-4 flex space-x-2">
                    <a href="{{ route('admin.settings.edit', $admin->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                    
                    @if(Auth::id() !== $admin->id)
                    <form action="{{ route('admin.settings.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this admin?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Remove</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
