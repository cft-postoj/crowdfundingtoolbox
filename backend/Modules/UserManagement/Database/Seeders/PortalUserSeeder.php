<?php

namespace Modules\UserManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Payment\Services\VariableSymbolService;
use Modules\UserManagement\Entities\User;
use Modules\UserManagement\Entities\UserDetail;
use Modules\UserManagement\Repositories\UserGdprRepository;
use Modules\UserManagement\Repositories\UserPaymentOptionsRepository;


class PortalUserSeeder extends Seeder
{

    protected $variableSymbolService;
    protected $userGdprRepository;
    protected $userPaymentOptionsRepository;

    public function __construct(VariableSymbolService $variableSymbolService,
                                UserGdprRepository $userGdprRepository,
                                UserPaymentOptionsRepository $userPaymentOptionsRepository)
    {
        $this->variableSymbolService = $variableSymbolService;
        $this->userGdprRepository = $userGdprRepository;
        $this->userPaymentOptionsRepository = $userPaymentOptionsRepository;
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

            $this->userPaymentOptionsRepository->create(array(
                'portal_user_id' => $newUser->id,
                'pairing_type' => 'variable_symbol'
            ));

            $userDetail = factory(UserDetail::class)->make();
            $userDetail['user_id'] = $user->id;
            $userDetail->save();

//            $user->userDetail()->factory(User::class, 10)->create();

        });

    }
}