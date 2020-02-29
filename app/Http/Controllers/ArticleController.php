<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
// use validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cookie;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = request();
        // echo $data;
        // dd($data);
        $where = [];
        if($data['title']){
            $where[] = ['title','like','%'.$data['title'].'%'];
        }
        if($data['cate']){
            $where[] = ['cate','=',$data['cate']];
        }
        // dd($data);
        // // dd($data);where($where)->paginate($pageSize)
        // $pageSize = config('app.pageSize');
        $arr = Article::where($where)->paginate(2);
        // 获取cookie第一种
        // echo request()->cookie('name');
        // 获取cookie第二种
        $value = Cookie::get('name');
        echo $value;
        // $arr = Article::all();
        // dd($arr);
        return view('article.index',['arr'=>$arr,'data'=>$data]);
    }
    // cookie的使用
    public function setCookie(){
        // 第一种
        // return response('测试产生cookie')->cookie('name','坏蛋',2);
        // 第二种 cookie全局辅助函数
        // $cookie = cookie('name','坏蛋2',2);
        // return response('测试产生cookie')->cookie($cookie);
        // 第三种 队列形式设置cookie
        // Cookie::queue(Cookie::make('age','19',2));
        // //第四种
		// Cookie::queue('name22', '坏蛋3', 2);
        // // 获取cookie第一种
        // // echo request()->cookie('name');
        // // 获取cookie第二种
        // $value = Cookie::get('name');
        // echo $value;
        // dd($data);
        // // 接收当前页页码
        // $page = request()->page??1;
        // echo 'arr_'.$page.'_'.$title;
        // // 缓存里面获取分类的值
        // $cate = cache('cate');
        // // dump($cate);
        // if(!$cate){
        //     // 获取分类数据
        //     $cate = Cate2::get();
        //     // dd($cate);
        //     // 存入缓存
        //     cache(['cate'=>$cate],1*60);
        // }
        // // // 获取缓存的值
        // $arr = cache('arr_'.$page.'_'.$title.'_'.$c_id);
        // // dump($arr);
        // if(!$arr){
        //     // echo "走DB==";
        //     // // dd($data);where($where)->paginate(2)
        //     $pageSize = config('app.pageSize');
        //     $arr = Article::leftjoin('cate2','article.c_id','=','cate2.c_id')
        //                 ->where($where)
        //                 ->paginate($pageSize);
        //     // 存入缓存
        //     cache(['arr_'.$page.'_'.$title.'_'.$c_id],1*60);
        // }
    }
    /**
     * Show the form for creating a new resource.
     *添加
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.create');
    }
    /**
    * Show the form for creating a new resource.
    *js验证 唯一性验证
    * @return \Illuminate\Http\Response
    */
   public function checkOnly()
   {
        $title = request()->title;
        $where = [];
        if($title){
            $where[] = ['title','=',$title];
        }
        //echo 111;die;
        // 排除自身
        $a_id = request()->a_id;
        // // dd($a_id);
        if($a_id){
            $where[] = ['a_id','!=',$a_id];
        }
        // dd($a_id);
        // \DB::connection()->enableQueryLog();
        $count = Article::where($where)->count();
        // $logs = \DB::getQueryLog();
        // dd($logs);
        //echo $count;die;
        echo json_encode(['code'=>'00000','msg'=>'ok','count'=>intval($count)]);
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
            'title'=>'required|unique:article|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{2,12}$/u',
        ],[
            'title.required'=>'标题必填',
            'title.unique'=>'标题已存在',
            'title.regex'=>'标题为中文、数字、字母、下划线长度为2-12位',
        ]);
        $data = $request->except('_token');
        if($request->hasFile('img')){
            $data['img'] = upload('img');
        }
        $data['add_time'] = time();
        // dd($data);
        $res = Article::create($data);
        // dd($res);
        if($res){
            return redirect('/article');
        }
    }
     /**
     * 上传文件封装
     *filename
     * $this->
     */
    // public function upload($filename)
    // {
    //     //判断上传过程是否有误
    //     if(request()->file($filename)->isvalid()){
    //         $photo = request()->file($filename);
    //         $store_result = $photo->store('article');
    //         return $store_result;
    //     }
    //     die;('没有文件上传');
        
    // }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *编辑
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arr = Article::find($id);
        return view('article.edit',['arr'=>$arr]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>[
                'required',
                'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{2,12}$/u',
                Rule::unique('article')->ignore($id,'a_id'),
            ]
        ],[
            'title.required'=>'标题必填',
            'title.unique'=>'标题已存在',
            'title.regex'=>'标题为中文、数字、字母、下划线长度为2-12位',
        ]);
        $data = $request->except('_token');
        if($request->hasFile('img')){
            $data['img'] = $this->upload('img');
        }
        // dd($data);
        $res = Article::where('a_id',$id)->update($data);
        // dd($res);
        if($res!==false){
            return redirect('/article');
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
        $res = Article::destroy($id);
        if($res){
            // return redirect('/article')
            echo json_encode(['code'=>'00000','msg'=>'ok']);
        }
    }
}
