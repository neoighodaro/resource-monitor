<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResourceTimeRange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resources', function ($table) {
            $table->time('resource_starts')->after('type')->nullable();
            $table->time('resource_ends')->after('resource_starts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resources', function (Blueprint $table){
            $table->dropColumn('resource_starts');
            $table->dropColumn('resource_ends');
        });
    }
}


