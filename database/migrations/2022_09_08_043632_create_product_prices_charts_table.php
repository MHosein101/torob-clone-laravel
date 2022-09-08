<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricesChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices_charts', function (Blueprint $table) {
            $table->id();
            
            $table->string("date");
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('average_price');
            
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
        Schema::dropIfExists('product_prices_charts');
    }
}
