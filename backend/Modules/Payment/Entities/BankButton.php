<?php


namespace Modules\Payment\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankButton extends Model
{
    use SoftDeletes;

    protected $table = 'bank_button';
    protected $fillable = ['order', 'image', 'redirect_link'];


    public function image()
    {
        return $this->belongsTo('\Modules\Campaigns\Entities\Image');
    }


}