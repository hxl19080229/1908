<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newss extends Model
{
    protected $table = "newss";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
    // protected $primaryKey = 'b_id';
    // public $timestamps = false;
    // protected $guarded = [];

}