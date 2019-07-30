<?php


namespace Modules\UserManagement\Repositories;


use Modules\UserManagement\Entities\UserGdpr;

class UserGdprRepository implements UserGdprRepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = UserGdpr::class;
    }

    public function all()
    {
        return $this->model
            ::all();
    }

    public function get($portal_user_id)
    {
        return $this->model
            ::where('portal_user_id', $portal_user_id)
            ->first();
    }

    public function create($request, $portal_user_id)
    {
        return $this->model
            ::create([
                'portal_user_id'    =>  $portal_user_id,
                'agree_mail_sending'    =>  $request['agreeMailing'],
                'agree_general_conditions'  =>  $request['agreePersonalData']
            ]);
    }

    public function update($request, $portal_user_id)
    {
        return $this->model
            ::where('portal_user_id', $portal_user_id)
            ->update([
                'agree_mail_sending'    =>  $request['agreeMailing'],
                'agree_general_conditions'  =>  $request['agreePersonalData']
            ]);
    }
}