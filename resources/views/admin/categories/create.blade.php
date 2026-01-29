@extends('layouts.admin')

@section('header', 'Add New Category')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Category Name</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-600 mr-4 py-2">Cancel</a>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Save Category</button>
        </div>
    </form>
</div>
@endsection
