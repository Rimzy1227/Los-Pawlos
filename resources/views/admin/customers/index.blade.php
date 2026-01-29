@extends('layouts.admin')

@section('header', 'Customers')

@section('content')
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b text-gray-600 uppercase text-xs">
                <th class="px-6 py-3">ID</th>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3">Total Orders</th>
                <th class="px-6 py-3">Joined Date</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-sm">
            @foreach($customers as $customer)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $customer->id }}</td>
                <td class="px-6 py-4 font-semibold text-gray-800">{{ $customer->name }}</td>
                <td class="px-6 py-4">{{ $customer->email }}</td>
                <td class="px-6 py-4">{{ $customer->orders_count }}</td>
                <td class="px-6 py-4">{{ $customer->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4">
        {{ $customers->links() }}
    </div>
</div>
@endsection
