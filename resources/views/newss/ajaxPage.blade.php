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
        <td colspan="8">
        ​{{$data->appends($query)->links()}}
        </td>
        </tr>
    </tbody>