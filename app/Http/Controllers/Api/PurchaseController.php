<?php

namespace App\Http\Controllers\Api;

use App\Actions\Purchase\CreateItems;
use App\Actions\Purchase\UpdateItems;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Http\Resources\PurchaseResource;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Queries\PurchaseQuery;
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
        // get all purchases
        $purchases = $this->purchaseQuery->query()->paginate();
        return PurchaseResource::collection($purchases);
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
        // return success response
        return $this->success(PurchaseResource::make($purchase), 'Purchase Created', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $purchase_id)
    {
        // find or fail
        $purchase = $this->purchaseQuery->query()->findOrFail($purchase_id);
        // return resource
        return PurchaseResource::make($purchase);
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
        // return updated resource
        return $this->success(PurchaseResource::make($purchase), 'Purchase Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        // destroy
        $purchase->delete();
        // return success response
        return $this->success([], 'Purchase Deleted', 204);
    }
}
