<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackofficeUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backoffice_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unique();
            $table->integer('role_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('backoffice_roles');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('backoffice_users')->insert(
            array(
                array(
                    'user_id' => 1,
                    'role_id' => 1
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
        Schema::dropIfExists('backoffice_users');
    }
}
