<?php

namespace App\Services;

use App\Models\Pricing;

class PricingService
{

    public function index()
    {
        return Pricing::latest()->get();
    }

    public function store(array $data)
    {
        return Pricing::create($data);
    }

    public function show(Pricing $pricing)
    {
        return $pricing;
    }

    public function update(Pricing $pricing, array $data)
    {
        $pricing->update($data);

        return $pricing->fresh();
    }

    public function destroy(Pricing $pricing)
    {
        $pricing->delete();
    }

}