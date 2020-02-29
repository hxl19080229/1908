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
 <center><h3>商品表编辑</h3></center>   
<form class="form-horizontal" role="form" action="{{url('brand/update/'.$b_id->b_id)}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品名称</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="b_name" value="{{$b_id->b_name}}" id="firstname" 
				   placeholder="请输入名字">
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">网址</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="url" value="{{$b_id->url}}" id="firstname" 
				   placeholder="请输入名字">
		</div>
	</div>
	
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">logo</label>
		<div class="col-sm-8">
            <img src="{{env('UPLOAD_URL')}}{{$b_id->logo}}" width="100" height="100">
			<input type="file" class="form-control" name="logo" id="firstname">
            
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品描述</label>
		<div class="col-sm-8">
			
            <textarea name="desc" id="firstname" cols="30" class="form-control" rows="10" placeholder="请输入描述">
            {{$b_id->desc}}
            </textarea>
		</div>
	</div>
	
	
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-danger" >修改</button>
		</div>
	</div>
</form>

</body>
</html>