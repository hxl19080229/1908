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
​<center><h2 class="danger">外来入口列表</h2></center>
<form action="">
    <input type="text" name="username" value="{{$username}}" placeholder="请输入用户名">
    <button type="submit" class="btn btn-default btn-danger">搜索</button>
</form>
<table class="table">
    
    <thead>
        <tr  class="warning">
            <th>ID</th>
            <th>用户名</th>
            <th>年龄</th>
            <th>身份证号码</th>
            <th>头像</th>
            <th>是否湖北人</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
    </thead>
    <!-- class="danger" class="success"-->
    <tbody>
        @foreach($data as $k=>$v)
        <tr @if($k%2==0) class="success" @else class="danger" @endif>
            <td>{{$v->p_id}}</td>
            <td>{{$v->username}}</td>
            <td>{{$v->age}}</td>
            <td>{{$v->card}}</td>
            <td>
            @if($v->head)
            <img src="{{env('UPLOAD_URL')}}{{$v->head}}" width="100" height="100">
            @endif
            </td>
            <td>{{$v->is_hubei==1?'√':'×'}}</td>
            <td>{{date('Y-m-d h:i:s')}}</td>
            <td>
            <a href="{{url('people/edit/'.$v->p_id)}}" class="btn btn-info">编辑</a>||
            <a href="{{url('people/destroy/'.$v->p_id)}}" class="btn btn-danger">删除</a>
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="7">
                {{$data->appends(['username'=>$username])->links()}}
            </td>
        </tr>
    </tbody>
</table>
​
</body>
</html>


 
