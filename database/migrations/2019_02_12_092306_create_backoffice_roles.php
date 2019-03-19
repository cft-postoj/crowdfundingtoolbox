<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackofficeRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backoffice_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('backoffice_roles')->insert(
            array(
                array(
                    'name' => 'Administrator',
                    'slug' => 'admin'
                ),
                array(
                    'name'  =>  'Manager',
                    'slug'  =>  'manager'
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
        Schema::dropIfExists('backoffice_roles');
    }
}
