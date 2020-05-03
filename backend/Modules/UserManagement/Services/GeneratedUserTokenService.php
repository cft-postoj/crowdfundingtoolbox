<?php


namespace Modules\UserManagement\Services;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Modules\UserManagement\Entities\BackOfficeRole;
use Modules\UserManagement\Entities\BackOfficeUser;
use Modules\UserManagement\Entities\UserDetail;
use Modules\UserManagement\Repositories\BackOfficeUserRepository;
use Modules\UserManagement\Repositories\GeneratedUserTokenRepository;
use JWTAuth;
use Modules\UserManagement\Repositories\PortalUserRepository;

class GeneratedUserTokenService implements GeneratedUserTokenServiceInterface
{
    private $generatedUserTokenRepository;
    private $userService;
    private $backOfficeUserRepository;
    private $portalUserService;

    public function __construct()
    {
        $this->generatedUserTokenRepository = new GeneratedUserTokenRepository();
        $this->userService = new UserService();
        $this->backOfficeUserRepository = new BackOfficeUserRepository();
    }

    public function create($userId)
    {
        $generatedToken = $this->generatePasswordToken();
        // save generated token to DB
        $this->generatedUserTokenRepository->addGeneratedToken($userId, bcrypt($generatedToken));
        return $generatedToken;
    }

    public function isValid($request, $prefix = null)
    {
        $valid = validator($request->only(
            'generatedToken'
        ), [
            'generatedToken' => 'required|string',
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors(),
                'message' => 'Token is incorrect.'
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        try {
            $user_id = $request['user'];
            if ($user_id === null) {
                foreach ($this->generatedUserTokenRepository->getAll() as $generatedToken) {
                    if (Hash::check($request['generatedToken'], $generatedToken->generated_token)) {
                        /*
                         * check if an hour has passed
                         * if hour has passed, token is automatically deleted without return JWT
                         */
                        if ($this->isHourPassed($generatedToken->created_at) && $request['action'] !== null) {
                            $this->generatedUserTokenRepository->deleteByUserId($generatedToken->user_id);
                            return \response()->json([
                                'message' => 'One hour was already passed.'
                            ], Response::HTTP_OK);
                        }

                        if ($prefix === 'api/backoffice') {
                            if ($this->backOfficeUserRepository->get($generatedToken->user_id) !== null) {
                                $token = JWTAuth::fromUser($this->userService->getById($generatedToken->user_id));
                                $this->generatedUserTokenRepository->deleteByUserId($generatedToken->user_id);
                                return \response()->json([
                                    'user_detail' => UserDetail::where('user_id', $generatedToken->user_id)->first(),
                                    'user_role' => BackOfficeRole::where('id', BackOfficeUser::where('user_id', $generatedToken->user_id)->first()['role_id'])->first()['slug'],
                                    'token' => $token
                                ], Response::HTTP_OK);
                            }
                        } else {
                            $this->generatedUserTokenRepository->deleteByUserId($generatedToken->user_id);
                            $this->portalUserService = new PortalUserService();
                            if ($request['action'] === 'loggedIn') {
                                $this->portalUserService->activateAccount($generatedToken->user_id);
                            }
                            $token = JWTAuth::fromUser($this->userService->getById($generatedToken->user_id));
                            return \response()->json([
                                'token' => $token
                            ], Response::HTTP_OK);
                        }
                    }
                }
                return \response()->json([
                    'message' => 'One hour was already passed.'
                ], Response::HTTP_OK);
            }
            $generatedToken = $this->generatedUserTokenRepository->getByUserId($user_id);

            if ($generatedToken !== null) {
                /*
                 * check if an hour has passed
                 * if hour has passed, token is automatically deleted without return JWT
                 */
                if ($this->isHourPassed($generatedToken->created_at) && $request['action'] !== null) {
                    $this->generatedUserTokenRepository->deleteByUserId($generatedToken->user_id);
                    return \response()->json([
                        'message' => 'One hour was already passed.'
                    ], Response::HTTP_OK);
                }

                if ($prefix === 'api/backoffice') {
                    if ($this->backOfficeUserRepository->get($generatedToken->user_id) !== null) {
                        $token = JWTAuth::fromUser($this->userService->getById($generatedToken->user_id));
                        $this->generatedUserTokenRepository->deleteByUserId($generatedToken->user_id);
                        return \response()->json([
                            'user_detail' => UserDetail::where('user_id', $generatedToken->user_id)->first(),
                            'user_role' => BackOfficeRole::where('id', BackOfficeUser::where('user_id', $generatedToken->user_id)->first()['role_id'])->first()['slug'],
                            'token' => $token
                        ], Response::HTTP_OK);
                    }
                } else {
                    $this->generatedUserTokenRepository->deleteByUserId($user_id);
                    $this->portalUserService = new PortalUserService();
                    if ($request['action'] === 'loggedIn') {
                        // activate account
                        $portalUserRepository = new PortalUserRepository();
                        $portal_user_id = $portalUserRepository->getPortalUserIdByUserId($user_id)->id;
                        $portalUserRepository->activateAccount($portal_user_id);
                    }
                    $token = JWTAuth::fromUser($this->userService->getById($user_id));
                    return \response()->json([
                        'token' => $token
                    ], Response::HTTP_OK);
                }
            } else {
                return \response()->json([
                    'message' => 'One hour was already passed.'
                ], Response::HTTP_OK);
            }


        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function generatePasswordToken()
    {
        $length = 32;
        try {
            return bin2hex(random_bytes($length));
        } catch (\Exception $e) {
            return $e;
        }
    }

    private function isHourPassed($created_at)
    {
        $now = Carbon::now()->subHours(48);
        $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $created_at);
        if ($now > $created_at) {
            return true;
        }
        return false;
    }
}
