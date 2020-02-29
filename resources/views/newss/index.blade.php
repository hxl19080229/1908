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
​<center><h2 class="danger">文章</h2></center>
<form action="">
    <input type="text" name="title" value="{{$query['title']??''}}" placeholder="请输入标题">
    <select name="c_id" id="">
		<option value="">--请选择--</option>
        @php $c_id=$query['c_id']??'';@endphp
        @foreach($cate as $v)	
		<option value="{{$v->c_id}}" @if($v->c_id==$c_id) selected="selected" @endif>
            {{$v->c_name}}
        </option>
        @endforeach
	</select>
    <button type="submit" class="btn btn-default btn-danger">搜索</button>
</form>
<table class="table">
    
    <thead>
        <tr  class="warning">
            <th>ID</th>
            <th>文章标题</th>
            <th>文章分类</th>
            <th>文章重要性</th>
            <th>是否显示</th>
            <th>上传文件</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
    </thead>
    <!-- class="danger" class="success"-->
    <tbody>
        @foreach($data as $k=>$v)
        <tr @if($k%2==0)class="success" @else class="danger" @endif>
            <td>{{$v->a_id}}</td>
            <td>{{$v->title}}</td>
            <td>{{$v->c_name}}</td>
            <td>{{$v->zyx}}</td>
            <td>{{$v->is_show=='1'?'√':'×'}}</td>
            <td>
            <img src="{{env('UPLOAD_URL')}}{{$v->img}}" alt="" whid="100" height="100">
            </td>
            <td>{{date('Y-m-d h:i:s')}}</td>
            <td>
            <a href="{{url('article/edit/'.$v->a_id)}}" class="btn btn-info">编辑</a>||
            <a href="javascript:void(0)" onclick="del({{$v->a_id}})" class="btn btn-danger">删除</a>
            </td>
        </tr>
        @endforeach
        <tr>
        <td rowspan="8">
        {{$data->appends($query)->links()}}
        
        </td>
        </tr>
    </tbody>
</table>

</body>
</html>
<script>
    // ajax分页
    // $('.pagination a').click(function(){
    $(document).on('click','.pagination a',function(){
        // alert(111)
        var url = $(this).attr('href')
        // alert(url)
        if(!url){
            return
        }

        $.get(url,function(res){
            // alert(res)
            $('tbody').html(res)
        })
        return false

    })
    function del(id){
        if(!id){
            return; 
        }
        if(confirm('是否要删除此条记录')){
            // ajax删除
            $.get('/article/destroy/'+id,function(res){
                if(res.code=='00000'){
                   // alert(111)
                   //reload 要结合ajax分页 删除才会自动刷新页面
                   // location.reload();
                    location.href="/article";
                }
            },  
            'json'
            )
        }





    }



</script>

 
