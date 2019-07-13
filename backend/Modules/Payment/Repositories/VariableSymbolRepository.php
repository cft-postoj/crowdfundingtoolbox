<?php


namespace Modules\Payment\Repositories;


use Modules\Payment\Entities\VariableSymbol;

class VariableSymbolRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = VariableSymbol::class;
    }

    public function create($portal_user_id, $variable_symbol)
    {
        return $this->model
            ::create([
                'portal_user_id' => $portal_user_id,
                'variable_symbol' => $variable_symbol
            ]);
    }

    public function all()
    {
        return $this->model
            ::all();
    }

    public function getLast()
    {
        return $this->model
            ::orderBy('id', 'DESC')
            ->first();
    }

    public function getByPortalUser($portal_user_id)
    {
        return $this->model
            ::where('portal_user_id', $portal_user_id)
            ->only('variable_symbol')
            ->first();
    }

    public function getPortalUserByVariableSymbol($variable_symbol)
    {
        return $this->model
            ::where('variable_symbol', $variable_symbol)
            ->pluck('portal_user_id')
            ->first();
    }
}