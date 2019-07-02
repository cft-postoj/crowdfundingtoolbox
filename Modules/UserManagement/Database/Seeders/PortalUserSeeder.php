<?php

namespace Modules\UserManagement\Database\Seeders;

use Modules\Payment\Services\VariableSymbolService;
use Modules\UserManagement\Entities\User;
use Illuminate\Database\Seeder;
use Modules\UserManagement\Entities\UserDetail;
use Modules\UserManagement\Repositories\UserGdprRepository;


class PortalUserSeeder extends Seeder
{

    protected $variableSymbolService;
    protected $userGdprRepository;

    public function __construct(VariableSymbolService $variableSymbolService,
                                UserGdprRepository $userGdprRepository)
    {
        $this->variableSymbolService = $variableSymbolService;
        $this->userGdprRepository = $userGdprRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create()->each(function (User $user) {
            $user->save();
            $newUser = $user->portalUser()->create([
                'user_id' => $user->id
            ]);
            $this->variableSymbolService->create($newUser->id);
            $this->userGdprRepository->create(array(
                'agreeMailing' => false,
                'agreePersonalData' => true,
            ), $newUser->id);

            $userDetail = factory(UserDetail::class)->make();
            $userDetail['user_id'] = $user->id;
            $userDetail->save();
//            $user->userDetail()->factory(User::class, 10)->create();

        });

    }
}