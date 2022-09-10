<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            
            $table->string('title');
            $table->string('province');
            $table->string('city')->default('');
            // $table->string('address')->default('');
            // $table->string('site_url')->default('');
            // $table->string('logo_url')->default('');
            $table->tinyInteger('rate');

            // $table->string('license_owner')->default('');
            // $table->string('license_status')->default('');
            // $table->integer('license_star')->default(1);
            // $table->string('license_obtain_date')->default('');
            // $table->string('license_expire_date')->default('');

            // $table->string('cooperation_join')->default('');
            // $table->string('cooperation_status')->default('');
            $table->unsignedBigInteger('cooperation_activity');

            // $table->string('payment_detail');

            $table->string('delivery_methods');
            $table->string('delivery_attention');
            // $table->string('delivery_detail');
            // $table->string('delivery_link')->default('');

            $table->string('advantage_inplace_pay');
            $table->string('advantage_instant_delivery');
            $table->string('advantage_free_delivery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
