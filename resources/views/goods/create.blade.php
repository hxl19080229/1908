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
 <center><h3>商品添加</h3></center>  
 @if($errors->any()) 
 <div class="alert alert-danger">
 <ul>
 @foreach($errors->all() as $error)
<li>{{$error}}</li> 
@endforeach
 </ul>
 </div>
 @endif
<form class="form-horizontal" role="form" action="{{url('goods/store')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品名称</label>
		<div class="col-sm-8">
			<input type="text" class="form-control goods_name" name="goods_name" id="firstname" 
				   placeholder="请输入商品名字">
			<b style="color:red">{{$errors->first('goods_name')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品价格</label>
		<div class="col-sm-8">
			<input type="text" class="form-control goods_price" name="goods_price" id="firstname" 
				   placeholder="请输入商品价格">
			<b style="color:red">{{$errors->first('goods_price')}}</b>
		</div>
	</div>
    
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品库存</label>
		<div class="col-sm-8">
			<input type="text" class="form-control goods_num" name="goods_num" id="firstname" 
				   placeholder="请输入商品库存">
				<b style="color:red">{{$errors->first('goods_num')}}</b>
		</div>
	</div>
	
	<!-- <div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品货号</label>
		<div class="col-sm-8">
			<input type="text" class="form-control goods_huohao" name="goods_huohao" id="firstname" 
				   placeholder="请输入商品货号">
				   <b style="color:red">{{$errors->first('goods_huohao')}}</b>
		</div>
	</div> -->
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">赠送积分</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="goods_score" id="firstname" 
				   placeholder="请输入赠送积分">
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品详情</label>
		<div class="col-sm-8">
			<textarea name="goods_desc" id="" cols="30" rows="10"></textarea>
			
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品缩略图</label>
		<div class="col-sm-8">
			<input type="file" class="form-control" name="goods_img" id="firstname">
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品相册</label>
		<div class="col-sm-8">
			<input type="file" class="form-control" name="goods_imgs[]" multiple="multiple" id="firstname">
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否新品</label>
		<label class="radio-inline">
        <input type="radio" name="is_new" id="optionsRadios3" value="1" checked> 是
   		</label>
		<label class="radio-inline">
		<input type="radio" name="is_new" id="optionsRadios3" value="2" > 否
   		</label>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否精品</label>
		<label class="radio-inline">
        <input type="radio" name="is_best" id="optionsRadios3" value="1" checked> 是
   		</label>
		<label class="radio-inline">
		<input type="radio" name="is_best" id="optionsRadios3" value="2" > 否
   		</label>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否热卖</label>
		<label class="radio-inline">
        <input type="radio" name="is_hot" id="optionsRadios3" value="1" checked> 是
   		</label>
		<label class="radio-inline">
		<input type="radio" name="hot" id="optionsRadios3" value="2" > 否
   		</label>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否上架</label>
		<label class="radio-inline">
        <input type="radio" name="is_up" id="optionsRadios3" value="1" checked> 是
   		</label>
		<label class="radio-inline">
		<input type="radio" name="is_up" id="optionsRadios3" value="2" >否
   		</label>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品品牌</label>
		<div class="col-sm-8">
			<select name="b_id" id="">
				<option value="">--请选择--</option>
				@foreach($brand as $v)
				<option value="{{$v->b_id}}">{{$v->b_name}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品分类</label>
		<div class="col-sm-8">
			<select name="c_id" id="">
				<option value="">--请选择--</option>
				@foreach($cate as $v)
					<option value="{{$v->c_id}}">
						{!! str_repeat('&nbsp;&nbsp;',$v->level*3)!!}
						{{$v->cate_name}}
					</option>
				@endforeach
			</select>
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
		$('.goods_name').next().html('')
		$('.goods_price').next().html('')
		$('.goods_num').next().html('')
		// $('.goods_huohao').next().html('')
		// console.log(goods_name)
		// console.log(goods_price)
		// console.log(goods_num)
		// console.log(goods_huohao)
		// 验证
		var goods_name = $('.goods_name').val()
		var goods_price = $('.goods_price').val()
		var goods_num = $('.goods_num').val()
		// var goods_huohao = $('.goods_huohao').val()
		// console.log(goods_name)
		// console.log(goods_price)
		// console.log(goods_num)
		// console.log(goods_huohao)
		var reg = /^[\u4e00-\u9fa5A-Za-z0-9_]{2,20}$/
		// console.log(reg.test(goods_name))
		if(!reg.test(goods_name)){
			$('.goods_name').next().html('商品名称由中文、数字、字母、下划线2-20位组成且不为空')
		}
		var regs = /^[0-9]+$/
		// console.log(regs.test(goods_price))
		// console.log(regs.test(goods_num))
		if(!regs.test(goods_price)){
			$('.goods_price').next().html('商品价格必须为数字且不为空')
		}
		if(!regs.test(goods_price)){
			$('.goods_num').next().html('商品库存必须为数字且不为空')
		}
		// if(!goods_huohao){
		// 	$('.goods_huohao').next().html('商品货号必填')
		// }
		// form 提交
		$('form').submit()
	})
	// 失去焦点 商品名称
	$(document).on("blur",'.goods_name',function(){
		// console.log(312)
		$('.goods_name').next().html('')
		var goods_name = $(this).val()
		// console.log(goods_name)
		var reg = /^[\u4e00-\u9fa5A-Za-z0-9_]{2,20}$/
		// console.log(reg.test(goods_name))
		if(!reg.test(goods_name)){
			$('.goods_name').next().html('商品名称由中文、数字、字母、下划线2-20位组成且不为空')
		}
	})
	// 失去焦点 商品价格
	$(document).on("blur",'.goods_price',function(){
		// console.log(312)
		$('.goods_price').next().html('')
		var goods_price = $(this).val()
		// console.log(goods_name)
		var reg = /^[0-9]+$/
		// console.log(reg.test(goods_name))
		if(!reg.test(goods_price)){
			$('.goods_price').next().html('商品价格必须为数字且不为空')
		}
	})
	// 失去焦点 商品库存
	$(document).on("blur",'.goods_num',function(){
		// console.log(312)
		$('.goods_num').next().html('')
		var goods_num = $(this).val()
		// console.log(goods_name)
		var reg = /^[0-9]+$/
		// console.log(reg.test(goods_name))
		if(!reg.test(goods_num)){
			$('.goods_num').next().html('商品库存必须为数字且不为空')
		}
	})
	// 失去焦点 商品货号
	// $(document).on("blur",'.goods_huohao',function(){
	// 	// console.log(312)
	// 	$('.goods_huohao').next().html('')
	// 	var goods_huohao = $(this).val()
	// 	if(!goods_huohao){
	// 		$('.goods_huohao').next().html('商品货号必填')
	// 	}
	// })
	
	
</script>
