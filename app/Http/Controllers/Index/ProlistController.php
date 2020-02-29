<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
class ProlistController extends Controller
{
    // 商品列表展示
    public function prolist(){
        // 分页+搜索
        $goods_name = request()->goods_name??'';
        $where = [];
        if($goods_name){
            $where[] = ['goods_name','like',"%$goods_name%"];
        }
        // $pageSize = config('app.pageSize');$pageSize
        // 第一种
        // $pro = Cache::get('pro');
        // 第二种
        // $pro = cache('pro');
         // redis第一种门面嵌入   Redis::flushall();//清除所有
         $pro = Redis::get('pro_'.$goods_name);
        dump($pro);
        if(!$pro){
            echo "走DB==";
            $pro = Goods::where($where)->paginate();
            // 第一种报错        
            // Cache::put('pro',$pro,60*60*24*30);
            // 第二种报错
            // cache(['pro'=>$pro],60*60*24*30);
            // 序列化结果集  将object转化为字符串
            $pro = serialize($pro);
            Redis::setex('pro_'.$goods_name,'20',$pro);
        }
        // 反序列化结果集  将字符串转化为object
        $pro = unserialize($pro);
        return view('index.prolist',['pro'=>$pro,'goods_name'=>$goods_name]);
    }
    public function proinfo(){
        // $goods_id = 
        // redis第一种门面嵌入   Redis::flushall();//清除所有
        $goods = Redis::get('goods_');
        dump($goods);
        if(!$goods){
            echo "走DB==";
            $goods = Goods::all();
            $goods = serialize($goods);
            Redis::setex('goods_','20',$goods);
        }
        // Redis::inrc('goods');
        // 反序列化结果集  将字符串转化为object
        $goods = unserialize($goods);
        foreach($goods as $k=>$v){
            $photos = explode('|',$v->goods_imgs);
        }
        // dd($photos);
        return view('index.proinfo',['goods'=>$goods,'photos'=>$photos]);
    }
    
}
