<table>
    @foreach($concepts as $concept)
        <tr>
            <td>{{$concept->id}}</td>
            <td><a href="{{route('concepts.{concept}.records.index',['concept'=>$concept->id])}}">{{$concept->name}}</a></td>
            <td>{{$concept->parent_id}}</td>
            <td>{{$concept->mustbezero}}</td>
    @endforeach
</table>