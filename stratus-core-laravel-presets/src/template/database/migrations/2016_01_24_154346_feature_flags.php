<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class FeatureFlags extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('feature_flags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->text('variants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('feature_flags');
    }
}
