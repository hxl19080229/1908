<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Num_admin;
use App\User_admin;
class CreateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('carete.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function indexss()
    {
        $admin = User_admin::leftjoin('num_admin','user_admin.aid','=','num_admin.aid')
                ->paginate();
        // dd($admin);
        return view('create.indexss',['admin'=>$admin]);
    }
    /**
     * Show the form for creating a new resource.
     *添加
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create.create');
    }

    /**
     * Store a newly created resource in storage.
     *执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $data = $request->except('_token');
        
        $data['pwd'] = encrypt($data['pwd']);
        // dd($data);
        $res = User_admin::create($data);
        $num = num_admin::create($data);
        // dd($num);
        if($res){
            return redirect('/create/indexss');
        }
    }
   
}   