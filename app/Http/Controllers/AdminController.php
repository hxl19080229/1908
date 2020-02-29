<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Validation\Rule;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *列表展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $pageSize = config('app.pageSize');
        $arr = Admin::paginate(2);
        // $arr = Article::all();
        // dd($arr);
        return view('admin.index',['arr'=>$arr]);
    }

    /**
     * Show the form for creating a new resource.
     *添加
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'account'=>'required|unique:admin|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{2,20}$/u',
            'pwd'=>'required',
        ],[
            'account.required'=>'账号必填',
            'account.unique'=>'账号已存在',
            'account.regex'=>'账号为中文、数字、字母、下划线长度为2-20位',
            'pwd.required'=>'密码必填',
        ]);
        $data = $request->except('_token');
        if($request->hasFile('img')){
            $data['img'] = upload('img');
        }
        $data['pwd'] = encrypt($data['pwd']);
        $data['add_time'] = time();
        // dd($data);
        $res = Admin::create($data);
        // dd($res);
        if($res){
            return redirect('/admin');
        }
    }
    /**
    * Show the form for creating a new resource.
    *js验证 唯一性验证
    * @return \Illuminate\Http\Response
    */
   public function checkOnly()
   {
        $account = request()->account;
        $where = [];
        if($account){
            $where[] = ['account','=',$account];
        }
        //echo 111;die;
        // 排除自身
        $id = request()->id;
        // // dd($a_id);
        if($id){
            $where[] = ['id','!=',$id];
        }
        // dd($a_id);
        // \DB::connection()->enableQueryLog();
        $count = Admin::where($where)->count();
        // $logs = \DB::getQueryLog();
        // dd($logs);
        //echo $count;die;
        echo json_encode(['code'=>'00000','msg'=>'ok','count'=>intval($count)]);
   }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *编辑
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arr = Admin::find($id);
        return view('admin.edit',['arr'=>$arr]);
    }

    /**
     * Update the specified resource in storage.
     *执行编辑
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'account'=>[
                'required',
                'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{2,20}$/u',
                Rule::unique('admin')->ignore($id,'id'),
            ],
        ],[
            'account.required'=>'账号必填',
            'account.unique'=>'账号已存在',
            'account.regex'=>'账号为中文、数字、字母、下划线长度为2-20位',
        ]);
        $data = $request->except('_token');
        if($request->hasFile('img')){
            $data['img'] = upload('img');
        }
        // dd($data);
        $res = Admin::where('id',$id)->update($data);
        // dd($res);
        if($res!==false){
            return redirect('/admin');
        }
    }

    /**
     * Remove the specified resource from storage.
     *删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Admin::destroy($id);
        if($res){
            echo json_encode(['code'=>'00000','msg'=>'ok']);
        }
    }
}
