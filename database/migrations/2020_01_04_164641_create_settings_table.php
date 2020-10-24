<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('logo');
            $table->String('favicon');
            $table->String('title');
            $table->String('header1');
            $table->String('header2');
            $table->String('facebook');
            $table->String('twitter');
            $table->String('youtube');
            $table->String('address');
            $table->String('phone');
            $table->String('gmail');
            $table->String('description');
            $table->String('footer');
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
        Schema::dropIfExists('settings');
    }
}
