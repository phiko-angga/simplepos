@extends('layout._template',['title' => 'Users - Program Sales'])
@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">

                <div class="card-tools d-flex">
                  <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" class="form-control float-right" id="date_range" value="{{isset($date_range) ? $date_range : ''}}">
                  </div>

                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input autofocus type="text" value="{{$search}}" name="table_search" id="search-input" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="button" id="search-btn" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Tanggal</th>
                      <th>Kode transaksi </th>
                      <th class="text-right">Total</th>
                      <th class="text-right">Terbayar</th>
                      <th class="text-right">Kembalian</th>
                      <th class="text-right">Laba</th>
                    </tr>
                  </thead>
                  <tbody>
                    @include('sales.report_pagination')
                  </tbody>
                </table>
              </div>
              <!-- /.card-body --> 
              <div class="card-footer clearfix">
                @if($sales->hasPages())
                  {!! $sales->withQueryString()->links() !!}
                @endif
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@section('script')
<script>
  $('#date_range').daterangepicker()
  $(document).ready(function(){
  })

  $(document).on('change','#date_range',function(){
    refreshUrl();
  })

  $(document).on('click','#search-btn',function(){
    refreshUrl();
  })

  $(document).on('keypress','#search-input',function(e){
    if(e.which == 13) {
      refreshUrl();
    }
  })

  function refreshUrl(){
      let dates = $("#date_range").val().split(' - ');

      let search = "search="+$("#search-input").val();
      let dateS = "date_start="+dates[0];
      let dateF = "date_end="+dates[1];
      let url = "{{url('transaction/report/sales-by-date')}}?"+search+"&"+dateS+"&"+dateF;
      window.location.href = url;
  }

  $(document).on('click','#delete-btn',function(e){
    e.preventDefault();
    if (confirm('Are you sure delete this record ?')) {
        $("#delete-form").prop('action',$(this).attr('href'));
        $("#delete-form").submit();
    }
  })
</script>
@endsection