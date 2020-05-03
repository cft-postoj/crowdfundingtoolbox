<?php


namespace Modules\UserManagement\Services;

use Illuminate\Http\Response;
use Modules\UserManagement\Repositories\UserPaymentOptionsRepository;

class UserPaymentOptionService
{
    private $userPaymentOptionRepository;

    public function __construct()
    {
        $this->userPaymentOptionRepository = new UserPaymentOptionsRepository();
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
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => 'Successfully updated payment option for user.'
        ], Response::HTTP_CREATED);

    }

    public function getByIban($iban)
    {
        return $this->userPaymentOptionRepository->getByIban($iban);
    }

    public function getCardId($portal_user_id)
    {
        if ($this->userPaymentOptionRepository->getByPortalUser($portal_user_id) !== null) {
            if ($this->userPaymentOptionRepository->getByPortalUser($portal_user_id)['card_id'] !== null &&
                $this->userPaymentOptionRepository->getByPortalUser($portal_user_id)['comfortPay_subscriber']) {
                return $this->userPaymentOptionRepository->getByPortalUser($portal_user_id)['card_id'];
            }
        }
        $generateCardId = $this->generateCardId();
        $this->update([
            'card_id' => $generateCardId
        ], $portal_user_id);
        return $generateCardId;
    }

    public function get($portal_user_id)
    {
        return $this->userPaymentOptionRepository->getByPortalUser($portal_user_id);
    }

    private function generateCardId()
    {
        $min = 24789;
        $max = 965548996362569999;
        $random = rand($min, $max);
        if ($this->userPaymentOptionRepository->getByCardId($random) === null) {
            return $random;
        }
        return $this->generateCardId();
    }

    public function getOptionsByIban($iban)
    {
        return $this->userPaymentOptionRepository->getOptionsByIban($iban);
    }
}
