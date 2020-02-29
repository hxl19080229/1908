<!-- RUNOOB.COM -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bootstrap 实例 - 上下文类</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">  
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
​<center><h2 class="danger">商品列表展示</h2></center>
<form action="">
    <input type="text" name="goods_name" value="{{$goods_name}}" placeholder="请输入商品名称">
    <select name="b_id" id="">
			<option value="">--请选择--</option>
			@foreach($brand as $v)	
                <option value="{{$v->b_id}}" {{$data==$v->b_id?'selected':''}}>
                    {{$v->b_name}}
                </option>
			@endforeach	
	</select>
    <button type="submit" class="btn btn-default btn-danger">搜索</button>
</form>
<table class="table">
    
    <thead>
        <tr  class="warning">
            <th>商品id</th>
            <th>商品名称</th>
            <th>商品价格</th>
            <th>商品库存</th>
            <th>商品货号</th>
            <th>赠送积分</th>
            <th>商品详情</th>
            <th>商品图片</th>
            <th>商品相册</th>
            <th>是否新品</th>
            <th>是否精品</th>
            <th>是否热卖</th>
            <th>是否上架</th>
            <th>商品品牌</th>
            <th>商品分类</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
    </thead>
    <!-- class="danger" class="success"-->
    <tbody>
        @foreach($goods as $k=>$v)
        <tr @if($k%2==0) class="success" @else class="danger" @endif>
            <td>{{$v->goods_id}}</td>
            <td>{{$v->goods_name}}</td>
            <td>{{$v->goods_ptice}}</td>
            <td>{{$v->goods_num}}</td>
            <td>{{$v->goods_huohao}}</td>
            <td>{{$v->goods_score}}</td>
            <td>{{$v->goods_desc}}</td>
            <td>
                <img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}" alt="" width="100">
            </td>
            <td>
                @if($v->goods_imgs)
                    @php $photos = explode('|',$v->goods_imgs); @endphp
                        @foreach($photos as $vv)
                            <img src="{{env('UPLOAD_URL')}}{{$vv}}" alt="" width="100"> 
                        @endforeach
                @endif
            </td>
            <td>{{$v->is_new==1?'√':'×'}}</td>
            <td>{{$v->is_best==1?'√':'×'}}</td>
            <td>{{$v->is_hot==1?'√':'×'}}</td>
            <td>{{$v->is_up==1?'√':'×'}}</td>
            <td>{{$v->b_name}}</td>
            <td>{{$v->cate_name}}</td>
            <td>{{date('Y-m-d h:i:s')}}</td>
            <td>
                <a href="{{url('/goods/edit/'.$v->goods_id)}}" class="btn btn-info">编辑</a>||
                <a href="javascript:void(0)" onclick="del({{$v->goods_id}})" class="btn btn-danger">删除</a>
            </td>
        </tr>
        <!-- <td clospan="8"></td> -->
       @endforeach
    </tbody>
</table>
{{$goods->appends(['goods_name'=>$goods_name,'b_id'=>$data])->links()}}
</body>
</html>
<script>
    
    function del(id){
        if(!id){
            return; 
        }
        if(confirm('是否要删除此条记录')){
            // ajax删除
            $.get('/goods/destroy/'+id,function(res){
                if(res.code=='ok'){
                //    alert(111)
                   //reload 要结合ajax分页 删除才会自动刷新页面
                //    location.reload();
                    location.href="/goods";
                }
            },  
            'json'
            )
        }

    }



</script>

 
