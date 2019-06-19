<?php


namespace Modules\UserManagement\Services;



use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Modules\UserManagement\Jobs\RemoveGeneratedToken;
use Modules\UserManagement\Repositories\GeneratedUserTokenRepository;
use JWTAuth;

class GeneratedUserTokenService implements GeneratedUserTokenServiceInterface
{
    private $generatedUserTokenRepository;
    private $userService;

    public function __construct()
    {
        $this->generatedUserTokenRepository = new GeneratedUserTokenRepository();
        $this->userService = new UserService();
    }

    public function create($userId)
    {
        $generatedToken = $this->generatePasswordToken();
        $lastToken = $this->generatedUserTokenRepository->addGeneratedToken($userId, bcrypt($generatedToken));
        /*
                     * After one hour token will be soft deleted (if user won't click to link in email)
                     */
        $job = (new RemoveGeneratedToken($lastToken))->delay(Carbon::now()->addMinutes(60));
        dispatch($job);
        call_in_background('queue:work --deamon');
        return $generatedToken;
    }

    public function isValid($request)
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
            foreach ($this->generatedUserTokenRepository->getAll() as $generatedToken) {
                if (Hash::check($request['generatedToken'], $generatedToken->generated_token)) {
                    $token = JWTAuth::fromUser($this->userService->getById($generatedToken->user_id));
                    $this->generatedUserTokenRepository->deleteByUserId($generatedToken->user_id);
                    return \response()->json([
                        'token' =>  $token
                    ], Response::HTTP_OK);
                }
            }

        } catch (\Exception $exception) {
            return \response()->json([
                'error' =>  $exception
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    private function generatePasswordToken()
    {
        $length = 32;
        try {
            return bin2hex(random_bytes($length));
        } catch (\Exception $e) {
            return $e;
        }

    }
}
