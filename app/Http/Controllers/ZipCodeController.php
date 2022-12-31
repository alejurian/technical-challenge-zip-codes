<?php

namespace App\Http\Controllers;

use App\Http\Resources\ZipCodeResource;
use App\Models\ZipCode;
use Illuminate\Http\JsonResponse;

class ZipCodeController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param ZipCode $zipCode
     * @return JsonResponse
     */
    public function show(ZipCode $zipCode): JsonResponse
    {
        $zipCode->load([
            'federalEntity:id,name,code',
            'settlements:id,key,name,zone_type,settlement_type_id,zip_code_id',
            'settlements.settlementType:id,name',
            'municipality:id,key,name',
        ]);
        return response()->json(new ZipCodeResource($zipCode));
    }
}
