<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Queries\SupplierQuery;
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
        $suppliers = $this->supplierQuery->query()->get();
        // return index page
        return Inertia::render('Supplier/Index', ['suppliers' => SupplierResource::collection($suppliers)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return create form
        return Inertia::render('Supplier/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        // validate and store
        Supplier::create($request->validated());
        return redirect()->route('suppliers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        // return edit form
        return Inertia::render('Supplier/Edit', ['supplier' => SupplierResource::make($supplier)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        // validate and update
        $supplier->update($request->validated());
        return redirect()->route('suppliers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        // destroy
        $supplier->delete();
        return redirect()->route('suppliers.index');
    }
}
