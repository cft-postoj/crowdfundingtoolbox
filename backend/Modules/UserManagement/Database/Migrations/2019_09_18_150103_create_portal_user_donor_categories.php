<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortalUserDonorCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portal_user_donor_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('portal_user_id');
            $table->foreign('portal_user_id')->references('id')->on('portal_users');
            $table->integer('donor_category_id')->nullable();
            $table->foreign('donor_category_id')->references('id')->on('donor_categories');;
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('automatically_calculated')->default(true);
            $table->boolean('manually_created')->default(false);
            $table->integer('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->softDeletes();
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
        Schema::dropIfExists('');
    }
}
