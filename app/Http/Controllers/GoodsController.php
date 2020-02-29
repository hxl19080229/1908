<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Cate;
use App\Goods;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *商品列表展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = request();
        $goods_name = request()->goods_name??'';
        $data = request()->b_id??'';
        // dd($data);
        $where = [];
        if($goods_name){
            $where[] = ['goods_name','like','%'.$goods_name.'%'];
        }
        // if($data->goods_name){
        //     $where[] = ['goods_name','like','%'.$data->goods_name.'%'];
        // }
        $brand = Brand::all();
        // dd($brand);
        
        if($data){
            $where[] = ['brand.b_id','=',$data];
        }
        // $cate = Cate::all();

        // Cache::flush();
        // 接受当前页页码----带搜素分页的缓存
        $page = request()->page??1;
        // echo 'goods_'.$page.'_'.$goods_name;
        // 第一种
        // $goods = Cache::get('goods');
        // 第二种
        // $goods = cache('goods_'.$page.'_'.$goods_name);
        // redis第一种门面嵌入   Redis::flushall();//清除所有
        $goods = Redis::get('goods_'.$page.'_'.$goods_name);
        // dump($goods);
        if(!$goods){
            // echo "走DB==";
            $pageSize = config('app.pageSize');
            $goods = Goods::leftjoin('cate','cate.c_id','=','goods.c_id')
                    ->leftjoin('brand','brand.b_id','=','goods.b_id')
                    ->where($where)
                    ->orderby('goods_id','desc')
                    ->paginate($pageSize);
            // 存入缓存
            // 第一种        
            // Cache::put('goods',$goods,60*60*24*30);
            // 第二种
            // cache(['goods_'.$page.'_'.$goods_name=>$goods],60*60*24*30);
            // redis第一种门面嵌入
            // 序列化结果集  将object转化为字符串
            $goods = serialize($goods);
            Redis::setex('goods_'.$page.'_'.$goods_name,'20',$goods);
        }
        // 反序列化结果集  将字符串转化为object
        $goods = unserialize($goods);
        return view('goods.index',['goods'=>$goods,'brand'=>$brand,'data'=>$data,'goods_name'=>$goods_name]);
    }

    /**
     * Show the form for creating a new resource.
     *添加
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand = Brand::all();
        $cate = Cate::all();
        $cate = getCateInfo($cate);
        return view('goods.create',['brand'=>$brand,'cate'=>$cate]);
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
            'goods_name'=>'required|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{2,20}$/u',
            'goods_price'=>'required|numeric',
            'goods_num'=>'required|numeric',
            // 'goods_huohao'=>'required',
        ],[
            'goods_name.required'=>'商品名称必填',
            'goods_name.regex'=>'商品名称由中文、数字、字母、下划线2-20位组成',
            'goods_price.required'=>'商品价格必填',
            'goods_price.numeric'=>'商品价格必须为数字',
            'goods_num.required'=>'商品库存必填',
            'goods_num.numeric'=>'商品库存必须为数字',
            // 'goods_huohao.required'=>'商品货号必填',
        ]);
        $data = request()->except('_token');
        // 单文件上传
        if($request->hasFile('goods_img')){
            $data['goods_img'] = upload('goods_img');
        }
        // 多文件上传
        // dd($data['goods_imgs']);
        if(isset($data['goods_imgs'])){
            $photos = Moreupload('goods_imgs');
            // dd($photos);
            $data['goods_imgs'] = implode('|',$photos);
        }
        // dd($data['goods_imgs']);
        $data['add_time'] = time();
        $data['goods_huohao'] = $this->CreateHuohao();
        $res = Goods::create($data);
        // dd($data);
        if($res){
            return redirect('/goods');
        }
    }
    /**
     * Display the specified resource.
     *产生商品货号
     */
    public function CreateHuohao()
    {
        return 'goods'.date('ymdHis').rand(1000,9999);
    }
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
        $goods_id = request($id);
        $brand = Brand::all();
        $cate = Cate::all();
        $cate = getCateInfo($cate);
        $goods = Goods::find($id);
        return view('goods.edit',['goods'=>$goods,'brand'=>$brand,'cate'=>$cate]);
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
            // 'goods_name'=>[
            //     'required',
            //     'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{2,20}$/u',
            //     // Rule::unique('goods')->ignore($id,'goods_id'),
            // ],
            'goods_name'=>'required|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{2,20}$/u',
            'goods_price'=>'required|numeric',
            'goods_num'=>'required|numeric',
            // 'goods_huohao'=>'required',
        ],[
            'goods_name.required'=>'商品名称必填',
            'goods_name.regex'=>'商品名称由中文、数字、字母、下划线2-20位组成',
            'goods_price.required'=>'商品价格必填',
            'goods_price.numeric'=>'商品价格必须为数字',
            'goods_num.required'=>'商品库存必填',
            'goods_num.numeric'=>'商品库存必须为数字',
            // 'goods_huohao.required'=>'商品货号必填',
        ]);
        $data = request()->except('_token');
        // 单文件上传
        if($request->hasFile('goods_img')){
            $data['goods_img'] = upload('goods_img');
        }
        // 多文件上传
        // dd($data['goods_imgs']);
        if(isset($data['goods_imgs'])){
            $photos = Moreupload('goods_imgs');
            // dd($photos);
            $data['goods_imgs'] = implode('|',$photos);
        }
        // dd($data['goods_imgs']);
        $data['add_time'] = time();
        // $data['goods_huohao'] = $this->CreateHuohao();
        $res = Goods::where('goods_id',$id)->update($data);
        // dd($data);
        if($res!==false){
            return redirect('/goods');
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
        $res = Goods::destroy($id);
        // dd($res);
        if($res){
            // return redirect('/goods')
            echo json_encode(['code'=>'ok','msg'=>'ok']);
        }
    }
}
