<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PricingService;
use App\Models\Pricing;
use App\Http\Requests\Pricing\StorePricingRequest;
use App\Http\Requests\Pricing\UpdatePricingRequest;

class PricingController extends Controller
{

    private PricingService $pricingService;

    public function __construct(PricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }


    public function index()
    {
        return response()->json($this->pricingService->index());
    }


    public function store(StorePricingRequest $request)
    {

        $pricing = $this->pricingService->store($request->validated());


        return response()->json([
            'message' => "Pricing created successfully.",
            'data' => $pricing,
        ], 201);
    }


    public function show(Pricing $pricing)
    {
        return response()->json(
            $this->pricingService->show($pricing)
        );
    }


    public function update(UpdatePricingRequest $request, Pricing $pricing)
    {
        return response()->json(
            $this->pricingService->update($pricing, $request->validated())
        );
    }


    public function destroy(Pricing $pricing)
    {
        $this->pricingService->destroy($pricing);

        return response()->json([
            'message' => 'Pricing deleted successfully.'
        ]);
    }
}
