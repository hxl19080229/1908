<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_admin extends Model
{
    protected $table = "user_admin";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}