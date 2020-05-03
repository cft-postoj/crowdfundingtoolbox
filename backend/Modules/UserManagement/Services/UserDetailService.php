<?php


namespace Modules\UserManagement\Services;


use Illuminate\Http\Response;
use Modules\UserManagement\Entities\AccountHistoryPortalUser;
use Modules\UserManagement\Repositories\PortalUserRepository;
use Modules\UserManagement\Repositories\UserDetailRepository;
use JWTAuth;
use Modules\UserManagement\Repositories\UserGdprRepository;
use Modules\UserManagement\Repositories\UserPaymentOptionsRepository;
use Modules\UserManagement\Repositories\UserRepository;
use Auth;

class UserDetailService implements UserDetailServiceInterface
{
    private $userDetailRepository;
    private $userGdprRepository;
    private $portalUserRepository;
    private $userRepository;
    private $user;
    private $portalUserId;
    private $userPaymentOptionsRepository;
    private $userMailerApiService;

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

            $oldUserData = $this->userDetailRepository->get($userId);
            $oldUserGdpr = $this->userGdprRepository->get($portalUserId);
            $oldUser = $this->userRepository->get($userId);
            $oldPayment = $this->userPaymentOptionsRepository->getByPortalUser($portalUserId);
            $oldUserNotes = $this->portalUserRepository->get($userId);

            $oldData = array(
                'old_user_data' => $oldUserData,
                'old_user_gdpr' => $oldUserGdpr,
                'old_user' => $oldUser,
                'old_payment' => $oldPayment,
                'old_user_notes' => $oldUserNotes
            );

            $updateData = 'Updating: ';


            // UPDATE USER DETAILS
            $customRequest = array();
            if ($oldUserData !== null) {
                if ($request['cft-firstName'] != null) {
                    array_push($customRequest, array('first_name' => $request['cft-firstName']));
                    if ($oldUserData->first_name !== $request['cft-firstName']) {
                        $updateData .= 'FIRST NAME, ';
                    }
                }
                if ($request['cft-lastName'] != null) {
                    array_push($customRequest, array('last_name' => $request['cft-lastName']));
                    if ($oldUserData->last_name !== $request['cft-lastName']) {
                        $updateData .= 'LAST NAME, ';
                    }
                }
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
            if ($oldUserData !== null) {
                if ($oldUserData->telephone_prefix !== $request['cft-telephone-prefix']) {
                    $updateData .= 'TELEPHONE PREFIX, ';
                }
                if ($oldUserData->telephone !== $request['cft-telephone']) {
                    $updateData .= 'TELEPHONE, ';
                }
                if ($oldUserData->street !== $request['cft-street']) {
                    $updateData .= 'STREET, ';
                }
                if ($oldUserData->house_number !== $request['cft-house-number']) {
                    $updateData .= 'HOUSE NUMBER, ';
                }
                if ($oldUserData->city !== $request['cft-city']) {
                    $updateData .= 'CITY, ';
                }
                if ($oldUserData->zip !== $request['cft-zip']) {
                    $updateData .= 'ZIP, ';
                }
                if ($oldUserData->country !== $request['cft-country']) {
                    $updateData .= 'COUNTRY, ';
                }
            }


            $this->userDetailRepository->update(array_merge(...$customRequest), $userId);


            // UPDATE USER GDPR
            $gdprRequest = array();
            array_push($gdprRequest, array(
                'agreeMailing' => $request['cft-mailing'],
                'agreePersonalData' => $request['cft-agree']
            ));
            if ($oldUserGdpr->agreeMailing !== $request['cft-mailing']) {
                $updateData .= 'AGREE WITH NEWSLETTERS, ';
            }
            if ($oldUserGdpr->agree !== $request['cft-agree']) {
                $updateData .= 'AGREE WITH GENERAL OPTIONS, ';
            }
            $this->userGdprRepository->update(array_merge(...$gdprRequest), $portalUserId);

            // UPDATE USERS TABLE
            $userRequest = array();
            if ($request['cft-password'] != null && $request['cft-password'] !== '********') {
                // update password
                $updateData .= 'PASSWORD, ';
                array_push($userRequest, array('password' => bcrypt($request['cft-password'])));
            }
            if ($request['cft-email'] != null) {
                if ($oldUser->email !== $request['cft-email']) {
                    $updateData .= 'EMAIL, ';
                }
                array_push($userRequest, array('email' => $request['cft-email']));
            }
            if ($request['cft-username'] != null) {
                if ($oldUser->username !== $request['cft-username']) {
                    $updateData .= 'USERNAME, ';
                }
                array_push($userRequest, array('username' => $request['cft-username']));
            }

            if (sizeof($userRequest) !== 0)
                $this->userRepository->update(array_merge(...$userRequest), $userId);

            // UPDATE USER PAYMENT OPTIONS TABLE
            $paymentOptionsRequest = array();
            if ($request['cft-bankAccountNumber'] != null) {
                if ($oldPayment->bank_account_number !== $request['cft-bankAccountNumber']) {
                    $updateData .= 'IBAN, ';
                }
                array_push($paymentOptionsRequest, array('bank_account_number' => $request['cft-bankAccountNumber']));
            }
            if ($request['cft-paymentCardNumber'] != null) {
                if ($oldPayment->payment_card_number !== $request['cft-paymentCardNumber']) {
                    $updateData .= 'CARD NUMBER, ';
                }
                array_push($paymentOptionsRequest, array('payment_card_number' => $request['cft-paymentCardNumber']));
            }

            if ($request['cft-paymentCardExpirationDate'] != null) {
                if ($oldPayment->payment_card_expiration_date !== $request['cft-paymentCardExpirationDate']) {
                    $updateData .= 'CARD EXPIRATION DATE, ';
                }
                array_push($paymentOptionsRequest, array('payment_card_expiration_date' => $request['cft-paymentCardExpirationDate']));
            }

            if (sizeof($paymentOptionsRequest) !== 0)
                $this->userPaymentOptionsRepository->update(array_merge(...$paymentOptionsRequest), $portalUserId);

            // UPDATE USER NOTES
            if ($request['user_notes'] != null) {
                if ($oldUserNotes->notes !== $request['cuser_notes']) {
                    $updateData .= 'USER NOTES.';
                }
                $this->portalUserRepository->update(array(
                    'notes' => $request['user_notes']
                ), $portalUserId);
            }

            // create record for account history
            $currentUser = Auth::user();
            $updatedBackofficeUser = ($currentUser->id === $userId) ? null : $currentUser->id;

            AccountHistoryPortalUser::create(array(
                'portal_user_id' => $portalUserId,
                'update_description' => $updateData,
                'previous_data' => json_encode($oldData),
                'updated_backoffice_user' => $updatedBackofficeUser
            ));

        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'message' => 'Successfully updated user account.',
            'user_token' => JWTAuth::fromUser($currentUser)
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

    public function getLastUpdated($portalUserId)
    {
        return response()->json(
            AccountHistoryPortalUser::where('portal_user_id', $portalUserId)
                ->with('backofficeUser')
                ->first(), Response::HTTP_OK
        );
    }

    public function getByUserId($userId)
    {
        return $this->userDetailRepository->get($userId);
    }

}