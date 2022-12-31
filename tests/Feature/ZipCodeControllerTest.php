<?php

namespace Tests\Feature;

use App\Models\Settlement;
use App\Models\ZipCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ZipCodeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check that the information returned matches the information initially generated.
     *
     * @return void
     */
    public function test_that_the_information_is_equal_to_the_generated_information(): void
    {
        $zipCode = ZipCode::factory()
            ->forFederalEntity()
            ->forMunicipality()
            ->has(Settlement::factory()->forSettlementType()->count(5))
            ->create();
        $response = $this->get("/api/zip-codes/$zipCode->zip_code");

        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->where('zip_code', $zipCode->zip_code)
                ->where('locality', $zipCode->locality)
                ->where('federal_entity.key', $zipCode->federalEntity->id)
                ->where('federal_entity.name', $zipCode->federalEntity->name)
                ->where('federal_entity.code', $zipCode->federalEntity->code)
                ->where('municipality.key', $zipCode->municipality->key)
                ->where('municipality.name', $zipCode->municipality->name)
                ->etc()
            );
    }

    /**
     * Check that the structure of the JSON matches the one defined.
     *
     * @return void
     */
    public function test_that_the_information_has_the_correct_structure(): void
    {
        $zipCode = ZipCode::factory()
            ->forFederalEntity()
            ->forMunicipality()
            ->has(Settlement::factory()->forSettlementType()->count(5))
            ->create();
        $response = $this->get("/api/zip-codes/$zipCode->zip_code");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'zip_code',
                'locality',
                'federal_entity' => [
                    'key',
                    'name',
                    'code',
                ],
                'settlements' => [
                    '*' => [
                        'key',
                        'name',
                        'zone_type',
                        'settlement_type' => [
                            'name',
                        ],
                    ],
                ],
                'municipality' => [
                    'key',
                    'name',
                ]
            ]);
    }

    /**
     * Check that the types of the returned variables are as required.
     *
     * @return void
     */
    public function tests_that_the_types_of_the_returned_variables_are_the_required_ones(): void
    {
        $zipCode = ZipCode::factory()
            ->forFederalEntity()
            ->forMunicipality()
            ->has(Settlement::factory()->forSettlementType()->count(1))
            ->create();
        $response = $this->get("/api/zip-codes/$zipCode->zip_code");

        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->whereAllType([
                    'zip_code' => 'string',
                    'locality' => 'string',
                    'federal_entity' => 'array',
                    'federal_entity.key' => 'integer',
                    'federal_entity.name' => 'string',
                    'settlements' => 'array',
                    'settlements.0.key' => 'integer',
                    'settlements.0.name' => 'string',
                    'settlements.0.settlement_type' => 'array',
                    'settlements.0.settlement_type.name' => 'string',
                    'municipality' => 'array',
                    'municipality.key' => 'integer',
                    'municipality.name' => 'string',
                ])
            );
    }
}
