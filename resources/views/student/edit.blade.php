<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>Bootstrap 实例 - 水平表单</title>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css">  
	<script src="/static/js/jquery.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
 <center><h3>学生表</h3></center> 
 @if($errors->any()) 
 <div class="alert alert-danger">
 <ul>
 @foreach($errors->all() as $error)
<li>{{$error}}</li> 
@endforeach
 </ul>
 </div>
 @endif  
<form class="form-horizontal" role="form" action="{{url('student/update/'.$stu_id->stu_id)}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">名字</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="{{$stu_id->stu_name}}" name="stu_name" id="firstname" 
				   placeholder="请输入名字">
			<b style="color:red">{{$errors->first('stu_name')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">年龄</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="{{$stu_id->stu_age}}" name="stu_age" id="firstname" 
				   placeholder="请输入名字">
			<b  class=" alert-danger">{{$errors->first('stu_age')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">性别</label>
		<label class="radio-inline">
        <input type="radio" name="stu_sex" id="optionsRadios3" value="男"> 男
   		</label>
		<label class="radio-inline">
		<input type="radio" name="stu_sex" id="optionsRadios3" value="女" checked> 女
   		</label>
	</div>
	<div class="form-group">
			
		<label for="firstname" class="col-sm-2 control-label">头像</label>
		<div class="col-sm-8">
			<input type="file" class="form-control" name="stu_img" id="firstname">
			@if($stu_id->stu_img)
            	<img src="{{env('UPLOAD_URL')}}{{$stu_id->stu_img}}" width="100" height="100" >
            @endif
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">班级</label>
		<div class="col-sm-8">
			<select name="class" id="" class="form-control">
				<option value="1908A" {{$stu_id->class=='1908A'?'selected':''}}>1908A</option>
				<option value="1908B" {{$stu_id->class=='1908B'?'selected':''}}>1908B</option>
				<option value="1908C" {{$stu_id->class=='1908C'?'selected':''}}>1908C</option>
				<option value="1908D" {{$stu_id->class=='1908D'?'selected':''}}>1908D</option>
			</select>
			<!-- <input type="text" class="form-control" value="{{$stu_id->class}}" name="class" id="firstname" 
				   placeholder="请输入名字"> -->
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">成绩</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="{{$stu_id->grade}}" name="grade" id="firstname" 
				   placeholder="请输入名字">
			 <b style="color:red">{{$errors->first('grade')}}</b>
		</div>
	</div>
	
	
	
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default btn-danger">修改</button>
		</div>
	</div>
</form>

</body>
</html>