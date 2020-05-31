<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIbansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ibans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod_eco', 6);
            $table->string('cod_local',4);
            $table->string('cod_raion',2);
            $table->string('iban',24);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ibans');
    }
}
