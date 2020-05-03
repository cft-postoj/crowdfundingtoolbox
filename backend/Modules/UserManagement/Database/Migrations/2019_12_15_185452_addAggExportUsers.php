<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAggExportUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agg_export_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('donor_id');
            $table->foreign('donor_id')->references('id')->on('portal_users');
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('street');
            $table->string('city');
            $table->string('zip');
            $table->string('donor_type');
            $table->string('iban');
            $table->string('variable_symbol');
            $table->string('register_in');
            $table->string('transfer_type');
            $table->string('last_donation_date');
            $table->decimal('declared_amount');
            $table->string('recruited_date'); // ak sa clovek po case vratil k prispievaniu
            $table->json('monthly_donations');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('agg_export_users');
    }
}

