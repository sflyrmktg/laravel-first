<table>
    @foreach($methods as $method)
        <tr>
            <td>{{$method->id}}</td>
            <td><a href="{{url()->current().'/'.$method->id.'/records'}}">{{$method->name}}</a></td>
            <td>{{$method->mustbezero}}</td>
        </tr>
    @endforeach
</table>