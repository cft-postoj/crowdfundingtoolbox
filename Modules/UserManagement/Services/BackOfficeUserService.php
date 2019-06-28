<?php


namespace Modules\UserManagement\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\UserManagement\Repositories\BackOfficeUserRepository;
use Modules\UserManagement\Repositories\UserDetailRepository;
use Modules\UserManagement\Repositories\UserRepository;

class BackOfficeUserService implements BackOfficeUserServiceInterface
{

    private $backOfficeUserRepository;
    private $userRepository;
    private $userDetailRepository;
    private $userService;

    public function __construct(BackOfficeUserRepository $backOfficeUserRepository,
                                UserRepository $userRepository, UserDetailRepository $userDetailRepository,
                                UserService $userService)
    {
        $this->backOfficeUserRepository = $backOfficeUserRepository;
        $this->userRepository = $userRepository;
        $this->userDetailRepository = $userDetailRepository;
        $this->userService = $userService;
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
        return Auth::user();
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
            'role'  =>  'required|string|min:3'
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

            $newUserId = json_encode($this->userService->create($request), true);
            $newUserId = json_decode($newUserId)->original->user->id;

            $this->userDetailRepository->createWithRequest(array_merge(...$resultDetail), $newUserId);
        } catch (\Exception $exception) {
            return \response()->json([
                'error' =>  $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
        'meesage'   =>  'Successfully created backoffice user.'
        ], Response::HTTP_CREATED);
    }

}