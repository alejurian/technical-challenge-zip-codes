<?php

namespace App\Imports;

use App\Models\FederalEntity;
use App\Models\Municipality;
use App\Models\SettlementType;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class ZipCodesByStateImport implements OnEachRow, WithHeadingRow
{
    /**
     * @param Row $row
     * @return void
     */
    public function onRow(Row $row): void
    {
        $row = array_map('App\Imports\ZipCodesByStateImport::stripAccents', $row->toArray());
        $row = array_map('strtoupper', $row);
        $row = array_map('utf8_encode', $row);
        if (isset($row['d_estado'])) {
            $federalEntity = FederalEntity::firstOrCreate([
                'name' => $row['d_estado'],
            ]);
            $municipality = Municipality::firstOrCreate([
                'key' => $row['c_mnpio'],
                'name' => $row['d_mnpio'],
            ]);
            $zipCode = $federalEntity->zipCodes()->firstOrCreate(
                ['zip_code' => $row['d_codigo']],
                [
                    'locality' => $row['d_ciudad'],
                    'municipality_id' => $municipality->id,
                ],
            );
            $settlementType = SettlementType::firstOrCreate([
                'name' => ucfirst(strtolower($row['d_tipo_asenta'])),
            ]);
            $zipCode->settlements()->create([
                'key' => $row['id_asenta_cpcons'],
                'name' => $row['d_asenta'],
                'zone_type' => $row['d_zona'],
                'settlement_type_id' => $settlementType->id,
            ]);
        }
    }

    /**
     * Removes accents from a given text.
     * @param string|null $str Text that will be removed the accents.
     * @return string
     */
    static function stripAccents(?string $str): string
    {
        return strtr(
            utf8_decode($str),
            utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
        );
    }
}
