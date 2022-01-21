<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableAddApiToken extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('api_token', 60)->nullable()->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
}
