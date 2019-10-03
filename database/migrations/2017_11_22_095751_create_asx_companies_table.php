<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsxCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asx_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('asx_code', 5);
            $table->string('sector', 100);
            $table->string('twitter_code', 10);
            $table->string('twitter_link', 100);
            $table->string('facebook_link', 100);
            $table->string('website', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asx_companies');
    }
}
