<?php

namespace Tests\Unit;

use App\Imports\ZipCodesByStateImport;
use PHPUnit\Framework\TestCase;

class ZipCodeImportTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_the_function_that_removes_the_accents_works_correctly(): void
    {
        $word = 'México';
        $wordWithoutAccent = ZipCodesByStateImport::stripAccents($word);

        $this->assertEquals('Mexico', $wordWithoutAccent);
    }
}
