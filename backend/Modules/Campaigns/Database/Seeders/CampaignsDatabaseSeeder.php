<?php

namespace Modules\Campaigns\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CampaignsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CreateDummyCampaignSeeder::class);

        // $this->call("OthersTableSeeder");
    }
}
