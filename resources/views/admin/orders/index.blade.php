@extends('layouts.admin')

@section('header', 'Manage Orders')

@section('content')
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b text-gray-600 uppercase text-xs">
                <th class="px-6 py-3">Order ID</th>
                <th class="px-6 py-3">Customer</th>
                <th class="px-6 py-3">Total</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Date</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-sm">
            @foreach($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">#{{ $order->id }}</td>
                <td class="px-6 py-4">{{ $order->user->name ?? 'Guest' }}</td>
                <td class="px-6 py-4">${{ number_format($order->total, 2) }}</td>
                <td class="px-6 py-4">
                    {{ ucfirst($order->status) }}
                </td>
                <td class="px-6 py-4">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
