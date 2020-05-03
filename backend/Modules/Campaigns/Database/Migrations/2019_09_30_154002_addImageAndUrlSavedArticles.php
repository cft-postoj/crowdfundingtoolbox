<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageAndUrlSavedArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('thumbnail_url')->nullable();
            $table->string('url')->nullable();
            $table->string('description')->nullable();
            $table->string('category')->nullable();
            $table->string('category_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('thumbnail_url');
            $table->dropColumn('url');
            $table->dropColumn('description');
            $table->dropColumn('category');
            $table->dropColumn('category_url');
        });
    }
}
