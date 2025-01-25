<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLedgerRequest;
use App\Http\Requests\UpdateLedgerRequest;
use App\Http\Resources\LedgerResource;
use App\Models\Ledger;
use App\Models\Supplier;
use App\Queries\LedgerQuery;
use Inertia\Inertia;

class LedgerController extends Controller
{
    public function __construct(protected LedgerQuery $ledgerQuery)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all ledgers
        $ledgers = $this->ledgerQuery->query()->with(['supplier'])->get();
        return Inertia::render('Ledger/Index', ['ledgers' => LedgerResource::collection($ledgers)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        // return create page
        return Inertia::render('Ledger/Create', ['suppliers' => $suppliers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLedgerRequest $request)
    {
        // validate and store
        Ledger::create($request->validated());
        return redirect()->route('ledgers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ledger $ledger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ledger $ledger)
    {
        $suppliers = Supplier::all();
        return Inertia::render('Ledger/Edit', ['ledger' => LedgerResource::make($ledger), 'suppliers' => $suppliers]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLedgerRequest $request, Ledger $ledger)
    {
        // validate and update
        $ledger->update($request->validated());
        return redirect()->route('ledgers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ledger $ledger)
    {
        // destroy
        $ledger->delete();
        return redirect()->route('ledgers.index');
    }
}
