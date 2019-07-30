<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('telephone')->nullable();
            $table->string('generate_password_token')->nullable(); // for emailing user and change password
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('users')->insert(
            array(
                array(
                    'username' => 'admin',
                    'email' => 'test@crowdfundingtoolbox.news',
                    'password' => bcrypt('test123'),
                    'first_name'    =>  'Test',
                    'last_name' =>  'Account'
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
        Schema::dropIfExists('users');
    }
}
