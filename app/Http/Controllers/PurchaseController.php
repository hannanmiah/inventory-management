<?php

namespace App\Http\Controllers;

use App\Actions\Purchase\CreateItems;
use App\Actions\Purchase\UpdateItems;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Http\Resources\PurchaseResource;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Queries\PurchaseQuery;
use Illuminate\Support\Facades\Concurrency;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    public function __construct(protected PurchaseQuery $purchaseQuery)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::select(['id', 'name'])->get();
        // get all purchases
        $purchases = $this->purchaseQuery->query()->with(['supplier', 'purchaseItems.product'])->get();
        return Inertia::render('Purchase/Index', ['purchases' => PurchaseResource::collection($purchases), 'suppliers' => $suppliers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        [$suppliers, $products] = Concurrency::run([
            function () {
                return Supplier::select(['id', 'name'])->get();
            },
            function () {
                return Product::select(['id', 'name'])->get();
            }
        ]);
        // return create page
        return Inertia::render('Purchase/Create', ['suppliers' => $suppliers, 'products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        // validate and store
        $purchase = Purchase::create($request->validated());
        if ($request->has('items')) {
            CreateItems::run($purchase, $request->input('items', []));
        }
        return redirect()->route('purchases.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        [$suppliers, $products] = Concurrency::run([
            function () {
                return Supplier::select(['id', 'name'])->get();
            },
            function () {
                return Product::select(['id', 'name'])->get();
            }
        ]);
        $purchase->load(['purchaseItems']);
        // return edit page
        return Inertia::render('Purchase/Edit', ['purchase' => PurchaseResource::make($purchase), 'suppliers' => $suppliers, 'products' => $products]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        // validate and update
        $purchase->update($request->validated());
        if ($request->has('items')) {
            UpdateItems::run($purchase, $request->input('items', []));
        }
        return redirect()->route('purchases.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        // destroy
        $purchase->delete();
        return redirect()->route('purchases.index');
    }
}
