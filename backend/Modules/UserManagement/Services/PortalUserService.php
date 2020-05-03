<?php


namespace Modules\UserManagement\Services;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use JWTAuth;
use Modules\Payment\Repositories\DonationRepository;
use Modules\Payment\Services\DonationService;
use Modules\Payment\Services\VariableSymbolService;
use Modules\UserManagement\Emails\ForgottenPasswordEmail;
use Modules\UserManagement\Emails\RegisterEmail;
use Modules\UserManagement\Entities\DonorStatus;
use Modules\UserManagement\Entities\User;
use Modules\UserManagement\Entities\UserCookieCouple;
use Modules\UserManagement\Jobs\RemoveGeneratedToken;
use Modules\UserManagement\Repositories\GeneratedUserTokenRepository;
use Modules\UserManagement\Repositories\PortalUserRepository;
use Modules\UserManagement\Repositories\UserDetailRepository;
use Modules\UserManagement\Repositories\UserGdprRepository;
use Modules\UserManagement\Repositories\UserPaymentOptionsRepository;
use Modules\UserManagement\Repositories\UserRepository;

class PortalUserService implements PortalUserServiceInterface
{

    private $userRepository;
    private $portalUserRepository;
    private $generatedUserTokenRepository;
    private $usernameUsedCounter;
    private $generatedTokenJob;
    private $generatedUserTokenService;
    private $userGdprRepository;
    private $userDetailRepository;
    private $variableSymbolService;
    private $userPaymentOptionsRepository;
    private $userService;
    private $trackingService;
    private $createdUserService;


    public function __construct()
    {
        $this->portalUserRepository = new PortalUserRepository();
        $this->userRepository = new UserRepository();
        $this->generatedUserTokenRepository = new GeneratedUserTokenRepository();
        $this->generatedTokenJob = new RemoveGeneratedToken();
        $this->userGdprRepository = new UserGdprRepository();
        $this->userDetailRepository = new UserDetailRepository();
        $this->usernameUsedCounter = 0;
        $this->generatedUserTokenService = new GeneratedUserTokenService();
        $this->variableSymbolService = new VariableSymbolService();
        $this->userPaymentOptionsRepository = new UserPaymentOptionsRepository();
        $this->userService = new UserService();
        $this->trackingService = new TrackingService();
        $this->createdUserService = new CreatedUsersService();
    }

