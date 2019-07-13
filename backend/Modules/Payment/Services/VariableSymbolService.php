<?php


namespace Modules\Payment\Services;


use Illuminate\Http\Response;
use Modules\Payment\Repositories\VariableSymbolRepository;
use Modules\UserManagement\Services\PortalUserService;

class VariableSymbolService
{
    private $variableSymbolRepository;
    private $initialVariableSymbol;
    protected $portalUserService;

    public function __construct(VariableSymbolRepository $variableSymbolRepository)
    {
        $this->variableSymbolRepository = $variableSymbolRepository;
        $this->initialVariableSymbol = 100000; // Initial variable symbol for portal users
        //$this->portalUserService = $portalUserService;
    }

    public function all()
    {
        return response()->json(
            $this->variableSymbolRepository->all(),
            Response::HTTP_OK
        );
    }

    public function create($portal_user_id)
    {
        try {
            $this->variableSymbolRepository->create($portal_user_id, $this->generateVariableSymbol());
        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception->getMessage()
            ],
                Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'message' => 'Successfully generated variable symbol.'
        ],
            Response::HTTP_CREATED);
    }

    private function generateVariableSymbol()
    {
        $userVariableSymbol = $this->initialVariableSymbol;
        $lastVariableSymbol = $this->variableSymbolRepository->getLast();
        if ($this->variableSymbolRepository->getLast() !== null) {
            $userVariableSymbol = $lastVariableSymbol['variable_symbol'] + 1;
        }
        return $userVariableSymbol;
    }

    public function getByPortalUser()
    {
        return $this->variableSymbolRepository->getByPortalUser($this->portalUserService->getPortalUserIdFromToken());
    }

    public function getPortalUserByVariableSymbol($variable_symbol)
    {
        return $this->variableSymbolRepository->getPortalUserByVariableSymbol($variable_symbol);
    }
}