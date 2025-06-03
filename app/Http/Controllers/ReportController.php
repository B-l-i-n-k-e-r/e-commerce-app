<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    // Generate sales report
    public function index()
    {

         $reports = \App\Models\Order::with('user')
        ->latest()
        ->paginate(15);
        $orders = Order::with(['user', 'items.product'])->latest()->get();
        $totalSales = $orders->sum('total_amount');
        $productOrderCounts = [];
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $productName = $item->product->name ?? 'Unknown Product';
                $productOrderCounts[$productName] = ($productOrderCounts[$productName] ?? 0) + 1;
            }
        }

        return view('admin.reports.index', compact('totalSales', 'orders', 'productOrderCounts'));
    }

    public function export(): StreamedResponse
{
    $fileName = 'sales_report.csv';
    $orders = Order::with(['user', 'items.product'])->get();

    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = ['Order ID', 'User', 'Order Date', 'Total Amount', 'Status', 'Payment', 'Shipping Name', 'Address', 'Contact', 'Products', 'Quantities'];

    $callback = function() use ($orders, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($orders as $order) {
            $products = $order->items->pluck('product.name')->join('; ');
            $quantities = $order->items->pluck('quantity')->join('; ');

            fputcsv($file, [
                $order->id,
                $order->user->name ?? 'N/A',
                $order->created_at,
                number_format($order->total_amount, 2),
                $order->status,
                $order->payment_method,
                $order->shipping_name,
                $order->shipping_address,
                $order->contact_number,
                $products,
                $quantities,
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}
