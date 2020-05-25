<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class EcoCodTableSeeder extends CsvSeeder
{
    /**
     * IbanTableSeeder constructor.
     */
    public function __construct()
    {
        $this->table = 'eco_cod';
        $this->csv_delimiter = ',';
        $this->filename = base_path().'/resources/db/eco_ca.csv';
        $this->mapping = [
            0 => 'cod',
            1 => 'nume'
        ];
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
