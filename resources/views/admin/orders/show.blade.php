@extends('layouts.admin')

@section('header', 'Order Details #' . $order->id)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Order Info & Items -->
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-bold mb-4">Order Items</h3>
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b text-sm text-gray-600">
                        <th class="py-2">Product</th>
                        <th class="py-2">Price</th>
                        <th class="py-2">Qty</th>
                        <th class="py-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="py-3">{{ $item->product->name ?? 'Deleted Product' }}</td>
                            <td class="py-3">${{ number_format($item->price, 2) }}</td>
                            <td class="py-3">{{ $item->quantity }}</td>
                            <td class="py-3 font-medium">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t">
                        <td colspan="3" class="py-3 text-right font-bold">Total:</td>
                        <td class="py-3 font-bold text-lg">${{ number_format($order->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Customer & Action -->
    <div class="space-y-6">
        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-bold mb-4">Customer Info</h3>
            <p><span class="font-semibold">Name:</span> {{ $order->user->name ?? 'Guest' }}</p>
            <p><span class="font-semibold">Email:</span> {{ $order->user->email ?? '-' }}</p>
            <p class="mt-4 text-sm text-gray-500">Order placed on {{ $order->created_at->format('M d, Y H:i') }}</p>
        </div>

        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-bold mb-4">Update Status</h3>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border rounded px-3 py-2">
                        @foreach(['pending', 'paid', 'shipped', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Update Status</button>
            </form>
        </div>
    </div>

</div>
<div class="mt-6">
    <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-900">← Back to Orders</a>
</div>
@endsection
