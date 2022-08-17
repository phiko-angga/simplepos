@extends('layout._template',['title' => 'Users - Program Sales'])
@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{$action}}">
                @csrf
                {{$method == 'PUT' ? method_field('PUT') : '' }}

                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input required value="{{isset($user) ? $user->name : '' }}" autofocus type="text" class="form-control" name="name" id="name" placeholder="Enter username">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input required value="{{isset($user) ? $user->email : '' }}" type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password confirmation</label>
                    <input type="password" class="form-control" name="password_confirmation" id="rpassword" placeholder="Password confirmation">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">User level</label>
                    <select class="form-control" name="level_id" id="level_id">
                      @foreach($level as $l)
                      <option 
                        @isset($user)
                          @if($user->level_id == $l->id)
                            selected="selected"
                          @endif
                        @endisset
                      value="{{$l->id}}">{{$l->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
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
</script>
@endsection