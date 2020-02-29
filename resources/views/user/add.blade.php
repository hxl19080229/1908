<form action="{{url('user/adddo')}}" method="post" >
@csrf
{{$aa}}
<input type="text" name="name" id="">
<input type="text" name="age" id="">
<input type="submit" value="添加"/>
</form>