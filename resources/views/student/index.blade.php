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
​<center><h2 class="danger">学生表</h2></center>
<form action="">
    <input type="text" name="stu_name" value="{{$arr['stu_name']}}" placeholder="请输入名称">
    <select name="class" id="">
        <option value="">--请选择班级--</option>
		<option value="1908A" {{$arr['class']=='1908A'?'selected':''}}>1908A</option>
		<option value="1908B" {{$arr['class']=='1908B'?'selected':''}}>1908B</option>
		<option value="1908C" {{$arr['class']=='1908C'?'selected':''}}>1908C</option>
		<option value="1908D" {{$arr['class']=='1908D'?'selected':''}}>1908D</option>
	</select>
    <button type="submit" class="btn btn-default btn-danger">搜索</button>

</form>
<table class="table">
    
    <thead>
        <tr  class="warning">
            <th>ID</th>
            <th>学生姓名</th>
            <th>年龄</th>
            <th>性别</th>
            <th>班级</th>
            <th>头像</th>
            <th>成绩</th>
            <th>操作</th>
        </tr>
    </thead>
    <!-- class="danger"  class="success" -->
    <tbody>
        @foreach($data as $k=>$v)
        <tr @if($k%2==0) class="success" @else class="danger" @endif >
            <td>{{$v->stu_id}}</td>
            <td>{{$v->stu_name}}</td>
            <td>{{$v->stu_age}}</td>
            <td>{{$v->stu_sex}}</td>
            <td>{{$v->class}}</td>
            <td>
            @if($v->stu_img)
            <img src="{{env('UPLOAD_URL')}}{{$v->stu_img}}" width="100" height="100" >
            @endif
            </td>
            <td>{{$v->grade}}</td>
            <td>
            <a href="{{url('student/edit/'.$v->stu_id)}}" class="btn btn-info">编辑</a>||
            <a href="{{url('student/destroy/'.$v->stu_id)}}" class="btn btn-danger">删除</a>
            </td>
        </tr>
      @endforeach
    </tbody>
</table>
​{{$data->appends(['stu_name'=>$arr['stu_name'],'class'=>$arr['class']])->links()}}
</body>
</html>


 
