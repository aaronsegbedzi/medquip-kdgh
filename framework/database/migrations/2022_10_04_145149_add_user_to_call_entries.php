<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserToCallEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('call_entries', function (Blueprint $table) {
            $table->integer('user_attended_2')->nullable()->after('user_attended');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('call_entries', function (Blueprint $table) {
            $table->dropColumn('user_attended_2');
        });
    }
}
