<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slots extends Model
{
    use HasFactory;

    protected $table = 'slot';

    protected $fillable = array('court_id','slot_number','day_id','price','is_slot_open','status');
}
