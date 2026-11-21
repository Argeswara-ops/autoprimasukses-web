<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PurchaseOrderController extends Controller
{
    // Show list of purchase orders
    public function index()
    {
        $orders = PurchaseOrder::with('product')->get();

        return view('purchase_orders.index', compact('orders'));
    }

    // Show suggestion form (just a button to calculate)
    public function suggest()
    {
        return view('purchase_orders.suggest');
    }

    // Calculate suggested PO from Excel data
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'excel_file' => ['required', 'file', 'mimes:xlsx,xls', 'max:10240'],
        ]);

        $excelPath = $validated['excel_file']->store('purchase-orders', 'local');
        $absolutePath = storage_path('app/private/'.$excelPath);
        if (! file_exists($absolutePath)) {
            $absolutePath = storage_path('app/'.$excelPath);
        }

        $spreadsheet = IOFactory::load($absolutePath);
        // Assuming sheet name "Jatim" contains columns: Product Name, Avg Monthly Sales (units)
        $sheet = $spreadsheet->getSheetByName('Jatim');
        if (! $sheet) {
            return redirect()->back()->with('error', 'Sheet Jatim not found in Excel.');
        }
        $data = $sheet->toArray(null, true, true, true);
        // Assume first row is header
        $header = $data[1];
        $nameCol = null;
        $avgCol = null;
        foreach ($header as $col => $value) {
            $val = strtolower(trim($value));
            if (strpos($val, 'product') !== false) {
                $nameCol = $col;
            }
            if (strpos($val, 'avg') !== false) {
                $avgCol = $col;
            }
        }
        if (! $nameCol || ! $avgCol) {
            return redirect()->back()->with('error', 'Required columns not found in sheet.');
        }
        DB::transaction(function () use ($data, $nameCol, $avgCol) {
            foreach (array_slice($data, 1) as $row) {
                $productName = $row[$nameCol];
                $avgSales = (int) $row[$avgCol];
                if (empty($productName)) {
                    continue;
                }
                $product = Product::where('name', $productName)->first();
                if (! $product) {
                    continue;
                }
                $boxes = (int) ceil($avgSales / $product->box_content);
                $cost = $boxes * $product->purchase_price * $product->box_content;
                PurchaseOrder::updateOrCreate(
                    ['product_id' => $product->id],
                    [
                        'average_monthly_sales' => $avgSales,
                        'suggested_boxes' => $boxes,
                        'total_estimated_cost' => $cost,
                    ]
                );
            }
        });

        return redirect()->route('purchase_orders.index')->with('success', 'Suggest PO calculated and stored.');
    }
}
