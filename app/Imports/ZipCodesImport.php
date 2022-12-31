<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ZipCodesImport implements WithMultipleSheets, WithChunkReading
{
    private Collection $sheetNames;

    public function __construct(Collection $sheetNames)
    {
        $this->sheetNames = $sheetNames;
    }

    public function sheets(): array
    {
        return $this->sheetNames->flatMap(fn ($item) => [$item => new ZipCodesByStateImport()])->toArray();
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
