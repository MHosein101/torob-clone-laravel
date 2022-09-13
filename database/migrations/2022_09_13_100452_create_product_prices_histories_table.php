<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricesHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices_histories', function (Blueprint $table) {
            $table->id();
            
            $table->string('type');
            $table->unsignedBigInteger('new_price');
            $table->unsignedBigInteger('change_time');

            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_prices_histories');
    }
}
