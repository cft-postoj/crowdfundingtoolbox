<?php

namespace Modules\UserManagement\Database\Seeders;

use Modules\UserManagement\Entities\User;
use Illuminate\Database\Seeder;
use Modules\UserManagement\Entities\UserDetail;


class PortalUserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create()->each(function (User $user) {
            $user->save();
            $user->portalUser()->make([
                'user_id' => $user->id
            ])->save();

            $userDetail = factory(UserDetail::class)->make();
            $userDetail['user_id'] =$user->id;
            $userDetail->save();
//            $user->userDetail()->factory(User::class, 10)->create();

        });

    }
}