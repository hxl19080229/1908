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
<form class="form-horizontal" role="form" action="{{url('article/update/'.$arr->a_id)}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">文章标题</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="title" name="title" value="{{$arr->title}}" id="firstname" 
				   placeholder="请输入名字">
			<b style="color:red">{{$errors->first('title')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">文章分类</label>
		<div class="col-sm-8">
            <select name="cate" id="">
                <option value="">--请选择--</option>
                <option value="头条" {{$arr->cate=='头条'?'selected':''}}>头条</option>
                <option value="手机快讯" {{$arr->cate=='手机快讯'?'selected':''}}>手机快讯</option>
                <option value="3G资讯" {{$arr->cate=='3G资讯'?'selected':''}}>3G资讯</option>
            </select>
		</div>
	</div>
    <div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">文章重要性</label>
		<label class="radio-inline">
        <input type="radio" name="zyx" id="optionsRadios3" value="普通" {{$arr->zyx=='普通'?'checked':''}}> 普通
   		</label>
		<label class="radio-inline">
		<input type="radio" name="zyx" id="optionsRadios3" value="置顶" {{$arr->zyx=='置顶'?'checked':''}}> 置顶
   		</label>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否显示</label>
		<label class="radio-inline">
        <input type="radio" name="is_show" id="optionsRadios3" value="1" {{$arr->is_show=='1'?'checked':''}}> 显示
   		</label>
		<label class="radio-inline">
		<input type="radio" name="is_show" id="optionsRadios3" value="2" {{$arr->is_show=='2'?'checked':''}}> 不显示
   		</label>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">文章作者</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="men" name="men" value="{{$arr->men}}" id="firstname" 
				   placeholder="请输入名字">
			
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">作者email</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="email" value="{{$arr->email}}" id="firstname" 
				   placeholder="请输入名字">
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">关键字</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="gjz" value="{{$arr->gjz}}" id="firstname" 
				   placeholder="请输入名字">
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">网页描述</label>
		<div class="col-sm-8">
			<textarea name="desc" id="" cols="30" rows="10">{{$arr->desc}}</textarea>
			
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">上传文件</label>
		<div class="col-sm-8">
			<input type="file" class="form-control" name="img" id="firstname">
            <img src="{{env('UPLOAD_URL')}}{{$arr->img}}" alt="" whid="100" height="100">
		</div>
	</div>
	
	
	
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="button" class="btn btn-default btn-danger">修改</button>

		</div>
	</div>
</form>

</body>
</html>
<script>

	// ajax提交令牌
	$.ajaxSetup({ headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
	// 获取id 全局变量
	var a_id = {{$arr->a_id}}
	// 点击事件
	$('.btn').click(function(){
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
			data:{title:title,a_id:a_id},
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
		// 验证考验
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
	$('#title').blur(function(){
		// alert(321)
		$(this).next().html('')
		var title = $(this).val()
		var reg = /^[\u4e00-\u9fa5A-Za-z0-9_]+$/
		// alert(reg.test(title))
		if(!reg.test(title)){
			$(this).next().html('文章标题由中文数字字母下划线组成且不为空')
		}
		// alert(a_id)
		// ajax验证唯一性
		$.ajax({
			type:"post",
			url:"/article/checkOnly",
			data:{title:title,a_id:a_id},
			dataType:'json',
			success:function(res){
				// alert(res)
				// console.log(res)
				if(res.count>0){
					$('#title').next().html('已存在')
				
				}
			}
		})
	})

</script>
