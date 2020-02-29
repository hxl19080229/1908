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
 <center><h3>文章</h3></center>  
 @if($errors->any()) 
 <div class="alert alert-danger">
 <ul>
 @foreach($errors->all() as $error)
<li>{{$error}}</li> 
@endforeach
 </ul>
 </div>
 @endif
<form class="form-horizontal" role="form" action="{{url('article/store')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">文章标题</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="title" id="firstname" 
				   placeholder="请输入名字">
			<b style="color:red">{{$errors->first('title')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">文章分类</label>
		<div class="col-sm-8">
			<select name="cate" id="">
				<option value="">--请选择--</option>
				<option value="头条">头条</option>
				<option value="手机快讯">手机快讯</option>
				<option value="3G资讯">3G资讯</option>
			</select>
		</div>
	</div>
    <div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">文章重要性</label>
		<label class="radio-inline">
        <input type="radio" name="zyx" id="optionsRadios3" value="普通" checked> 普通
   		</label>
		<label class="radio-inline">
		<input type="radio" name="zyx" id="optionsRadios3" value="置顶" > 置顶
   		</label>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否显示</label>
		<label class="radio-inline">
        <input type="radio" name="is_show" id="optionsRadios3" value="1" checked> 显示
   		</label>
		<label class="radio-inline">
		<input type="radio" name="is_show" id="optionsRadios3" value="2" > 不显示
   		</label>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">文章作者</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="men" id="firstname" 
				   placeholder="请输入名字">
				<b style="color:red">{{$errors->first('men')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">作者email</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="email" id="firstname" 
				   placeholder="请输入名字">
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">关键字</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="gjz" id="firstname" 
				   placeholder="请输入名字">
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">网页描述</label>
		<div class="col-sm-8">
			<textarea name="desc" id="" cols="30" rows="10"></textarea>
			
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">上传文件</label>
		<div class="col-sm-8">
			<input type="file" class="form-control" name="img" id="firstname">
		</div>
	</div>
	
	
	
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="button" id="btn" class="btn btn-default btn-danger">添加</button>
			<button type="button" class="btn btn-default btn-danger">重置</button>

		</div>
	</div>
</form>

</body>
</html>
<script>
	// 点击事件
	$('#btn').click(function(){
		// alert(543)
		var titleflag = true;
		$('input[name="title"]').next().html('')
		// 验证标题
		var title = $('input[name="title"]').val()
		// alert(title)
		var reg = /^[\u4e00-\u9fa5A-Za-z0-9_]+$/
		// alert(reg.test(title))
		if(!reg.test(title)){
			$('input[name="title"]').next().html('文章标题由中文数字字母下划线组成且不为空')
			return;
		}
		$.ajax({
			type:'post',
			url:"/article/checkOnly",
			data:{title:title},
			 async:false,
			dataType:'json',
			success:function(res){
			// alert(res);
				if(res.count>0){
					$('input[name="title"]').next().html('已存在')
					titleflag = false;
				}
			}
		})
		if(!titleflag){
			return
		}
		// 作者验证
		var men = $('input[name="men"]').val()
		var reg = /^[\u4e00-\u9fa5A-Za-z0-9_]{2,8}$/
		// alert(reg.test(men));
		if(!reg.test(men)){
			$('input[name="men"]').next().html('文章作者由中文数字字母下划线组成且不为空长度为2-8位')
			return
		}
		// form 提交
		$('form').submit()
	})

	// 失去焦点
	$('input[name="title"]').blur(function(){
		// alert(123)
		$(this).next().html('')
		// alert(1)
		var title = $(this).val()
		// alert(title)
		var reg = /^[\u4e00-\u9fa5A-Za-z0-9_]+$/
		// alert(reg.test(title))
		if(!reg.test(title)){
			$(this).next().html('文章标题由中文数字字母下划线组成且不为空')
			return;
		}
		$.ajaxSetup({ headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
		// ajax验证唯一
		$.ajax({
			type:'post',
			url:"/article/checkOnly",
			data:{title:title},
			dataType:'json',
			success:function(res){
				// console.log(res)
				// alert(res.count);
				if(res.count>0){
					// alert(123);
					$('input[name="title"]').next().html('已存在')
				}
			}
		})
	})
	// 作者验证
	$('input[name="men"]').blur(function(){
		// console.log(2)
		$(this).next().html('');
		var men = $(this).val()
		// console.log(men)
		var reg = /^[\u4e00-\u9fa5A-Za-z0-9_]{2,8}$/
		// alert(reg.test(men))
		// console.log(reg.test(men))
		if(!reg.test(men)){
			$(this).next().html('文章作者由中文数字字母下划线组成且不为空长度为2-8位')
			return
		}
	})

</script>
