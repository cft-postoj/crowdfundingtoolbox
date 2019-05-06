<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class CreateWidgetTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widget_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('description');
            $table->string('method')->unique();
            $table->boolean('global_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('widget_types')->insert(
            array(
                array(
                    'name' => 'Landing page',
                    'description' => 'Main widget with donating.',
                    'method' => 'landing'
                ),
                array(
                    'name' => 'Sidebar',
                    'description' => 'Sidebar widget (300x600).',
                    'method' => 'sidebar'
                ),
                array(
                    'name' => 'Leaderboard',
                    'description' => 'Widget before or after article which is on full width of parent container.',
                    'method' => 'leaderboard'
                ),
                array(
                    'name' => 'Pop-up',
                    'description' => 'Popup widget. This widget is visible once per 30 minutes (value is set in localstorage).',
                    'method' => 'popup'
                ),
                array(
                    'name' => 'Fixed widget',
                    'description' => 'Fixed widget is like cookie bar (top or bottom of website).',
                    'method' => 'fixed'
                ),
                array(
                    'name' => 'Locked article',
                    'description' => 'Widget which lock content of article.',
                    'method' => 'locked'
                ),
                array(
                    'name' => 'Article widget',
                    'description' => 'Widget inside article.',
                    'method' => 'article'
                ),
                array(
                    'name' => 'Article link',
                    'description' => 'Text widget with link.',
                    'method' => 'article_link'
                ),
                array(
                    'name' => 'Custom HTML + CSS',
                    'description' => 'Widget with custom HTML and CSS code.',
                    'method' => 'custom'
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
        Schema::dropIfExists('widget_types');
    }
}
