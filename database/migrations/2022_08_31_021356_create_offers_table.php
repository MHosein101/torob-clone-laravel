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
            
            $table->string("title");
            $table->unsignedBigInteger("price");
            $table->boolean("is_available")->default(true);
            $table->string("guarantee")->default('');
            $table->string("redirect_url")->default('');

            $table->boolean("is_mobile_registered")->default(true);
            
            $table->unsignedBigInteger("last_update")->default(0);

            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('shop_id')->nullable();
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
