@extends('layouts.admin')

@section('header', 'Manage Products')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-xl font-semibold text-gray-800">Product List</h3>
    <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
        + Add New Product
    </a>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b text-gray-600 uppercase text-xs">
                <th class="px-6 py-3">ID</th>
                <th class="px-6 py-3">Image</th>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Category</th>
                <th class="px-6 py-3">Price</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-sm">
            @foreach($products as $product)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $product->id }}</td>
                <td class="px-6 py-4">
                    @if($product->image)
                        <img src="{{ asset('assets/images/'.strtolower($product->category).'/'.$product->image) }}" class="h-10 w-10 object-contain rounded bg-gray-100">
                    @else
                        <span class="text-gray-400">No Img</span>
                    @endif
                </td>
                <td class="px-6 py-4 font-medium text-gray-800">{{ $product->name }}</td>
                <td class="px-6 py-4">{{ $product->category }}</td>
                <td class="px-6 py-4">${{ number_format($product->price, 2) }}</td>
                <td class="px-6 py-4 flex space-x-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
        {{ $products->links() }}
    </div>
</div>
@endsection
