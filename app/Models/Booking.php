<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    public function payment_history(){
        return $this->hasMany('App\Models\Payment','booking_id','id');
    }

    public function court(){
        return $this->belongsTo('App\Models\Court')->select('id','name');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
