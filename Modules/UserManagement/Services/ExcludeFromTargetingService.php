<?php


namespace Modules\UserManagement\Services;


use Illuminate\Http\Response;
use Modules\UserManagement\Repositories\ExcludeFromTargetingRepository;

class ExcludeFromTargetingService
{
    private $portalUserId;
    private $excludeFromTargetingRepository;

    public function __construct(ExcludeFromTargetingRepository $excludeFromTargetingRepository)
    {
        $this->excludeFromTargetingRepository = $excludeFromTargetingRepository;
    }

    public function exclude($request, $portalUserId)
    {
        $this->portalUserId = $portalUserId;

        $valid = validator($request->only(
            'exclude'
        ), [
            'exclude' => 'required|boolean'
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        try {
            if ($request['exclude'] === true) {
                $this->create();
            } else {
                $this->delete();
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' =>  $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' =>  'Success.'
        ], Response::HTTP_CREATED);
    }

    private function create()
    {
       return $this->excludeFromTargetingRepository->create($this->portalUserId);
    }

    private function delete() {
        return $this->excludeFromTargetingRepository->delete($this->portalUserId);
    }
}