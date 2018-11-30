<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bucket_name');
            $table->string('client_type')->nullable();
            $table->float('latitude', 12, 8)->nullable();
            $table->float('longitude', 12, 8)->nullable();
            $table->string('bs_name')->nullable();
            $table->integer('deleted')->default('0');
            $table->date('deleted_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_locations');
    }
}
