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
                <a href="{{url('seting/user/create')}}" class="btn btn-outline-primary btn-sm">Add new</a>

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
                      <th>Name</th>
                      <th>Email</th>
                      <th>Level</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @include('user.index_pagination')
                  </tbody>
                </table>
              </div>
              <!-- /.card-body --> 
              <div class="card-footer clearfix">
                @if($user->hasPages())
                  {!! $user->withQueryString()->links() !!}
                @endif
                <!-- <ul class="pagination pagination-sm m-0 float-right"> -->
                  <!-- <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li> -->
                <!-- </ul> -->
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>

    <form id="delete-form" action="{{url('seting/user')}}" method="post">
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
      let url = "{{url('seting/user')}}?search="+$("#search-input").val();
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