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
​<center><h2 class="danger">管理员列表</h2></center>

<table class="table">
    
    <thead>
        <tr  class="warning">
            <th>ID</th>
            <th>管理员账号</th>
            <th>手机号</th>
            <th>管理员email</th>
            <th>管理员头像</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
    </thead>
    <!-- class="danger" class="success"-->
    <tbody>
        @foreach($arr as $k=>$v)
        <tr @if($k%2==0)class="success" @else class="danger" @endif>
            <td>{{$v->id}}</td>
            <td>{{$v->account}}</td>
            <td>{{$v->phone}}</td>
            <td>{{$v->email}}</td>
            <td>
            <img src="{{env('UPLOAD_URL')}}{{$v->img}}" alt="" whid="100" height="100">
            </td>
            <td>{{date('Y-m-d h:i:s')}}</td>
            <td>
            <a href="{{url('admin/edit/'.$v->id)}}" class="btn btn-info">编辑</a>||
            <a href="javascript:void(0)" onclick="del({{$v->id}})" class="btn btn-danger">删除</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
​{{$arr->links()}}
</body>
</html>
<script>
    function del(id){
        if(!id){
            return; 
        }
        if(confirm('是否要删除此条记录')){
            // ajax删除
            $.get('/admin/destroy/'+id,function(res){
                if(res.code=='00000'){
                   // alert(111)
                   //reload 要结合ajax分页 删除才会自动刷新页面
                   // location.reload();
                    location.href="/admin";
                }
            },  
            'json'
            )
        }





    }



</script>

 
