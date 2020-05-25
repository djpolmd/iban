<?php

use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;

class IbanTableSeeder extends CsvSeeder
{
    /**
     * IbanTableSeeder constructor.
     */
    public function __construct()
    {
        $this->table = 'iban';
        $this->filename = base_path().'/resource/db/.csv';
    }

    /**
     *  Run instance
     */
    public function run()
    {
        // Recommended when importing larger CSVs
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        DB::table($this->table)->truncate();

        parent::run();
    }

}
