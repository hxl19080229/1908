<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>Bootstrap 实例 - 水平表单</title>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css">  
	<script src="/static/js/jquery.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
	<meta name="csrf-token" content="{{csrf_token()}}">
</head>
<body>
<a href="#" class="btn btn-info">货物管理</a>||
<a href="#" class="btn btn-danger">出入库记录管理</a>||
<a href="{{url('create/indexss/')}}" class="btn btn-info">用户管理</a>


</body>
</html>

