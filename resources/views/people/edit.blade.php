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
 <center><h3>外来人员</h3></center>   
 @if($errors->any()) 
 <div class="alert alert-danger">
 <ul>
 @foreach($errors->all() as $error)
<li>{{$error}}</li> 
@endforeach
 </ul>
 </div>
 @endif
<form class="form-horizontal" role="form" action="{{url('people/update/'.$user->p_id)}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">名字</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="{{$user->username}}" name="username" id="firstname" 
				   placeholder="请输入名字">
			<b style="color:red">{{$errors->first('username')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">年龄</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="{{$user->age}}" name="age" id="firstname" 
				   placeholder="请输入名字">
			<b style="color:red">{{$errors->first('age')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">身份证号码</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="{{$user->card}}" name="card" id="firstname" 
				   placeholder="请输入名字">
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">头像</label>
		<div class="col-sm-8">
			<input type="file" class="form-control" name="head" id="firstname">
			@if($user->head)
            <img src="{{env('UPLOAD_URL')}}{{$user->head}}" width="100" height="100">
            @endif
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否湖北人</label>
		<label class="radio-inline">
        <input type="radio" name="is_hubei" id="optionsRadios3" value="1" {{$user->is_hubei==1?'checked':''}}> 是
   		</label>
		<label class="radio-inline">
		<input type="radio" name="is_hubei" id="optionsRadios3" value="2" {{$user->is_hubei==2?'checked':''}}> 否
   		</label>
	</div>
	
	
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">修改</button>
		</div>
	</div>
</form>

</body>
</html>