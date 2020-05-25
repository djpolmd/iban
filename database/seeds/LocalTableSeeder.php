<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class LocalTableSeeder extends CsvSeeder
{
    /**
     * IbanTableSeeder constructor.
     */
    public function __construct()
    {
        $this->table = 'localities';
        $this->csv_delimiter = ',';
        $this->filename = base_path().'/resources/db/iban_locality.csv';
        $this->mapping = [
            0 => 'cod1',
            1 => 'cod2',
            2 => 'cod3',
            3 => 'name',
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
