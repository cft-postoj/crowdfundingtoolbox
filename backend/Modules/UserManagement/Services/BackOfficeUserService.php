<?php


namespace Modules\UserManagement\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\UserManagement\Emails\BackOfficeRegisterEmail;
use Modules\UserManagement\Repositories\BackOfficeUserRepository;
use Modules\UserManagement\Repositories\GeneratedUserTokenRepository;
use Modules\UserManagement\Repositories\UserDetailRepository;
use Modules\UserManagement\Repositories\UserRepository;
use JWTAuth;

class BackOfficeUserService implements BackOfficeUserServiceInterface
{

    private $backOfficeUserRepository;
    private $userRepository;
    private $userDetailRepository;
    private $userService;
    private $generatedUserTokenService;

    public function __construct(BackOfficeUserRepository $backOfficeUserRepository,
                                UserRepository $userRepository, UserDetailRepository $userDetailRepository,
                                UserService $userService, GeneratedUserTokenService $generatedUserTokenService)
    {
        $this->backOfficeUserRepository = $backOfficeUserRepository;
        $this->userRepository = $userRepository;
        $this->userDetailRepository = $userDetailRepository;
        $this->userService = $userService;
        $this->generatedUserTokenService = $generatedUserTokenService;
    }

    public function get()
    {
        try {
            $result = $this->backOfficeUserRepository->get($this->getAuthUser()->id);
        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(
            $result,
            Response::HTTP_OK
        );
    }

    public function update($request)
    {
        $valid = validator($request->only(
            'email',
            'password',
            'username'
        ), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255|min:6',
            'username' => 'required|string|max:255|min:5'
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        try {
            $result = array();
            $resultDetail = array();
            ($request['password'] !== '******') && array_push($result, array('password' => bcrypt($request['password'])));
            (filter_var($request['email'], FILTER_VALIDATE_EMAIL)) && array_push($result, array('email' => $request['email']));
            ($request['username'] !== '') && array_push($result, array('username' => $request['username']));
            ($request['firstName'] !== '') && array_push($resultDetail, array('first_name' => $request['firstName']));
            ($request['lastName'] !== '') && array_push($resultDetail, array('last_name' => $request['lastName']));

            $this->userDetailRepository->update(array_merge(...$resultDetail), $this->getAuthUser()->id);
            $this->userRepository->update(array_merge(...$result), $this->getAuthUser()->id);
        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'message' => 'Successfully updated account.'
        ], Response::HTTP_CREATED);
    }

    private function getAuthUser()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function create($request)
    {

        $valid = validator($request->only(
            'email',
            'password',
            'role'
        ), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255|min:6',
            'role' => 'required|string|min:3'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        try {
            $result = array();
            $resultDetail = array();
            $resultRole = array();
            ($request['password'] !== '') && array_push($result, array('password' => bcrypt($request['password'])));
            (filter_var($request['email'], FILTER_VALIDATE_EMAIL)) && array_push($result, array('email' => $request['email']));
            ($request['firstName'] !== '') && array_push($resultDetail, array('first_name' => $request['firstName']));
            ($request['lastName'] !== '') && array_push($resultDetail, array('last_name' => $request['lastName']));
            ($request['role'] !== '') && array_push($resultRole, array('role' => $request['role']));

            $newUser = json_encode($this->userService->create($request), true);
            $newUser = json_decode($newUser);
            if (isset($newUser->original)) {
                return \response()->json([
                    'error' => $newUser->original->error->email[0]
                ], Response::HTTP_BAD_REQUEST);
            }
            $newUserId = $newUser->id;
            $newUserUsername = $newUser->username;
            $newUserEmail = $newUser->email;


            $this->userDetailRepository->createWithRequest(array_merge(...$resultDetail), $newUserId);

            $token = $this->generatedUserTokenService->create($newUserId);

            Mail::to($newUserEmail)
                ->send(new BackOfficeRegisterEmail($token, $newUserUsername));
        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'meesage' => 'Successfully created backoffice user.'
        ], Response::HTTP_CREATED);
    }

    public function checkGeneratedResetToken($request, $prefix)
    {
        return $this->generatedUserTokenService->isValid($request, $prefix);
    }

    public function getById($id)
    {
        return $this->backOfficeUserRepository->get($id);
    }

    public function all()
    {
        return $this->backOfficeUserRepository->all();
    }

    public function delete($id)
    {
        try {
            $user = $this->getAuthUser();
            if ($id === 1) {
                return response()->json([
                    'error' => 'You cannot delete superadmin user!'
                ], Response::HTTP_BAD_REQUEST);
            }
            if ($user->id === $id) {
                return response()->json([
                    'error' => 'You cannot delete your admin account!'
                ], Response::HTTP_BAD_REQUEST);
            }
            $this->backOfficeUserRepository->delete($id);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(
            [
                'message' => 'Successfully deleted user with id ' . $id
            ],
            Response::HTTP_OK
        );
    }
}