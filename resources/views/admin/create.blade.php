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
 <center><h3>管理员添加</h3></center>  
 @if($errors->any()) 
 <div class="alert alert-danger">
 <ul>
 @foreach($errors->all() as $error)
<li>{{$error}}</li> 
@endforeach
 </ul>
 </div>
 @endif
<form class="form-horizontal" role="form" action="{{url('admin/store')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">管理员账号</label>
		<div class="col-sm-8">
			<input type="text" class="form-control account" name="account" id="firstname" 
				   placeholder="请输入名字">
			<b style="color:red">{{$errors->first('account')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">密码</label>
		<div class="col-sm-8">
			<input type="password" class="form-control pwd" name="pwd" id="firstname" 
				   placeholder="请输入名字">
				<b style="color:red">{{$errors->first('pwd')}}</b>
		</div>
	</div>
	<!-- <div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">确认密码</label>
		<div class="col-sm-8">
			<input type="password" class="form-control pwd1" name="pwd1" id="firstname" 
				   placeholder="请输入名字">
		</div>
	</div> -->
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">手机号</label>
		<div class="col-sm-8">
			<input type="text" class="form-control phone" name="phone" id="firstname" 
				   placeholder="请输入名字">
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">管理员email</label>
		<div class="col-sm-8">
			<input type="email" class="form-control email" name="email" id="firstname" 
				   placeholder="请输入名字">
		</div>
	</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">管理员头像</label>
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
	// ajax表单令牌
	$.ajaxSetup({ headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
	// 验证 点击事件
	$(document).on("click",'#btn',function(){
		// alert(111)
		var titleflag = true;
		$('.account').next().html('')
		$('.pwd').next().html('')
		// $('.phone').next().html('')
		// $('.email').next().html('')
		
		// 验证
		var account = $('.account').val()
		var pwd = $('.pwd').val()
		// var phone = $('.phone').val()
		// var email = $('.email').val()
		// console.log(account)
		// console.log(pwd)
		// console.log(phone)
		// console.log(email)
		var reg = /^[\u4e00-\u9fa5A-Za-z0-9_]{2,20}$/
		// console.log(reg.test(account))
		if(!reg.test(account)){
			$('.account').next().html('账号由中文、数字、字母、下划线2-20位组成且不为空')
			
		}
		// var regs = /^{6,18}$/
		// if(!reg.test(pwd)){
		// 	$('.pwd').next().html('密码由6-18位组成且不为空')
		// }
		if(!pwd){
			$('.pwd').next().html('密码必填')
			return
		}
	
		$.ajax({
			type:'post',
			url:"/admin/checkOnly",
			data:{account:account},
			 async:false,
			dataType:'json',
			success:function(res){
			// alert(res);
				if(res.count>0){
					$('.account').next().html('账号已存在')
					titleflag = false;
				}
			}
		})
		if(!titleflag){
			return
		}
		 // form 提交
		$('form').submit()
	})
	// // 失去焦点 商品名称
	// $(document).on("blur",'.goods_name',function(){
	// 	// console.log(312)
	// 	$('.goods_name').next().html('')
	// 	var goods_name = $(this).val()
	// 	// console.log(goods_name)
	// 	var reg = /^[\u4e00-\u9fa5A-Za-z0-9_]{2,20}$/
	// 	// console.log(reg.test(goods_name))
	// 	if(!reg.test(goods_name)){
	// 		$('.goods_name').next().html('商品名称由中文、数字、字母、下划线2-20位组成且不为空')
	// 	}
	// })
	// // 失去焦点 商品价格
	// $(document).on("blur",'.goods_price',function(){
	// 	// console.log(312)
	// 	$('.goods_price').next().html('')
	// 	var goods_price = $(this).val()
	// 	// console.log(goods_name)
	// 	var reg = /^[0-9]+$/
	// 	// console.log(reg.test(goods_name))
	// 	if(!reg.test(goods_price)){
	// 		$('.goods_price').next().html('商品价格必须为数字且不为空')
	// 	}
	// })

</script>
