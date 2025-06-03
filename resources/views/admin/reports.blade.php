@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Order Reports</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th><th>Total</th><th>Status</th><th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
