<?php

namespace Modules\UserManagement\Http\Controllers;

use Modules\UserManagement\Emails\AutoRegistrationEmail;
use Modules\UserManagement\Entities\User;
use Modules\UserManagement\Entities\BackOfficeUser;
use Modules\UserManagement\Entities\BackOfficeRole;
use App\Mail\ForgottenPasswordEmail;
use App\Mail\RegisterEmail;
use Modules\UserManagement\Entities\PortalUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class UserServiceController extends Controller
{
    private $user;

    public function show()
    {
        $this->user = Auth::user();
        return response()->json([
            'user' => $this->user
        ], Response::HTTP_OK);
    }

    public function getAll()
    {
        return BackOfficeUser::all();
    }

    /*
     * Authenticate for backoffice_users
     */

    /**
     * @OA\Post(
     *     path="/api/backoffice/login",
     *     tags={"BACKOFFICE USER"},
     *     summary="Login backoffice user",
     *     operationId="login",
     *     @OA\Response(
     *         response=201,
     *         description="Successfully logged in!",
     *     @OA\JsonContent()
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(
     *              property="username", type="string"
     *           ),
     *           @OA\Property(
     *              property="email", type="string"
     *           ),
     *            @OA\Property(
     *              property="password", type="string"
     *           ),
     *          example={
     *              "username / email": "test / test@test.com",
     *              "password": "test123"}
     *
     *       )
     *
     * )
     * )
     */
    protected function authenticate(Request $request)
    {
        $prefix = $request->route()->getPrefix();
        $credentials = $request->only('email', 'password');
        if (strpos($request['email'], '@') === false) {
            $credentials = [
                'username' => $request['email'],
                'password' => $request['password']
            ];
        }
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return \response()->json([
                    'error' => 'invalid_credentials',
                    'message' => 'There was a problem with sign in. Invalid credentials were entered.'], 400);
            }
        } catch (JWTException $e) {
            return \response()->json(['error' => 'could_not_create_token', 'message' => $e], 500);
        }

        $user = Auth::user();

        if (strpos($prefix, 'backoffice') !== false) {
            if (BackOfficeUser::where('user_id', $user->id)->first()) {
                $token = JWTAuth::fromUser($user);
                return \response()->json([
                    'user' => $user,
                    'user_role' => BackOfficeRole::where('id', BackOfficeUser::where('user_id', $user->id)->first()['role_id'])->first()['slug'],
                    'token' => $token
                ], Response::HTTP_OK);
            }
        } else {
            if (PortalUser::where('user_id', $user->id)->first()) {
                $token = JWTAuth::fromUser($user);
                return \response()->json(compact('user', 'token'), 200);
            }
        }


        return \response()->json(['error' => 'invalid_credentials'], 400);
    }

    public function isBackOfficeUser()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if (BackOfficeUser::where('user_id', $user->id)->first()) {
            return true;
        }
        return \response()->json(['error' => 'invalid_credentials'], 400);
    }

    public function isPortalUser()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if (PortalUser::where('user_id', $user->id)->first()) {
            return true;
        }
        return \response()->json(['error' => 'invalid_credentials'], 400);
    }


    /**
     * @OA\Post(
     *     path="/api/portal/register",
     *     tags={"USER"},
     *     summary="Create portal or backoffice user",
     *     description="Endpoint for portal user: /api/portal/register.
     *      Endpoint for backoffice user: /api/backoffice/register.
     *     Only for users with admin role. They can create new users.",
     *     operationId="register",
     *     @OA\Response(
     *         response=201,
     *         description="Successfully created user!",
     *     @OA\JsonContent()
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(
     *              property="username", type="string"
     *           ),
     *           @OA\Property(
     *              property="email", type="string"
     *           ),
     *            @OA\Property(
     *              property="password", type="string"
     *           ),
     *          @OA\Property(
     *              property="firstName", type="string"
     *          ),
     *          @OA\Property(
     *              property="lastName", type="string"
     *          ),
     *          @OA\Property(
     *              property="role", type="integer"
     *          ),
     *          example={
     *              "email": "test@test.com",
     *              "username": "test",
     *              "firstName": "John",
     *              "lastName": "Doe",
     *              "password": "test123",
     *              "confirmationPassword": "test123"}
     *
     *       )
     *
     * )
     * )
     */
    protected function create(Request $request)
    {
        $prefix = $request->route()->getPrefix();

        $valid = validator($request->only(
            'email',
            //'username',
            'first_name',
            'last_name',
            'password',
            'confirmation_password'
        ), [
            'email' => 'required|string|email|max:255|unique:users',
            // 'username' => 'string|max:255|unique:users',
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'password' => 'required|string|max:255',
            'confirmation_password' => 'required|string|max:255|same:password'
        ]);

        if ($valid->fails()) {
            /* TODO: pridat podmienku pre situaciu, kedy uz pouzivatel existuje, no nie ako portal user alebo backoffice - teda email/username is exist */
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], 400);
            return $jsonError;
        }

        $data = \request()->only('email', 'username', 'first_name', 'last_name', 'password');

        $user = User::create([
            'username' => (isset($data['username'])) ? $data['username'] : explode('@', $data['email'])[0],
            'email' => $data['email'],
            'first_name' => (isset($data['first_name'])) ? $data['first_name'] : '',
            'last_name' => (isset($data['last_name'])) ? $data['last_name'] : '',
            'password' => bcrypt($data['password'])
        ]);
        $user->save();

        if (strpos($prefix, 'backoffice') !== false) {
            $currentAdmin = Auth::user();
            if (BackOfficeUser::where('user_id', $currentAdmin->id)->first()->only('role_id')['role_id'] == 1) {
                $backOfficeUser = BackOfficeUser::create([
                    'user_id' => $user->id,
                    'role_id' => 1   // admin user
                ]);
                $backOfficeUser->save();
            } else {
                return response()->json([
                    'message' => 'You don\'t have permissions to this action'
                ], 400);
            }
        } else {
            PortalUser::create([
                'user_id' => $user->id
            ])->save();
            Mail::to($data['email'])->send(new RegisterEmail());
        }

        return response()->json([
            'message' => 'Successfully created user!',
            'user' => $user
        ], 201);
    }


    /*
     * In donation case (only email is required)
     */
    protected function donationCreate(Request $request)
    {
        $valid = validator($request->only(
            'email'
        ), [
            'email' => 'required|string|email|max:255',
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors(),
                'message' => 'Email is incorrect.'
            ], 400);
            return $jsonError;
        }

        if (User::where('email', $request['email'])->first()) {
            // make donation response -- store to donation table by user id
            return null;
        }

        $generatedPassword = $this->generatePasswordToken();

        $username = explode('@', $request['email'])[0];
        $user = User::create([
            'email' => $request['email'],
            'username' => $username,
            'password' => bcrypt($generatedPassword),
            'generate_password_token' => $generatedPassword
        ]);
        $user->save();

        PortalUser::create([
            'user_id' => $user->id
        ])->save();

        // donation functions

        //return mailing;
        return Mail::to($request['email'])->send(new AutoRegistrationEmail($username, $generatedPassword));

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

    protected function forgotPassword(Request $request)
    {
        $valid = validator($request->only(
            'email'
        ), [
            'email' => 'required|string|email|max:255',
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors(),
                'message' => 'Email is incorrect.'
            ], 400);
            return $jsonError;
        }

        if (User::where('email', $request['email'])->first() == null) {
            $jsonError = response()->json([
                'message' => 'Email is not exists in our system. Please, sign out first.'
            ], 400);
            return $jsonError;
        }

        try {
            $token = $this->generatePasswordToken();
            User::where('email', $request['email'])->update([
                'generate_password_token' => $token
            ]);
            Mail::to($request['email'])->send(new ForgottenPasswordEmail($token));
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e,
                'messsage' => 'Unexpected error'
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'message' => 'Email with reset link was successfully sent.'
        ], Response::HTTP_OK);
    }

    protected function hasUserGeneratedToken(Request $request)
    {
        $valid = validator($request->only(
            'token'
        ), [
            'token' => 'required|string',
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors(),
                'message' => 'Token is incorrect.'
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        try {
            if (User::where('generate_password_token', $request['token'])->first() != null) {
                return \response()->json([
                    'isUserExists' => true
                ], Response::HTTP_OK);
            }
            return \response()->json([
                'isUserExists' => false
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e,
                'message' => 'Unexpected error'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    protected function changePassword(Request $request)
    {
        $valid = validator($request->only(
            'token',
            'password',
            'confirmation_password'
        ), [
            'token' => 'required|string',
            'password' => 'required|string|max:255',
            'confirmation_password' => 'required|string|max:255|same:password'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors(),
                'message' => 'Bad action.'
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        try {
            $user = User::where('generate_password_token', $request['token'])->first();
            if ($user != null) {
                User::where('generate_password_token', $request['token'])->update([
                    'password'   =>  bcrypt($request['password']),
                    'generate_password_token'    =>  null
                ]);
                $token = JWTAuth::fromUser($user);
                return \response()->json([
                    'token' =>  $token
                ], Response::HTTP_OK);
            }

            return \response()->json([
                'message'   =>  'User is not exist.'
            ], Response::HTTP_BAD_REQUEST);
        } catch(\Exception $e) {
            return \response()->json([
                'error' => $e,
                'message' => 'Unexpected error'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    protected function refresh()
    {
        try {
            $refreshed = JWTAuth::refresh(JWTAuth::getToken());
            JWTAuth::setToken($refreshed)->toUser();
        } catch(\Exception $e) {
            return \response()->json([
                'error' =>  $e
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message'   =>  'Successfully refreshed token',
            'token' =>  $refreshed
        ], Response::HTTP_OK);

    }

    protected function delete(Request $request)
    {
        $valid = validator($request->only(
            'id'
        ), [
            'id' => 'required|integer'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        $data = \request()->only('id');

        try {
            User::destroy($data['id']);
            return \response()->json([
                'message' => 'Successfully removed user.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/backoffice/logout",
     *     tags={"BACKOFFICE USER"},
     *     summary="Logout backoffice user",
     *     description="Only for authenticated users.",
     *     operationId="logout",
     *     @OA\Response(
     *         response=200,
     *         description="Token was successfully invalidated.")
     * )
     */
    protected function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return \response()->json([
            'status' => 'logout',
            'message' => 'Token was successfully invalidated.'
        ], Response::HTTP_OK);
    }
}
