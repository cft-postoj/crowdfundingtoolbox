<?php


namespace Modules\UserManagement\Services;


use Illuminate\Http\Response;
use Modules\UserManagement\Repositories\PortalUserRepository;
use Modules\UserManagement\Repositories\UserDetailRepository;
use JWTAuth;
use Modules\UserManagement\Repositories\UserGdprRepository;
use Modules\UserManagement\Repositories\UserPaymentOptionsRepository;
use Modules\UserManagement\Repositories\UserRepository;

class UserDetailService implements UserDetailServiceInterface
{
    private $userDetailRepository;
    private $userGdprRepository;
    private $portalUserRepository;
    private $userRepository;
    private $user;
    private $portalUserId;
    private $userPaymentOptionsRepository;

    public function __construct(UserDetailRepository $userDetailRepository,
                                UserGdprRepository $userGdprRepository,
                                PortalUserRepository $portalUserRepository,
                                UserRepository $userRepository,
                                UserPaymentOptionsRepository $userPaymentOptionsRepository)
    {
        $this->userDetailRepository = $userDetailRepository;
        $this->userGdprRepository = $userGdprRepository;
        $this->portalUserRepository = $portalUserRepository;
        $this->userRepository = $userRepository;
        $this->userPaymentOptionsRepository = $userPaymentOptionsRepository;
    }

    public function getDetailsByToken()
    {
        $this->tokenFn();

        if ($this->user->id !== null) {
            return \response()->json([
                'user_details' => $this->userDetailRepository->get($this->user->id),
                'user_gdpr' => $this->userGdprRepository->get($this->portalUserId)
            ],
                Response::HTTP_OK);
        }

        return \response()->json([
            'error' => 'unauthorized'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function update($request, $userId)
    {
        try {
            if ($userId === null) {
                $this->tokenFn();

                $userId = $this->user->id;
            }

            $portalUserId = $this->portalUserRepository->get($userId)['id'];


            // UPDATE USER DETAILS
            $customRequest = array();
            if ($request['cft-firstName'] != null) {
                array_push($customRequest, array('first_name' => $request['cft-firstName']));
            }
            if ($request['cft-lastName'] != null) {
                array_push($customRequest, array('last_name' => $request['cft-lastName']));
            }
            array_push($customRequest, array(
                'telephone_prefix' => $request['cft-telephone-prefix'],
                'telephone' => $request['cft-telephone'],
                'street' => $request['cft-street'],
                'house_number' => $request['cft-house-number'],
                'city' => $request['cft-city'],
                'zip' => $request['cft-zip'],
                'country' => $request['cft-country'],
                'delivery_address_is_same' => $request['cft-deliveryAddressSame']
            ));

            $this->userDetailRepository->update(array_merge(...$customRequest), $userId);


            // UPDATE USER GDPR
            $gdprRequest = array();
            array_push($gdprRequest, array(
                'agreeMailing' => $request['cft-mailing'],
                'agreePersonalData' => $request['cft-agree']
            ));
            $this->userGdprRepository->update(array_merge(...$gdprRequest), $portalUserId);

            // UPDATE USERS TABLE
            $userRequest = array();
            if ($request['cft-password'] != null && $request['cft-password'] !== '********') {
                // update password
                array_push($userRequest, array('password' => bcrypt($request['cft-password'])));
            }
            if ($request['cft-email'] != null) {
                array_push($userRequest, array('email' => $request['cft-email']));
            }
            if ($request['cft-username'] != null)
                array_push($userRequest, array('username' => $request['cft-username']));
            if (sizeof($userRequest) !== 0)
                $this->userRepository->update(array_merge(...$userRequest), $userId);

            // UPDATE USER PAYMENT OPTIONS TABLE
            $paymentOptionsRequest = array();
            if ($request['cft-bankAccountNumber'] != null)
                array_push($paymentOptionsRequest, array('bankAccountNumber' => $request['cft-bankAccountNumber']));
            if ($request['cft-paymentCardNumber'] != null)
                array_push($paymentOptionsRequest, array('paymentCardNumber' => $request['cft-paymentCardNumber']));
            if ($request['cft-paymentCardExpirationDate'] != null)
                array_push($paymentOptionsRequest, array('paymentCardExpirationDate' => $request['cft-paymentCardExpirationDate']));
            if (sizeof($paymentOptionsRequest) !== 0)
                $this->userPaymentOptionsRepository->update(array_merge(...$paymentOptionsRequest), $portalUserId);

        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'message' => 'Successfully updated user account.'
        ], Response::HTTP_CREATED);
    }

    private function tokenFn()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        $this->portalUserId = $this->portalUserRepository->get($this->user->id)['id'];
    }

    public function getBase()
    {
        try {
            $this->tokenFn();

            $username = $this->userRepository->get($this->user->id)['username'];
            $userDetails = $this->userDetailRepository->get($this->user->id);

        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'username' => $username,
            'first_name' => $userDetails['first_name'],
            'last_name' => $userDetails['last_name']
        ], Response::HTTP_OK);


    }
}