<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cates extends Model
{
    protected $table = "cates";
    protected $primaryKey = 'c_id';
    public $timestamps = false;
    protected $guarded = [];
    // protected $primaryKey = 'b_id';
    // public $timestamps = false;
    // protected $guarded = [];

}
