<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLedgerRequest;
use App\Http\Requests\UpdateLedgerRequest;
use App\Http\Resources\LedgerResource;
use App\Models\Ledger;
use App\Models\Supplier;
use App\Queries\LedgerQuery;
use Illuminate\Http\Request;
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
        $ledgers = $this->ledgerQuery->query()->with(['supplier'])->paginate();
        // return collection
        return LedgerResource::collection($ledgers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLedgerRequest $request)
    {
        // validate and store
        $ledger = Ledger::create($request->validated());
        // return created resource
        return $this->success(LedgerResource::make($ledger), 'Ledger Created', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ledger_id)
    {
        // find or fail
        $ledger = $this->ledgerQuery->query()->findOrFail($ledger_id);
        // return resource
        return new LedgerResource($ledger);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLedgerRequest $request, Ledger $ledger)
    {
        // validate and update
        $ledger->update($request->validated());
        // return updated resource
        return $this->success(LedgerResource::make($ledger), 'Ledger Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ledger $ledger)
    {
        // destroy
        $ledger->delete();
        // return no content response
        return $this->success([], 'Ledger Deleted', 204);
    }
}
