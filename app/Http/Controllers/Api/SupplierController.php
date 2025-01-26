<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Queries\SupplierQuery;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller
{

    public function __construct(protected SupplierQuery $supplierQuery)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all suppliers
        $suppliers = $this->supplierQuery->query()->paginate();
        // return resource collection
        return SupplierResource::collection($suppliers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        // validate and store
        Supplier::create($request->validated());
        // return success
        return $this->success(SupplierResource::make(Supplier::latest()->first()), 'Supplier Created', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $supplier_id)
    {
        // find or fail
        $supplier = $this->supplierQuery->query()->findOrFail($supplier_id);
        // return resource
        return SupplierResource::make($supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        // validate and update
        $supplier->update($request->validated());
        // return updated resource
        return $this->success(SupplierResource::make($supplier), 'Supplier Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        // destroy
        $supplier->delete();
        // return success
        return $this->success([], 'Supplier Deleted', 204);
    }
}
