
@if(sizeof($sales) > 0)
    @foreach($sales as $key => $row)
      <tr data-widget="expandable-table" aria-expanded="false">
        <td>{{++$key}}</td>
        <td>{{date('d M Y',strtotime($row->created_at))}}</td>
        <td>{{$row->no_transaksi}}</td>
        <td class="text-right">{{number_format($row->total)}}</td>
        <td class="text-right">{{number_format($row->bayar)}}</td>
        <td class="text-right">{{number_format($row->selisih)}}</td>
        <td class="text-right">{{number_format($row->total - $row->total_beli)}}</td>
      </tr>
      <tr class="expandable-body">
        <td colspan="7">
          <table>
            <thead>
              <tr>
                <th>Product</th>
                <th class="text-right">Jumlah</th>
                <th class="text-right">Harga Jual</th>
                <th class="text-right">Sub total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($row->detail as $key2 => $pr)
              <tr>
                <td>{{$pr->nama}}</td>
                <td class="text-right">{{$pr->jumlah}}</td>
                <td class="text-right">{{number_format($pr->harga_jual)}}</td>
                <td class="text-right">{{number_format($pr->jumlah * $pr->harga_jual)}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
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