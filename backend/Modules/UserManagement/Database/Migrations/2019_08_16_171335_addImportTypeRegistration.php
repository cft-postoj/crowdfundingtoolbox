<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddImportTypeRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('portal_users', function (Blueprint $table) {
//
//        });
        DB::statement('ALTER TABLE PORTAL_USERS DROP CONSTRAINT PORTAL_USERS_REGISTER_BY_CHECK');
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
