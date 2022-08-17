
@if(sizeof($user) !== 0)
    @foreach($user as $key => $row)
      <tr>
        <td>{{++$key}}</td>
        <td>{{$row->name}}</td>
        <td>{{$row->email}}</td>
        <td>{{$row->level->nama}}</td>
        <td class="text-center">
          <a style="width:40px" class="btn btn-sm btn-outline-primary" title="Edit user" href="{{url('seting/user/'.$row->id.'/edit')}}"><i class="fas fa-edit"></i></a>
          <a style="width:40px" id="delete-btn" class="btn btn-sm btn-outline-danger" href="{{url('seting/user/'.$row->id)}}" title=" Delete user"><i class="fas fa-trash"></i></a>
        </td>
      </tr>

    @endforeach
@else
  <tr>
    <td colspan="5" align="center">
        <h4 class="text-center">No Data Available</h4>
    </td>
  </tr>
@endif