<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cate;
use Illuminate\Validation\Rule;
class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $pageSize = config('app.pageSize');
        //{{$arr->links()}} //
        // $arr = Cate::paginate($pageSize);
        $arr = Cate::all();
        return view('cate.index',['arr'=>$arr]);
    }
  
    /**
     * Show the form for creating a new resource.
     *添加
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cate = Cate::all();
        // dd($cate);
        $res = getCateInfo($cate);
        // dd($res);
        return view('cate.create',['res'=>$res]);
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
            'cate_name'=>'required|unique:cate|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{2,16}$/u',
        ],[
            'cate_name.required'=>'分类名称必填',
            'cate_name.unique'=>'分类名称已存在',
            'cate_name.regex'=>'分类名称由中文、数字、字母、下划线组成2-16位组成',
        ]);
        $data = request()->except('_token');
        // dd($data);
        $res  = Cate::create($data);
        // dd($res);
        if($res){
            return redirect('/cate');
        }
    }
     /**
     * Display the specified resource.
     *js验证 唯一性验证
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkOnly()
    {
    $cate_name = request()->cate_name;
    $where = [];
    if($cate_name){
        $where[] = ['cate_name','=',$cate_name];
    }
    //echo 111;die;
    // 排除自身
    $c_id = request()->c_id;
    // // dd($a_id);
    if($c_id){
        $where[] = ['c_id','!=',$c_id];
    }
    // dd($a_id);
    // \DB::connection()->enableQueryLog();
    $count = Cate::where($where)->count();
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
        $arr = Cate::find($id);
        return view('cate.edit',['arr'=>$arr]);
    }

    /**
     * Update the specified resource in storage.
     *执行修改
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cate_name'=>[
                'required',
                'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{2,16}$/u',
                Rule::unique('cate')->ignore($id,'c_id'),
            ]
        ],[
            'cate_name.required'=>'分类名称必填',
            'cate_name.unique'=>'分类名称已存在',
            'cate_name.regex'=>'分类名称由中文、数字、字母、下划线组成2-16位组成',
        ]);
        $data = request()->except('_token');
        // dd($data);
        $res  = Cate::where('c_id',$id)->update($data);
        // dd($res);
        if($res!==false){
            return redirect('/cate');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Cate::destroy($id);
        if($res){
            echo json_encode(['code'=>'00000','msg'=>'ok']);
        }
    }
}
