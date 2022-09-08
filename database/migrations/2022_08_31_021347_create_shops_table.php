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
            
            $table->string("title")->unique();
            
            $table->string("province")->default("");
            $table->string("city")->default("");
            $table->string("address")->default("");

            $table->string("owner")->default("");
            $table->string("status")->default("");
            $table->string("rate")->default("");

            $table->string("site_url")->default("");
            $table->string("logo_url")->default("");

            $table->unsignedBigInteger("started_time")->default(0);

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
        Schema::dropIfExists('shops');
    }
}
