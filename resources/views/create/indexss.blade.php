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
            <th>用户ID</th>
            <th>用户昵称</th>
            <th>用户身份</th>
            <th>操作</th>
        </tr>
    </thead>
    <!-- class="danger" class="success"-->
    <tbody>
        @foreach($admin as $k=>$v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->admin}}</td>
            <td>{{$v->name}}</td>
            <td>
            <a href="{{url('create/create/')}}" class="btn btn-info">添加</a>||
            <a href="" class="btn btn-danger">删除</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>

 
