@extends('layouts.admin')

@section('header', 'Manage Categories')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-xl font-semibold text-gray-800">Category List</h3>
    <a href="{{ route('admin.categories.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
        + Add New Category
    </a>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b text-gray-600 uppercase text-xs">
                <th class="px-6 py-3">ID</th>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Products</th>
                <th class="px-6 py-3">Created At</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-sm">
            @foreach($categories as $category)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $category->id }}</td>
                <td class="px-6 py-4 font-medium text-gray-800">{{ $category->name }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.products.index', ['category_id' => $category->id]) }}" class="text-blue-600 hover:underline">
                        View Products ({{ $category->products->count() }})
                    </a>
                </td>
                <td class="px-6 py-4">{{ $category->created_at->format('Y-m-d') }}</td>
                <td class="px-6 py-4 flex space-x-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection
