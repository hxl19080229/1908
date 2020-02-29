<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *列表页面
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Brand::get();
        // dd($data);
        return view('brand.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brand.create');
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
        if($request->hasFile('logo')){
            $data['logo'] = $this->upload('logo');
        }
        // dd($data);
        $res = Brand::insert($data);
        if($res){
            return redirect('/brand');
        }

    }
    /**
     * 文件上传封装
     *$filename 文件域的名字
     */
    public function upload($filename)
    {
       
        if(request()->file($filename)->isValid()){
            $photo = request()->file($filename);
            $store_result = $photo->store('brang_logo');
            return $store_result;
        }
        exit;('网络错误');
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
        $b_id = Brand::find($id);
        return view('brand.edit',['b_id'=>$b_id]);
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
        $data = $request->except('_token');
        if($request->hasFile('logo')){
            $data['logo'] = $this->upload('logo');
        }
        // dd($data);
        $res = Brand::where('b_id',$id)->update($data);
        if($res){
            return redirect('/brand');
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
        $res  = Brand::destroy($id);
        return redirect('/brand');
    }
}
