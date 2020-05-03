<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAggTargetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create aggregation table for targeting (only for signed users)
        Schema::create('agg_targeting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('portal_user_id')->unique()->nullable();
            $table->foreign('portal_user_id')->references('id')->on('portal_users');
            $table->bigInteger('user_id')->unique()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->boolean('has_valid_address')->default(false);
            $table->boolean('is_supporter')->default(false);
            $table->integer('last_donation_before')->nullable();
            $table->decimal('last_donation_value')->nullable();
            $table->bigInteger('last_donation_id')->nullable();
            $table->foreign('last_donation_id')->references('id')->on('donations');
            $table->boolean('monthly_supporter')->default(false);
            $table->json('all_donations')->nullable();
            $table->integer('read_articles_today')->nullable();
            $table->integer('read_articles_week')->nullable();
            $table->integer('read_articles_month')->nullable();
            $table->date('unlocked_at')->nullable();
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
        Schema::drop('agg_targeting');
    }
}


