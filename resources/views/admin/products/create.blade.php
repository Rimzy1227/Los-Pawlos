@extends('layouts.admin')

@section('header', 'Add New Product')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Product Name</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Category</label>
            <select name="category_id" class="w-full border rounded px-3 py-2" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Price ($)</label>
            <input type="number" step="0.01" name="price" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" rows="4"></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Product Image</label>
            <input type="file" name="image" class="w-full">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.products.index') }}" class="text-gray-600 mr-4 py-2">Cancel</a>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Save Product</button>
        </div>
    </form>
</div>
@endsection
