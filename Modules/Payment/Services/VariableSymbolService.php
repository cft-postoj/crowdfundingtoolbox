<?php


namespace Modules\Payment\Services;


use Illuminate\Http\Response;
use Modules\Payment\Repositories\VariableSymbolRepository;

class VariableSymbolService
{
    private $variableSymbolRepository;
    private $initialVariableSymbol;

    public function __construct(VariableSymbolRepository $variableSymbolRepository)
    {
        $this->variableSymbolRepository = $variableSymbolRepository;
        $this->initialVariableSymbol = 100000; // Initial variable symbol for portal users
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
            $lastVariableSymbol = $this->variableSymbolRepository->getLast();
            $userVariableSymbol = $this->initialVariableSymbol;
            if ($this->variableSymbolRepository->getLast() !== null) {
                $userVariableSymbol = $lastVariableSymbol['variable_symbol'] + 1;
            }
            $this->variableSymbolRepository->create($portal_user_id, $userVariableSymbol);
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

    }
}