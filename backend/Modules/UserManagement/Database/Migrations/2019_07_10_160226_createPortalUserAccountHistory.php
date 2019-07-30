<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortalUserAccountHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_history_portal_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('portal_user_id');
            $table->foreign('portal_user_id')->references('id')->on('portal_users');
            $table->longText('update_description');
            $table->json('previous_data');
            $table->integer('updated_backoffice_user')->nullable();
            $table->foreign('updated_backoffice_user')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
