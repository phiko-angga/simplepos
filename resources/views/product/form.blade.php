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
                    <label for="exampleInputEmail1">Kode</label>
                    <input required value="{{isset($barang) ? $barang->kode : '' }}" autofocus type="text" class="form-control" name="kode" id="kode" placeholder="Kode">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama barang</label>
                    <input required value="{{isset($barang) ? $barang->nama : '' }}" autofocus type="text" class="form-control" name="nama" id="nama" placeholder="Nama barang">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Deskripsi</label>
                    <input required value="{{isset($barang) ? $barang->deskripsi : '' }}" type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Harga jual</label>
                    <input required type="number" value="{{isset($barang) ? $barang->harga_beli : '' }}" class="form-control" name="harga_beli" id="harga_beli" placeholder="Harga beli">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">harga beli</label>
                    <input required type="number" value="{{isset($barang) ? $barang->harga_jual : '' }}" class="form-control" name="harga_jual" id="harga_jual" placeholder="Harga jual">
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
      let url = "{{url('seting/barang')}}?search="+$("#search-input").val();
      window.location.href = url;
  }
</script>
@endsection