<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie; 
use App\Goods;
use App\Brand;
use App\Cate;
use Illuminate\Support\Facades\Cache;
/**
 * 前台首页
 */
class IndexController extends Controller
{
    // 前台首页
    public function index(){
        $goods_name = request()->goods_name??'';
        $where = [];
        if($goods_name){
            $where[] = ['goods_name','like',"%$goods_name%"];
        }
        // $arr = Goods::get();
        // $arr['goods_imgs'] = explode('|',$arr['goods_imgs']);
        // dd($arr);
        // Cache::flush();
        // $pageSize = config('app.pageSize');$pageSize
        // 第一种
        // $arr = Cache::get('arr');
        // 第二种
        $arr = cache('arr');
        // print_r($arr);
        if(!$arr){
            // echo "走DB==";
            $arr = Goods::leftjoin('cate','cate.c_id','=','goods.c_id')
                    ->leftjoin('brand','brand.b_id','=','goods.b_id')
                    ->where($where)
                    ->paginate();

            // 第一种        
            // Cache::put('arr',$arr,60*60*24*30);
            // 第二种
            cache(['arr'=>$arr],60*60*24*30);
        }
        foreach($arr as $k=>$v){
            $photos = explode('|',$v->goods_imgs);
        }
        $cate = Cate::all();
       
        return view('index.index',['arr'=>$arr,'cate'=>$cate,'photos'=>$photos,'goods_name'=>$goods_name]);
    }
    
}
