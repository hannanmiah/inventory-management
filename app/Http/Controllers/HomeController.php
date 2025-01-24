<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Concurrency;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        [$products, $suppliers, $purchases, $ledgers] = Concurrency::run([
            function () {
                return Product::count();
            },
            function () {
                return Supplier::count();
            },
            function () {
                return Purchase::count();
            },
            function () {
                return Ledger::count();
            }
        ]);
        return Inertia::render('Index', [
            'totalProducts' => $products,
            'totalSuppliers' => $suppliers,
            'totalPurchases' => $purchases,
            'totalLedgers' => $ledgers,
        ]);
    }
}