    public function getAll()
    {
        try {
            return $this->userRepository->getPortalUsers();
        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function findByString($string = '')
    {
        return $this->userRepository->findByString($string);
    }


    public function getAllIds()
    {
        return $this->portalUserRepository->getAllIds();
    }

    public function getAllWithDonations()
    {
        try {
            return \response()->json($this->portalUserRepository->getAllWithDonations(),
                Response::HTTP_OK);
        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAllWithDonationData($minUserId, $maxUserId)
    {
        return $this->portalUserRepository->getAllWithDonationData($minUserId, $maxUserId);
    }

    public function getAllWithOneTimeDonation()
    {
        return $this->portalUserRepository->getAllWithOneTimeDonation();
    }


    public function getById($id)
    {
        try {
            return $this->userRepository->getPortalUserById($id);
        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getVariableSymbol($userId)
    {
        return $this->variableSymbolService->getByPortalUserId($this->getPortalUserIdByUserId($userId));
    }

    public function getVariableSymbolByPortalUser($portal_user_id)
    {
        return $this->variableSymbolService->getByPortalUserId($portal_user_id);
    }

    public function getPortalUserIdFromToken()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->getPortalUserIdByUserId($user->id);
    }

    public function create(Request $request)
    {
        $valid = validator($request->only(
            'email',
            'password'
        ), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255|min:6'
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }


        try {
            $email = $request['email'];
            $user = $this->userRepository->getByEmail($email);
            $existInUserTable = ($user !== null) ? true : false;
            $existInPortalUserTable = ($user === null) ? false :
                (($this->portalUserRepository->get($user->id) !== null) ? true : false);
            $lockedAccount = false;
            if ($existInPortalUserTable) {
                $lockedAccount = $this->portalUserRepository->get($user->id)['locked_account'];
            }
            if ($existInUserTable && $existInPortalUserTable && !$lockedAccount) {
                return \response()->json([
                    'error' => array(
                        'type' => 'email-registered',
                        'message' => 'Email is already registered.'
                    )
                ], Response::HTTP_BAD_REQUEST);
            } else if ($existInUserTable && !$existInPortalUserTable) {
                /*
                 * in this case, user is registered as backoffice user and want to register as portal user with
                 * the same email address
                 */
                $this->portalUserRepository->create($user->id);
                $portalUserId = $this->portalUserRepository->get($user->id)['id'];
                $this->userGdprRepository->create($request, $portalUserId);

                // update user password
                $this->userRepository->updatePassword($user->id, $request['password']);

                $generatedToken = $this->generatedUserTokenService->create($user->id);
                $this->variableSymbolService->create($portalUserId);
                $this->userPaymentOptionsRepository->create(array(
                    'portal_user_id' => $portalUserId,
                    'pairing_type' => 'variable_symbol'
                ));
                Mail::to($user->email)->send(new RegisterEmail($generatedToken, $user->id));

                if ($this->userDetailRepository->get($user->id) === null) {
                    $this->userDetailRepository->create($user->id);
                }

                return \response()->json([
                    'token' => $generatedToken,
                    'message' => 'Account was successfully created.'
                ], Response::HTTP_CREATED);
            } else if ($existInUserTable && $existInPortalUserTable && $lockedAccount) {
                // if user already exists but account is not activated, we'll send activation email
                $generatedToken = $this->generatedUserTokenService->create($user->id);
                Mail::to($user->email)->send(new RegisterEmail($generatedToken, $user->id));
                return \response()->json([
                    'token' => $generatedToken,
                    'message' => 'Account was successfully created.'
                ], Response::HTTP_CREATED);
            }
            /*
             * create new user
             */

            $username = explode('@', $request['email'])[0];
            $newUserId = $this->userRepository->create($request['email'], $request['password'], $this->checkUniqueUsername($username));
            $portalUser = $this->portalUserRepository->create($newUserId);
            $portalUserId = $this->portalUserRepository->get($newUserId)['id'];
            $this->userGdprRepository->create($request, $portalUserId);

            $userData = $this->userRepository->get($newUserId);
            $generatedToken = $this->generatedUserTokenService->create($newUserId);
            $this->variableSymbolService->create($portalUserId);
            $this->userPaymentOptionsRepository->create(array(
                'portal_user_id' => $portalUserId,
                'pairing_type' => 'variable_symbol'
            ));
            Mail::to($userData->email)->send(new RegisterEmail($generatedToken, $newUserId));
            if ($this->userDetailRepository->get($newUserId) === null) {
                $this->userDetailRepository->create($newUserId);
            }

            // TODO check this
            $this->couplePortalUserIdAndUserCookie($portalUser->id, intval($request['user_cookie']));
            return \response()->json([
                'token' => $generatedToken,
                'message' => 'Account was successfully created.'
            ], Response::HTTP_CREATED);

        } catch (\Exception $exception) {
            $error = array(
                'error' => $exception->getMessage(),
                'type' => 'undefined',
                'message' => 'There was an error during the registration process.'
            );

            if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                $error = array(
                    'type' => 'email',
                    'message' => 'Email is not correct.'
                );
            }
            return \response()->json([
                'error' => $error
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function checkToken()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $loggedIn = false;

        if ($user->id !== null) {
            $loggedIn = true;
        }

        return \response()->json([
            'isLoggedIn' => $loggedIn
        ], Response::HTTP_OK);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return \response()->json([
            'status' => 'logout',
            'message' => 'Token was successfully invalidated.'
        ], Response::HTTP_OK);
    }

    public function getJWTToken()
    {
        $user = $this->getUserByUserId($this->getUserId($this->getPortalUserIdFromToken()));
        return JWTAuth::fromUser($user);
    }

    private function checkUniqueUsername($username)
    {
        if ($this->userRepository->isUsernameUsed($username) === null) {
            return $username;
        }
        $this->usernameUsedCounter++;
        return $this->checkUniqueUsername($username . $this->usernameUsedCounter);
    }


    public function authenticate($request)
    {
        $prefix = $request->route()->getPrefix();
        /*
         * check if there is portal endpoint (not for backoffice users)
         */
        if (strpos($prefix, 'backoffice') !== false) {
            return \response()->json([
                'error' => 'invalid_access',
                'message' => 'You don\'t have an access to this.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $credentials = $request->only('email', 'password');

        // if user post username
        if (strpos($request['email'], '@') === false) {
            $credentials = [
                'username' => $request['email'],
                'password' => $request['password']
            ];
        }

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                $possibleUser = $this->userRepository->getByEmail($request['email']);

                if ($possibleUser !== null) {
                    // check if user exist like Portal user
                    if ($this->portalUserRepository->get($possibleUser->id) !== null) {
                        return \response()->json([
                            'error' => true,
                            'type' => 'password'
                        ], Response::HTTP_BAD_REQUEST);
                    }
                }
                return \response()->json([
                    'error' => true,
                    'type' => 'email'
                ], Response::HTTP_BAD_REQUEST);
            } else {
                // check if user has locked_account
                $user = $this->userRepository->getByEmail($request['email']);
                if ($this->portalUserRepository->get($user->id)['locked_account']) {
                    // user is registerd but he doesn't have activated account
                    return \response()->json([
                        'error' => true,
                        'type' => 'email'
                    ], Response::HTTP_BAD_REQUEST);
                }
            }
        } catch (JWTException $e) {
            return \response()->json(['error' => 'could_not_create_token', 'message' => $e], 500);
        }

        $user = Auth::user();
        // TODO fix this (get null for login..why???)
        //$portalUser = PortalUser::where('user_id',$user->id)->select('id')->first();
        //$this->coupleUserIdAndUserCookie($portalUser->id, $request['user_cookie']);
        $token = JWTAuth::fromUser($user);

        //$myPayload = $token->getPayload();
        $response = \response()->json([
            'message' => 'Successfully logged in.',
            'token' => $token,
            'ip' => $request->ip()
        ], Response::HTTP_OK);
        return $response;
    }


    public function resetPassword($request)
    {
        try {
            $this->generatedUserTokenService = new GeneratedUserTokenService();
            $possibleUser = $this->userRepository->getByEmail($request['email']);
            if ($possibleUser !== null) {
                // check if user has locked_account
                if ($this->portalUserRepository->get($possibleUser->id)['locked_account']) {
                    // user is registerd but he doesn't have activated account
                    return \response()->json([
                        'error' => true,
                        'type' => 'email'
                    ], Response::HTTP_BAD_REQUEST);
                }

                // check if user exist like Portal user
                if ($this->portalUserRepository->get($possibleUser->id) !== null) {
                    Mail::to($request['email'])->send(new ForgottenPasswordEmail($this->generatedUserTokenService->create($possibleUser->id), $possibleUser->id));
                    return \response()->json([
                        'error' => false,
                        'message' => 'Email with password was successfully sent.'
                    ], Response::HTTP_OK);
                }
            }
            return \response()->json([
                'error' => true,
                'type' => 'email'
            ], Response::HTTP_BAD_REQUEST);

        } catch (JWTException $e) {
            return \response()->json(['error' => 'could_not_create_token', 'message' => $e], Response::HTTP_BAD_REQUEST);
        }
    }


    public function registerDuringDonation($showId, string $email, $cookie, $terms, string $iban): User
    {
        $generatedPassword = $this->generatedUserTokenService->generatePasswordToken();

        $user = $this->userRepository->getByEmail($email);
        $existInUserTable = ($user !== null) ? true : false;
        $existInPortalUserTable = ($user === null) ? false :
            (($this->portalUserRepository->get($user->id) !== null) ? true : false);
        if ($existInUserTable && $existInPortalUserTable) {
            $this->couplePortalUserIdAndUserCookie($user->portalUser->id, $cookie);
            return $user;
        } else if ($existInUserTable && !$existInPortalUserTable) {
            /*
             * in this case, user is registered as backoffice user and want to register as portal user with
             * the same email address
             */
            $this->portalUserRepository->create($user->id);
            $portalUserId = $this->portalUserRepository->get($user->id)['id'];
            $this->userGdprRepository->create($terms, $portalUserId);

            $this->variableSymbolService->create($portalUserId);
            $this->userPaymentOptionsRepository->create(array(
                'portal_user_id' => $portalUserId,
                'pairing_type' => 'variable_symbol'
            ));

            if ($this->userDetailRepository->get($user->id) === null) {
                $this->userDetailRepository->create($user->id);
            }
            $this->couplePortalUserIdAndUserCookie($user->portalUser->id, $cookie);
            return $this->userRepository->getWithVariableSymbol($user->id);
        } else {

            /*
             * create new user
             */
            $username = explode('@', $email)[0];
            $newUserId = $this->userRepository->create($email, $generatedPassword, $this->checkUniqueUsername($username));
            $portalUser = $this->portalUserRepository->createByDonation($newUserId);
            $portalUserId = $this->portalUserRepository->get($newUserId)['id'];
            $this->userGdprRepository->create($terms, $portalUserId);


            $this->variableSymbolService->create($portalUserId);
            $this->userPaymentOptionsRepository->create(array(
                'portal_user_id' => $portalUserId,
                'pairing_type' => 'variable_symbol'
            ));
            $user = $this->userRepository->getWithVariableSymbol($newUserId);
            if ($this->userDetailRepository->get($newUserId) === null) {
                $this->userDetailRepository->create($newUserId);
            }

            // get userCookie by show_id
            $trackingShow = $this->trackingService->getTrackingShowById($showId);
            $this->couplePortalUserIdAndUserCookie($portalUser->id, $trackingShow->visit->user_cookie);
            //$user['secret'] = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

            $this->createdUserService->updateOrCreate(array('portal_user_id' => $user->portalUser->id),
                array('portal_user_id' => $user->portalUser->id,
                    'tracking_show_id' => $trackingShow->id,
                    'send_mail_at' => Carbon::now()->addMinutes(15)));
            return $user;
        }
    }

    public function couplePortalUserIdAndUserCookie($portalUserId, $cookieId): UserCookieCouple
    {
        //catch db exception to prevent fall of another functions
        try {
            return $this->userRepository->coupleUserWithCookie($portalUserId, $cookieId);
        } catch (\Exception $exception) {
            return new UserCookieCouple();
        }
    }

    public function getDonationsByPortalUser($portalUserId)
    {
        return $this->portalUserRepository->getDonationsByPortalUser($portalUserId);
    }

    public function getPortalUserIdByUserId($id)
    {
        return $this->portalUserRepository->getPortalUserIdByUserId($id)['id'];
    }

    public function getDonationsByUserPortalAndDate($portalUserId, $from, $to)
    {
        return $this->portalUserRepository->getDonationsByUserPortalAndDate($portalUserId, $from, $to);
    }

    public function getDonationsDetailInfo($id)
    {
        return $this->portalUserRepository->getDonationsDetailInfo($id);
    }

    public function removeById($id)
    {
        //unpair all payments to users
        $donationService = new DonationService();
        $donationService->deleteAllDonationByPortalUserId($id);
        return $this->portalUserRepository->removeById($id);
    }

    private function getTypeOfCard($fourNumbers)
    {
        $cardtype = array(
            "visa" => "/^4[0-9](.)*?$/",
            "mastercard" => "/^5[1-5](.)*$/",
            "amex" => "/^3[47](.)*$/",
            "discover" => "/^6(?:011|5[0-9]{2})(.)*$/",
        );

        if (preg_match($cardtype['visa'], $fourNumbers)) {
            return 'Visa';

        } else if (preg_match($cardtype['mastercard'], $fourNumbers)) {
            return 'MasterCard';
        } else if (preg_match($cardtype['amex'], $fourNumbers)) {
            return 'Amex';

        } else if (preg_match($cardtype['discover'], $fourNumbers)) {
            return 'Discover';
        }

        return '';
    }

    public function getUserSupportData()
    {
        $userId = $this->getPortalUserIdFromToken();
        $response = array();
        array_push($response, array(
            'donation' => $this->portalUserRepository->getUserSupportData($userId)
        ));
        $userPaymentOptions = $this->userPaymentOptionsRepository->getByPortalUser($userId);
        $cardNumber = ($userPaymentOptions->payment_card_number !== null) ? $userPaymentOptions->payment_card_number : '';
        $bankAccountNumber = ($userPaymentOptions->bank_account_number !== null) ? $userPaymentOptions->bank_account_number : '';
        if ($cardNumber !== '') {
            $cardNumber = explode('*', $cardNumber)[sizeof(explode('*', $cardNumber)) - 1];
            $cardNumber = $this->getTypeOfCard(explode('*', $userPaymentOptions->payment_card_number)[0]) . ' ************' . $cardNumber;
        }
        if ($bankAccountNumber !== '') {
            $bankAccountNumber = substr($bankAccountNumber, 0, 4) . '******************' . substr($bankAccountNumber, strlen($bankAccountNumber) - 4, strlen($bankAccountNumber));
        }
        array_push($response, array(
                'comfortpay_donation' => null,
                'payment_options' => array(
                    'card_number' => $cardNumber,
                    'bank_account_number' => $bankAccountNumber
                )
            )
        );

        return array_merge(...$response);
    }

    public function importDonors()
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 2000);
        //parse csv to array
        $tmpName = $_FILES['file']['tmp_name'];
        $csvAsArray = array_map('str_getcsv', file($tmpName));

        //group donors with same email
        $groupedDonorsByEmail = array();
        for ($i = 1; $i < count($csvAsArray); $i++) {
            $donor = $this->ownArrayCombine($csvAsArray[0], $csvAsArray[$i]);
            $email = str_lower($donor['email']);
            //find if in $groupedDonorsByEmail is already named array with key same as current $email
            $search = isset($groupedDonorsByEmail[$email]) ? $groupedDonorsByEmail[$email] : false;
            if ($search === false) {
                $groupedDonorsByEmail[$email] = array($donor);
            } else {
                array_push($groupedDonorsByEmail[$email], $donor);
            }
        }
        //find for each donor group VS
        $users = array();
        foreach ($groupedDonorsByEmail as $donor) {
            array_push($users, $currentUser = $this->getByMostRecentVs($donor));

            $username = explode('@', $currentUser['email'])[0];
            //avoid duplicity. When we already have user with current email, skip generating new user
            if ($this->userRepository->getByEmail($currentUser['email']) != null) {
                continue;
            }
            $generatedPassword = $this->generatedUserTokenService->generatePasswordToken();
            $newUserId = $this->userRepository->create($currentUser['email'], $generatedPassword,
                $this->checkUniqueUsername($username));

            // create portal user
            // avoid to write note '\N\' that in export represent null value
            $portalUser = $this->portalUserRepository->createPortalUser($newUserId,
                $currentUser['note'] !== '\N' ? $currentUser['note'] : null,
                'import');

            // create user detail
            // avoid to write value '\N\' that in export represent null value
            $this->userDetailRepository->createMass(
                ['user_id' => $newUserId,
                    'first_name' => $currentUser['first_name'] !== '\N' ? $currentUser['first_name'] : null,
                    'last_name' => $currentUser['first_name'] !== '\N' ? $currentUser['last_name'] : null,
                    'street' => $currentUser['street'] !== '\N' ? $currentUser['street'] : null,
                    'zip' => $currentUser['zip'] !== '\N' ? $currentUser['zip'] : null,
                    'city' => $currentUser['city'] !== '\N' ? $currentUser['city'] : null,
                    'telephone' => $currentUser['phone'] !== '\N' ? $currentUser['phone'] : null
                ]);

            // create userPaymentOption
            // avoid to write value '\N\' that in export represent null value
            $this->userPaymentOptionsRepository->create(array(
                'portal_user_id' => $portalUser->id,
                'pairing_type' => $currentUser['assign_donation_by'] === 'vs' ? 'variable_symbol' : 'iban',
                'bank_account_number' => $currentUser['iban'] !== '\N' ? $currentUser['iban'] : null
            ));
            $this->userGdprRepository->createMass(['portal_user_id' => $portalUser->id,
                'agree_general_conditions' => $currentUser['terms_agreed'] === 't']);
            $this->variableSymbolService->createSpecific($portalUser->id, $currentUser['variable_symbol']);


        }
        return $users;
    }

    //safe version of array_combine (if second there is more $keys then $values, insert null into those $keys)
    private function ownArrayCombine($keys, $values)
    {
        $result = array();
        foreach ($keys as $index => $key) {
            $result[$key] = count($values) > $index ? $values[$index] : null;
        }
        return $result;
    }

    //return donor from donorGroup, that has highest type and created_at is newest (this way we can record with recent VS)
    private function getByMostRecentVs($donorGroup)
    {
        if (!is_array($donorGroup)) {
            return null;
        } else {
            if (count($donorGroup) === 1) {
                return $donorGroup[0];
            } else {
                array_multisort(array_column($donorGroup, 'type'), SORT_DESC,
                    array_column($donorGroup, 'created_at'), SORT_DESC,
                    $donorGroup);
                return $donorGroup[0];
            }

        }
    }

    public function getPortalUsers($from, $to, $monthly, $dataType, $pageSize, $filterColumns)
    {
        if ($dataType == 'new') {
            return $this->getDonorsNew($from, $to, $monthly, $pageSize, $filterColumns);
        }
        if ($dataType == 'stoppedSupporting') {
            return $this->getDonorsStoppedSupporting($to, $pageSize, $filterColumns);
        }
        if ($dataType == 'didNotPay') {
            return $this->didNotPay($from, $to, $pageSize, $filterColumns);
        }
        if ($dataType == 'onlyInitializeDonation') {
            return $this->onlyInitializeDonation($from, $to, $pageSize, $filterColumns);
        }
        if ($dataType == null) {
            return $this->portalUserRepository->getDonors($from, $to, $monthly, $pageSize, $filterColumns);
        }
        if ($dataType == 'allPortalUsers') {
            return $this->getAllPortalUsers($from, $to, $pageSize, $filterColumns);
        }
        return array();
    }

    private function getAllPortalUsers($from, $to, $pageSize, $filterColumns)
    {
        return $this->portalUserRepository->getAllPortalUsers($from, $to, $pageSize, $filterColumns);
    }

    public function getDonorsNew($from, $to, $monthly, $pageSize, $filterColumns, $onlyCount = false)
    {
        //TODO: prezistit ci toto moze byt takto, ze miesto 2 volani db sa da len jedno
//        if ($monthly == null) {
//            return $this->portalUserRepository->getDonorsNew($from, $to, true, $pageSize, $filterColumns)->merge(
//                $this->portalUserRepository->getDonorsNew($from, $to, false, $pageSize, $filterColumns));
//        }
        return $this->portalUserRepository->getDonorsNew($from, $to, $monthly, $pageSize, $filterColumns, $onlyCount);
    }


    public function getDonorsStoppedSupporting($to, $pageSize, $filterColumns)
    {
        // $stopAfterDays -> number of days, used as input for $stopAfterDate
        $stopAfterDays = 30 + 10;
        // after this date, every users, who dont have payment in dates between  $to and $carbonDateStopped is marked
        // as user, who stopped to donate and therefore should be returned in method getDonorsStoppedSupporting
        $stopAfterDate = Carbon::createFromDate($to)->subDays($stopAfterDays);

        return $this->portalUserRepository->getDonorsStoppedSupporting($stopAfterDate, $pageSize, $filterColumns);
    }

    public function countOfNewDonors($from, $to)
    {
        return $this->portalUserRepository->countOfNewDonors($from, $to);
    }

    public function didNotPay($from, $to, $pageSize, $filterColumns)
    {
        return $this->portalUserRepository->didNotPay($from, $to, $pageSize, $filterColumns);
    }

    public function onlyInitializeDonation($from, $to, $pageSize, $filterColumns)
    {
        return $this->portalUserRepository->onlyInitializeDonation($from, $to, $pageSize, $filterColumns);
    }

    public function getUsersWithRecentDonation(int $daysBefore)
    {
        return $this->portalUserRepository->getUsersWithRecentDonation($daysBefore);
    }

    public function getUserEmail()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return $user->email;
    }

    public function getUserId($portal_user_id)
    {
        return $this->portalUserRepository->getUserId($portal_user_id);
    }

    public function getUserByUserId($userId)
    {
        return $this->userRepository->get($userId);
    }

    public function activateAccount($userId)
    {
        Artisan::call('queue:work');
        return $this->portalUserRepository->activateAccount($this->getPortalUserIdByUserId($userId));
    }

    public function updatePassword($request)
    {
        $valid = validator($request->only(
            'password',
            'agree_conditions'
        ), [
            'password' => 'required|string|max:255|min:6',
            'agree_conditions' => 'required|boolean'
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        $userId = $this->getUserId($this->getPortalUserIdFromToken());
        $user = $this->userService->getById($userId);

        $this->userGdprRepository->update([
            'agreeMailing' => $request['agree_conditions'],
            'agreePersonalData' => $request['agree_conditions']
        ], $this->getPortalUserIdFromToken());

        $this->portalUserRepository->activateAccount($this->getPortalUserIdFromToken());

        $this->userRepository->updatePassword($userId, $request['password']);

        return response()->json([
            'message' => 'Successfully set password.',
            'user_token' => JWTAuth::fromUser($user)
        ], Response::HTTP_CREATED);
    }

}
