<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    // Generate sales report
    public function index(Request $request)
    {
        // 1. Start a query on the Order model
        $query = Order::with(['user', 'items.product']);

        // 2. Apply Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Apply Date Range Filters
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // 4. Get the results (Filtered or All)
        $orders = $query->latest()->get();

        // 5. Calculate Total Sales for the results
        $totalSales = $orders->sum('total_amount');

        // 6. Calculate Summary (Orders per Product)
        $productOrderCounts = [];
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $productName = $item->product->name ?? 'Unknown Product';
                $productOrderCounts[$productName] = ($productOrderCounts[$productName] ?? 0) + 1;
            }
        }

        // Return the existing view path with the compact variables
        return view('admin.reports.index', compact('totalSales', 'orders', 'productOrderCounts'));
    }

    public function export(Request $request): StreamedResponse
    {
        $fileName = 'sales_report.csv';
        
        // Ensure export also respects filters
        $query = Order::with(['user', 'items.product']);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('start_date')) $query->whereDate('created_at', '>=', $request->start_date);
        if ($request->filled('end_date')) $query->whereDate('created_at', '<=', $request->end_date);
        
        $orders = $query->get();

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