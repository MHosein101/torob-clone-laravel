<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopOrderTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_order_trackings', function (Blueprint $table) {
            $table->id();
            
            // $table->string("state");
            // $table->unsignedBigInteger("submit_date");
            
            // $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('shop_order_trackings');
    }
}
