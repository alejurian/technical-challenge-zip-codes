<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZipCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $settlements = [];
        foreach ($this->settlements as $settlement) {
            $settlements[] = [
               'key' => $settlement['key'],
               'name' => $settlement['name'],
               'zone_type' => $settlement['zone_type'],
               'settlement_type' => [
                   'name' => $settlement['settlementType']['name'],
               ],
            ];
        }
        return [
            'zip_code' => $this->zip_code,
            'locality' => $this->locality,
            'federal_entity' => [
                'key' => $this->federalEntity->id,
                'name' => $this->federalEntity->name,
                'code' => $this->federalEntity->code,
            ],
            'settlements' => $settlements,
            'municipality' => [
                'key' => $this->municipality->key,
                'name' => $this->municipality->name,
            ],
        ];
    }
}
