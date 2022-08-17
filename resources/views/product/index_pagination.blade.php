
@if(sizeof($barang) !== 0)
    @foreach($barang as $key => $row)
      <tr>
        <td>{{++$key}}</td>
        <td>{{$row->kode}}</td>
        <td>{{$row->nama}}</td>
        <td>{{$row->deskripsi}}</td>
        <td>{{number_format($row->harga_beli)}}</td>
        <td>{{number_format($row->harga_jual)}}</td>
        <td class="text-center">
          <a style="width:40px" class="btn btn-sm btn-outline-primary" title="Edit barang" href="{{url('seting/product/'.$row->id.'/edit')}}"><i class="fas fa-edit"></i></a>
          <a style="width:40px" id="delete-btn" class="btn btn-sm btn-outline-danger" href="{{url('seting/product/'.$row->id)}}" title=" Delete barang"><i class="fas fa-trash"></i></a>
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