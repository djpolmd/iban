<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class IbanTableSeeder extends CsvSeeder
{
    /**
     * IbanTableSeeder constructor.
     */
    public function __construct()
    {
        $this->table = 'iban';
        $this->insert_chunk_size = 20;
        $this->csv_delimiter = ',';
        $this->filename = base_path().'/resources/db/iban_2020.csv';
        $this->mapping = [
            0 => 'cod_eco',
            1 => 'cod_local',
            2 => 'cod_raion',
            3 => 'iban',
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
