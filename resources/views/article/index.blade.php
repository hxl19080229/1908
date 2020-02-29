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
​<center><h2 class="danger">文章</h2></center>
<form action="">
    <input type="text" name="title" value="{{$data['title']}}" placeholder="请输入标题">
    <select name="cate" id="">
		<option value="">--请选择--</option>
		<option value="头条" {{$data['title']=='头条'?'selected':''}}>头条</option>
		<option value="手机快讯" {{$data['title']=='手机快讯'?'selected':''}}>手机快讯</option>
		<option value="3G资讯" {{$data['title']=='3G资讯'?'selected':''}}>3G资讯</option>
	</select>
    <button type="submit" class="btn btn-default btn-danger">搜索</button>
</form>
<table class="table">
    
    <thead>
        <tr  class="warning">
            <th>ID</th>
            <th>文章标题</th>
            <th>文章分类</th>
            <th>文章重要性</th>
            <th>是否显示</th>
            <th>上传文件</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
    </thead>
    <!-- class="danger" class="success"-->
    <tbody>
        @foreach($arr as $k=>$v)
        <tr @if($k%2==0)class="success" @else class="danger" @endif>
            <td>{{$v->a_id}}</td>
            <td>{{$v->title}}</td>
            <td>{{$v->cate}}</td>
            <td>{{$v->zyx}}</td>
            <td>{{$v->is_show=='1'?'√':'×'}}</td>
            <td>
            <img src="{{env('UPLOAD_URL')}}{{$v->img}}" alt="" whid="100" height="100">
            </td>
            <td>{{date('Y-m-d h:i:s')}}</td>
            <td>
            <a href="{{url('article/edit/'.$v->a_id)}}" class="btn btn-info">编辑</a>||
            <a href="javascript:void(0)" onclick="del({{$v->a_id}})" class="btn btn-danger">删除</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
​{{$arr->appends(['title'=>$data['title'],'cate'=>$data['cate']])->links()}}
</body>
</html>
<script>
    function del(id){
        if(!id){
            return; 
        }
        if(confirm('是否要删除此条记录')){
            // ajax删除
            $.get('/article/destroy/'+id,function(res){
                if(res.code=='00000'){
                   // alert(111)
                   //reload 要结合ajax分页 删除才会自动刷新页面
                   // location.reload();
                    location.href="/article";
                }
            },  
            'json'
            )
        }





    }



</script>

 
