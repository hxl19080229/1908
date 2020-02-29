<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Num_admin extends Model
{
    protected $table = "num_admin";
    protected $primaryKey = 'aid';
    public $timestamps = false;
    protected $guarded = [];
}