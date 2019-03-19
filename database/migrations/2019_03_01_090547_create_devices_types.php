<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('name');
            $table->timestamps();
        });
        DB::table('devices_types')->insert(
            array(
                array(
                    'type' => 'desktop',
                    'name' => 'Desktop'
                ),
                array(
                    'type' => 'tablet',
                    'name' => 'Tablet',
                ),
                array(
                    'type' => 'mobile',
                    'name' => 'Mobile'
                )
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices_types');
    }
}
