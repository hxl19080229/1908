<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        echo '欢迎 坏蛋';
    }
    public function add(){
        // echo "添加用户";
        return view('user.add');
    }

    public function adddo(){
        // echo "添加用户";
        // return view('user.add');
        $data = input();
        echo $data;
    }




}
