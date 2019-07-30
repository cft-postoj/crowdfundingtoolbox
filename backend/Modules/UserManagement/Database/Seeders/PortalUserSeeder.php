<?php

namespace Modules\UserManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Payment\Services\VariableSymbolService;
use Modules\UserManagement\Entities\DonorStatus;
use Modules\UserManagement\Entities\User;
use Modules\UserManagement\Entities\UserDetail;
use Modules\UserManagement\Repositories\UserGdprRepository;
use Modules\UserManagement\Repositories\UserPaymentOptionsRepository;
use Carbon\Carbon;


class PortalUserSeeder extends Seeder
{

    protected $variableSymbolService;
    protected $userGdprRepository;
    protected $userPaymentOptionsRepository;
    private $randomDate;

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
        $this->randomDate = Carbon::now()->subDays(rand(0, 150));
        factory(User::class, 10)->create([
            'created_at' => $this->randomDate,
            'updated_at' => $this->randomDate
        ])->each(function (User $user) {
            $user->save();
            $newUser = $user->portalUser()->create([
                'user_id' => $user->id,
                'created_at' => $this->randomDate,
                'updated_at' => $this->randomDate
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
            $userDetail['created_at'] = $this->randomDate;
            $userDetail['updated_at'] = $this->randomDate;
            $userDetail->save();

//            $user->userDetail()->factory(User::class, 10)->create();

        });

    }
}