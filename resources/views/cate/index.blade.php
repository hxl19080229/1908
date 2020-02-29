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
​<center><h2 class="danger">分类列表</h2></center>
<!-- <form action="">
    <input type="text" name="title" value="" placeholder="请输入标题">
    <select name="cate" id="">
		<option value="">--请选择--</option>
		<option value="头条">头条</option>
		<option value="手机快讯">手机快讯</option>
		<option value="3G资讯">3G资讯</option>
	</select>
    <button type="submit" class="btn btn-default btn-danger">搜索</button>
</form> -->
<table class="table">
    
    <thead>
        <tr  class="warning">
            <th>ID</th>
            <th>分类名称</th>
            <th>父级分类</th>
            <th>商品描述</th>
            <th>操作</th>
        </tr>
    </thead>
    <!-- class="danger" class="success"-->
    <tbody>
        @foreach($arr as $k=>$v)
        <tr @if($k%2==0) class="danger" @else class="success" @endif>
            <td>{{$v->c_id}}</td>
            <td>{{$v->cate_name}}</td>
            <td>{{$v->pid}}</td>
            <td>{{$v->desc}}</td>       
            <td>
            <a href="{{url('cate/edit/'.$v->c_id)}}" class="btn btn-info">编辑</a>||
            <a href="javascript:void(o)" onclick="del({{$v->c_id}})" class="btn btn-danger">删除</a>
            </td>
        </tr>
        @endforeach
    </tbody>
    <!-- {{url('cate/edit/'.$v->c_id)}} -->
</table>

</body>
</html>
<script>
    function del(id){
        if(!id){
            return 
        }
        if(confirm('是否要删除此条记录')){
            $.get('/cate/destroy/'+id,function(res){
                if(res.code=='00000'){
                    location.href="/cate"
                }
            },
            'json'
            )

        }


    }





 /*点击删除*/
//  $(document).on("click",'.del',function(){
//         var _this = $(this)  //当前点击的删除按钮
//         //获取到要删除的商品id
//         var goods_id = _this.parents('tr').attr('goods_id')
//         //console.log(goods_id)
//         if(window.confirm("是否确认删除？")){
//                 //通过ajax技术把商品id传给控制器
//                 $.ajax({
//                     url:"{:url('cart/cartDel')}",
//                     data:{goods_id:goods_id},
//                     type:"post",
//                     dataType:"json",
//                     async:false,
//                     success:function(res){
//                         //console.log(res)
//                         if(res.code==1){
//                             _this.parents('tr').remove()
//                         }else{
//                             alert(res.font)
//                         }
//                     }
//                 })
//         }
//     }
</script>

 
