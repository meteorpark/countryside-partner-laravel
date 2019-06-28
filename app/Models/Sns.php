<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sns extends Model
{
    protected $table = "cp_sns";
    protected $hidden = ['updated_at', 'created_at'];
    protected $guarded = [];

}
