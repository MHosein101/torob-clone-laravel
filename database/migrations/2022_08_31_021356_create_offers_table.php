<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            
            $table->string('title');
            $table->unsignedBigInteger('price');
            $table->boolean('is_available')->default(true);

            $table->string('guarantee')->default('');
            $table->boolean('is_mobile_registered')->nullable()->default(null);

            $table->string('redirect_url')->default('');
            $table->unsignedBigInteger('last_update')->default(time());

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('shop_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
