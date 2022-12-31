<?php

namespace App\Console\Commands;

use App\Imports\ZipCodesImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class ProcessZipCodeFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes the Mexican Postal Service zip code file and saves the data in the database.';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws Exception
     */
    public function handle()
    {
        $filePath = storage_path('app/CPdescarga.xls');
        $reader = new Xls();
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($filePath);
        $sheetNames = collect($spreadsheet->getSheetNames());

        foreach ($sheetNames as $key => $sheetName) {
            if ($sheetName === 'Nota') {
                $sheetNames->forget($key);
            }
        }

        foreach ($sheetNames as $key => $sheetName) {
            if ($key < 24) {
                $sheetNames->forget($key);
            }
        }

        Excel::import(new ZipCodesImport($sheetNames), $filePath);
        return Command::SUCCESS;
    }
}
