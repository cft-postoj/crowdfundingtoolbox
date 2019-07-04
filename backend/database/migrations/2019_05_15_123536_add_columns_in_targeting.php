<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInTargeting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('targeting', function (Blueprint $table) {
            $table->boolean('one_time_min')->default(false);
            $table->integer('one_time_min_value')->default(50);
            $table->boolean('one_time_max')->default(false);
            $table->integer('one_time_max_value')->default(100);

            $table->boolean('monthly_older_than')->default(false);
            $table->integer('monthly_older_than_value')->default(30);
            $table->boolean('monthly_not_older_than')->default(false);
            $table->integer('monthly_not_older_than_value')->default(360);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('targeting', function (Blueprint $table) {
            //
        });
    }
}
