<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    protected $table = "cate";
    protected $primaryKey = 'c_id';
    public $timestamps = false;
    protected $guarded = [];
    // protected $primaryKey = 'b_id';
    // public $timestamps = false;
    // protected $guarded = [];

}
