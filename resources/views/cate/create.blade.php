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
 <center><h3>分类添加</h3></center>  
<!-- enctype="multipart/form-data"
	<b style="color:red">{{$errors->first('title')}}</b>

  -->
  @if($errors->any)
<div class="alert alert-danger">
<ul>
@foreach($errors->all() as $error)
<li>
{{$error}}
</li>
@endforeach
</ul>
</div>
@endif
<form class="form-horizontal" role="form" action="{{url('/cate/store')}}" method="post">
@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">分类名称</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="cate_name" id="cate" 
				   placeholder="请输入名字">
			<b style="color:red">{{$errors->first('cate_name')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">父级分类</label>
		<div class="col-sm-8">
			<select name="pid" id="" class="form-control">
				<option value="0">顶级分类</option>
				@foreach($res as $k=>$v)
					<option value="{{$v->c_id}}">
						{!! str_repeat('&nbsp;&nbsp;',$v->level*3)!!}
						{{$v->cate_name}}
					</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品描述</label>
		<div class="col-sm-8">
			<textarea name="desc" id="" cols="30" rows="10"></textarea>
			
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
    // ajax 表单令牌
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    // js验证
    $('#cate').blur(function(){
        // console.log(2)
        $(this).next().html('')
        var cate_name = $(this).val()
        var reg = /^[\u4e00-\u9fa5A-Za-z0-9_]{2,16}$/
        // console.log(reg.test(cate_name))
        if(!reg.test(cate_name)){
            $(this).next().html('分类名称由中文、数字、字母、下划线2-16位组成且不为空')
            return
        }
        // ajax验证唯一
        $.ajax({
            type:'post',
            url:"/cate/checkOnly",
            data:{cate_name:cate_name},
            dataType:'json',
            success:function(res){
                if(res.count>0){
                    $('#cate').next().html('分类名称已存在')
                }
            }

        })
        
    })
    $('#btn').click(function(){
		// alert(543)
		var titleflag = true;
		$('#cate').next().html('')
		// 验证标题
		var cate_name = $('#cate').val()
		// alert(title)
		var reg = /^[\u4e00-\u9fa5A-Za-z0-9_]+$/
		// alert(reg.test(title))
		if(!reg.test(cate_name)){
			$('#cate').next().html('分类名称由中文、数字、字母、下划线2-16位组成且不为空')
			return;
		}
		$.ajax({
			type:'post',
			url:"/cate/checkOnly",
			data:{cate_name:cate_name},
			 async:false,
			dataType:'json',
			success:function(res){
			// alert(res);
				if(res.count>0){
					$('#cate').next().html('分类名称已存在')
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






</script>