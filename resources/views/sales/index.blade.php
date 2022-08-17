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
                <a href="{{url('transaction/sales/create')}}" class="btn btn-outline-primary btn-sm">Add new</a>

                <div class="card-tools">
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
                      <th class="text-right">Selisih kembalian</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @include('sales.index_pagination')
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

    <form id="delete-form" action="{{url('transaction/sales')}}" method="post">
      @csrf
      {{method_field('DELETE')}}
    </form>
    <!-- /.content -->

@endsection

@section('script')
<script>
  $(document).on('click','#search-btn',function(){
    refreshUrl();
  })
  $(document).on('keypress','#search-input',function(e){
    if(e.which == 13) {
      refreshUrl();
    }
  })

  function refreshUrl(){
      let url = "{{url('transaction/sales')}}?search="+$("#search-input").val();
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