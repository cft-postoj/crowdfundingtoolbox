<?php


namespace Modules\UserManagement\Services;
use Illuminate\Http\Response;

use Modules\UserManagement\Repositories\UserPaymentOptionsRepository;

class UserPaymentOptionService
{
    private $userPaymentOptionRepository;

    public function __construct(UserPaymentOptionsRepository $userPaymentOptionsRepository)
    {
        $this->userPaymentOptionRepository = $userPaymentOptionsRepository;
    }

    public function update($request, $portal_user_id)
    {
        try {
            if ($this->userPaymentOptionRepository->getByPortalUser($portal_user_id) !== null) {
                $this->userPaymentOptionRepository->update($request, $portal_user_id);
            } else {
                $myArray = array();
                array_push($myArray, $request);
                array_push($myArray, array(
                    'portal_user_id' => $portal_user_id
                ));
                $this->userPaymentOptionRepository->create(array_merge(...$myArray));
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Rsponse::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => 'Successfully updated payment option for user.'
        ], Response::HTTP_CREATED);

    }
}