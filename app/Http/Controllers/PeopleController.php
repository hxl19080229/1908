<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use DB;
use App\people;
use App\Http\Requests\StorePeoplePost;
use App\Http\Requests\UpdatePeoplePost;
use Validator;
use Illuminate\Validation\Rule;
class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *列表展示页
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 分页+搜索
        $username = request()->username??'';
        $where = [];
        if($username){
            $where[] = ['username','like',"%$username%"];
        }
        $pageSize = config('app.pageSize');
        $data = people::where($where)->orderby('p_id','desc')->paginate($pageSize);
        // DB操作
        // $data = DB::table('people')->select('*')->get();
        // ORM两种操作all()和get()
        // $data = People::all();
        // $data = People::get();
        // dd($data);

        return view('people.index',['data'=>$data,'username'=>$username]);
    }

    /**
     * Show the form for creating a new resource.
     *添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('people.create');
    }

    /**
     * Store a newly created resource in storage.
     *执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // 第二种验证 
        // public function store(StorePeoplePost $request){
    

        // 第一种验证 validate
        $request->validate([
            // 'username'=>'required|unique:people|max:12|min:2',
            'username'=>'required|unique:people|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]{2,12}$/u',
            'age'=>'required|integer|between:1,200',
        ],[
            'username.required'=>'名字不能为空',
            'username.unique'=>'名字已存在',
            'username.regex'=>'名字必须为中文、数字、字母、下划线以及破折号长度为2-12位',
            // 'username.max'=>'名字长度不超过12位',
            // 'username.min'=>'名字长度不于2位',
            'age.required'=>'年龄不能为空',
            'age.integer'=>'年龄必须为数字',
            'age.between'=>'年龄数据不合法',
        ]);
        $data = $request->except('_token');
        // dd($data);
        // 第三种验证 validator
        // $validator = Validator::make($data,[
        //     // 'username'=>'required|unique:people|max:12|min:2',
        //     'username'=>'required|unique:people|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]{2,12}$/u',
        //     'age'=>'required|integer|between:1,200',
        // ],[
        //         'username.required'=>'名字不能为空',
        //         'username.unique'=>'名字已存在',
        //         'username.regex'=>'名字必须为中文、数字、字母、下划线以及破折号长度为2-12位',
        //         // 'username.max'=>'名字长度不超过12位',
        //         // 'username.min'=>'名字长度不于2位',
        //         'age.required'=>'年龄不能为空',
        //         'age.integer'=>'年龄必须为数字',
        //         'age.between'=>'年龄数据不合法',
                
        // ]);
        // if ($validator->fails()) {
        //     return redirect('people/create')
        //     ->withErrors($validator)
        //     ->withInput();
        //     }
        // 判断有误文件上传
        if($request->hasFile('head')){
            // $img = $this->upload('head');
            // dd($img);
            // 上传文件放公共文件了 内部调用 $this->函数名()  外部调用 函数名()
            // $data['head'] = $this->upload('head');
            $data['head'] = upload('head');
        }
        // dd($data);
        $data['add_time'] = time();
        // DB操作
        // $res = DB::table('people')->insert($data);

        // ORM操作:三种save()、create() 和 insert()
        // 1、save()-可选择添加   
        // $people = new People;
        // $people->username = $data['username'];
        // $people->age = $data['age'];
        // $people->card = $data['card'];
        // $people->head = $data['head'];
        // $people->add_time = $data['add_time'];
        // $res = $people->save();

        // 2、create()-要设置白名单和黑名单
        $res = People::create($data);
        // 3、insert()
        // $res = People::insert($data);
        // dd($res);
        if($res){
            return redirect('/people');
        }
    }
    /**
     *上传文件 封装的
     * $filename 文件域的名字
     */
    // public function upload($filename)
    // {
    //     //判断上传过程是否有误
    //     if(request()->file($filename)->isValid()){
    //         // 接收值
    //         $photo = request()->file($filename);
    //         // dd($photo);
    //         // 上传
    //         $store_result = $photo->store('uploads');
    //         // dd($store_result);
    //         return $store_result;
    //     }
    //     exit;('未获取到上传文件或上传过程错误');
    // }

    /**
     * Display the specified resource.
     *预览详情页
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *编辑页
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // DB操作
        // $user = DB::table('people')->where('p_id',$id)->first();

        // ORM操作 两种：find()和first()
        // 1、find()
        $user = People::find($id);

        // 2、first()
        // $user = People::where('p_id',$id)->first();
        // dd($user);
        return view('people.edit',['user'=>$user]);
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
        // // 第二种验证 
        // public function update(UpdatePeoplePost $request,$id){
        // echo $id;die;
        // 第一种验证 validate
        $request->validate([
            'username' => [
                'required',
                'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]{2,12}$/u',
                Rule::unique('people')->ignore($id,'p_id'),
            ],
            'age'=>'required|integer|between:1,200',
        ],[
            'username.required'=>'名字不能为空',
            'username.unique'=>'名字已存在',
            'username.regex'=>'名字必须为中文、数字、字母、下划线以及破折号长度为2-12位',
            // 'username.max'=>'名字长度不超过12位',
            // 'username.min'=>'名字长度不于2位',
            'age.required'=>'年龄不能为空',
            'age.integer'=>'年龄必须为数字',
            'age.between'=>'年龄数据不合法',
        ]);
        $user = $request->except('_token');
        // dd($user);
        // 第三种验证
        // $validator = Validator::make($user,[
        //     'username' => [
        //         'required',
        //         'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]{2,12}$/u',
        //         Rule::unique('people')->ignore($id,'p_id'),
        //     ],
        //     'age'=>'required|integer|between:1,200',
        // ],[
        //         'username.required'=>'名字不能为空',
        //         'username.unique'=>'名字已存在',
        //         'username.regex'=>'名字必须为中文、数字、字母、下划线以及破折号长度为2-12位',
        //         'age.required'=>'年龄不能为空',
        //         'age.integer'=>'年龄必须为数字',
        //         'age.between'=>'年龄数据不合法',
                
        // ]);
        // if ($validator->fails()) {
        //     return redirect('people/edit/'.$id)
        //     ->withErrors($validator)
        //     ->withInput();
        // }
        if($request->hasFile('head')){
            // $img = $this->upload('head');
            // dd($img);
            $user['head'] = $this->upload('head');
        }
        // DB操作
        // $res = DB::table('people')->where('p_id',$id)->update($user);

        //ORM操作：两种 save() 和 update()
        // 1、save()
        // $people = People::find($id);
        // $people->username = $user['username'];
        // $people->age = $user['age'];
        // $people->card = $user['card'];
        // $people->head = $user['head']??'';
        // $res = $people->save();

        // 2、update()
        $res = People::where('p_id',$id)->update($user);
        // dd($res);
        if($res!==false){
            return redirect('/people');
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
        // echo $id;die;
        // DB操作
        // $res = DB::table('people')->where('p_id',$id)->delete();

        // ORM操作
        $res = People::destroy($id);
        // dd($res);

        if($res){
            return redirect('/people');
        }
    }
}
