<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Student;
use Validator;
use Illuminate\Validation\Rule;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *列表页
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr = request();
        // dd($arr);
        $where = [];
        if($arr['stu_name']){
            $where[] = ['stu_name','like','%'.$arr['stu_name'].'%'];
        }
        if($arr['class']){
            $where[] = ['class','=',$arr['class']];
        }
        $pageSize = config('app.pageSize');
        $data =  Student::where($where)->orderby('stu_id','desc')->paginate($pageSize);
        // $data = Student::get();
        // $data =  DB::table('student')->select('*')->get();
        // dd($data);
        return view('Student.index',['data'=>$data,'arr'=>$arr]);
    }

    /**
     * Show the form for creating a new resource.
     *添加
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Student.create');
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
        // dd($data);
        $validator = Validator::make($data,[
            // 'stu_name'=>'required|unique:student|max:12|min:2|alpha_dash',
            'stu_name'=>'required|unique:student|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]{2,12}$/u',
            'stu_age'=>'required|integer|between:8,111',
            'grade'=>'required|integer|between:0,100',
        ],[
            'stu_name.required'=>'名字必填',
            'stu_name.unique'=>'名字已存在',
            // 'stu_name.alpha_dash'=>'名字必须为中文、字母和数字，以及破折号和下划线',
            'stu_name.regex'=>'名字必须为中文、数字、字母、下划线以及破折号长度为2-12位',
            // 'stu_name.max'=>'名字长度不超过12位',
            // 'stu_name.min'=>'名字长度不少于2位',
            'stu_age.required'=>'年龄必填',
            'stu_age.integer'=>'年龄必须为数字',
            'stu_age.between'=>'年龄数据不合法',
            'grade.required'=>'分数必填',
            'grade.integer'=>'分数必须为数字',
            'grade.between'=>'分数不合法',
        ]);
        if($validator->fails()){
            return redirect('student/create/')
            ->withErrors($validator)
            ->withInput();
        }
        if($request->hasFile('stu_img')){
            // $img = $this->upload('stu_img');
            // dd($img);
            $data['stu_img'] = upload('stu_img');
        }
        // dd($data);
        $res = Student::insert($data);
        // dd($data);
        if($res){
            return redirect('/student');
        }
    }
    /**
     * 上传文件
     *$filename 文件域的名字
     * 
     */
    // public function upload($filename)
    // {
    //     //判断上传过程是否有误
    //     if(request()->file($filename)->isValid()){
    //         // 接收值
    //         $photo = request()->file($filename);
    //         // dd($photo);
    //         //上传 
    //         $store_result = $photo->store('uploads');
    //         // dd($store_result);
    //         return $store_result;
    //     }
    //     exit;('未获取到上传文件或上传过程错误');
    // }
    /**
     * Display the specified resource.
     *详情预览
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
        // dd($id);
        $stu_id = DB::table('student')->where('stu_id',$id)->first();
        // dd($stu_id);
        return view('student.edit',['stu_id'=>$stu_id]);
    }

    /**
     * Update the specified resource in storage.
     *执行编辑--修改
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $stu_id = $request->except('_token');
        $validator = Validator::make($stu_id,[
            'stu_name' => [
                'required',
                'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]{2,12}$/u',
                Rule::unique('student')->ignore($id,'stu_id'),
            ],
            'stu_age'=>'required|integer|between:8,111',
            'grade'=>'required|integer|between:0,100',
        ],[
            'stu_name.required'=>'名字必填',
            'stu_name.unique'=>'名字已存在',
            'stu_name.regex'=>'名字必须为中文、数字、字母、下划线以及破折号长度为2-12位',
            'stu_age.required'=>'年龄必填',
            'stu_age.integer'=>'年龄必须为数字',
            'stu_age.between'=>'年龄数据不合法',
            'grade.required'=>'分数必填',
            'grade.integer'=>'分数必须为数字',
            'grade.between'=>'分数不合法',
        ]);
        if($validator->fails()){
            return redirect('student/edit/'.$id)
            ->withErrors($validator)
            ->withInput();
        }
        if($request->hasFile('stu_img')){
            // $img = $this->upload('head');
            // dd($img);
            $stu_id['stu_img'] = $this->upload('stu_img');
        }
        $res = Student::where('stu_id',$id)->update($stu_id);
        // $res = DB::table('student')->where('stu_id',$id)->update($stu_id);
        if($res!==false){
            return redirect('/student');
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
        $res = DB::table('student')->where('stu_id',$id)->delete();
        if($res){
            return redirect('/student');
        }
    }
}
