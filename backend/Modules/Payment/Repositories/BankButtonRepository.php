<?php

namespace Modules\Payment\Repositories;


use Modules\Payment\Entities\BankButton;

class BankButtonRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = BankButton::class;
    }

    public function getBankButtons()
    {
        return BankButton::with('image')->orderBy('order')->get();
    }

    public function create($bankButton)
    {
        return $bankButton->save();
    }

    public function delete($id)
    {
        return $this->model::find($id)->delete();
    }

    public function update($newButton)
    {
        return $this->model
            ::where('id', $newButton['id'])
            ->update([ 'order' =>$newButton['order'],
                'image_id'=>$newButton['image_id'],
                'redirect_link'=>$newButton['redirect_link']
        ]);
    }
}