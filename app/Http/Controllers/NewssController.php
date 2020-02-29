<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Newss;
use App\Cates;
// use validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cookie;
class NewssController extends Controller
{
    /**
     * Display a listing of the resource.
     *列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo 123;die;
        $title = request()->title??'';
        $where = [];
        if($title){
            $where[] = ['newss.title','like',"%$title%"];
        }
        $c_id = request()->c_id??'';
        if($c_id){
            $where[] = ['newss.c_id','=',$c_id];
        }
        // dd($where);
        $page = request()->page??'';
        // 缓存里面获取值
        $cate = cache('cate');
        dump($cate);
        if(!$cate){
            echo "走DB==";
            // 获取分类数据
            $cate = Cates::get();
            // 存入分类缓存
            cache(['cate'=>$cate],1*60);
        }
        // $data = cache('newss_'.$page.'_'.$c_id.'_'.$title);
        // dump($data);
        // if(!$data){
        //     echo "走DB==";
            // 获取数据
            $pageSize = config('app.pageSize');
                $data = Newss::leftjoin('cates','newss.c_id','=','cates.c_id')
                    ->where($where)
                    ->paginate($pageSize);
            // 存入主表缓存
        //     cache(['newss_'.$page.'_'.$c_id.'_'.$title=>$data],1*60);
        // }
        // if(!$cate||!$data){
        //     echo "走DB==";
        //     // 获取分类数据
        //     $cate = Cates::get();
        //     // 存入分类缓存
        //     cache(['cate'=>$cate],1*100);

        //     $pageSize = config('app.pageSize');
        //     $data = Newss::leftjoin('cates','newss.c_id','=','cates.c_id')
        //         ->where($where)
        //         ->paginate($pageSize);
        //     // 存入主表缓存
        //     cache(['newss_'.$page.'_'.$c_id.'_'.$title=>$data],1*100);
        // }
        
        //  dd($data);        
        $query = request()->all();
        // dd($query);
        // 是ajax请求  即要实现ajax分页
        // dd(request()->ajax());
        if(request()->ajax()){
            return view('newss.ajaxPage',['data'=>$data,'cate'=>$cate,'query'=>$query]);
        }
        
        return view('newss.index',['data'=>$data,'cate'=>$cate,'query'=>$query]);
    }
}