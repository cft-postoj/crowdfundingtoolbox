<?php

namespace App\Http\Controllers\BackOfficeAPI;

use App\BackOfficeAPI\BackOfficeUser;
use App\BackOfficeAPI\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class UsersController extends Controller
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


    /**
     * @OA\Post(
     *     path="/api/backoffice/reset-password",
     *     tags={"BACKOFFICE USER"},
     *     summary="Reset password for backoffice user",
     *     @OA\Response(
     *         response=201,
     *         description="Email with new password was successfully sent.",
     *     @OA\JsonContent()
     *     ),
     *     @OA\RequestBody(
     *      description="Property role can be 1 or 2. 1 for Admin user, 2 for classic user.",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(
     *              property="email", type="string"
     *           ),
     *          example={
     *              "email": "test@test.com"}
     *
     *       )
     *
     * ),
     *     @OA\Response(
     *     response=401,
     *     description="Email is not exist"
     * )
     * )
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email'
        ]);
        try {
            if (BackOfficeUser::where('email', $request->email)->firstOrFail()) {
                // TODO: email with new password
                return \response()->json([
                    'message' => 'Email with new password was successfully sent.'
                ], 201);
            }
        } catch (\Exception $e) {
            return \response()->json([
                'error' => 'Email is not exist.'
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

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email:users',
            'password' => 'required|string'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $request->request->add([
            'scope' => 'read-only-order' // grant manage order scope for user with admin role
        ]);
        //dd(Auth::check());

        if (!Auth::guard('user')->attempt($credentials, true))
            return \response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);

        $user = Auth::guard('user')->user();
        $success['token'] = $user->createToken('CFT')->accessToken;
        return response()->json(['success' => $success], Response::HTTP_OK);
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
}
