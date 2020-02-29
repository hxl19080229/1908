<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop_user extends Model
{
    protected $table = "shop_user";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}