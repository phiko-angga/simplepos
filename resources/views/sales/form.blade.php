@extends('layout._template',['title' => 'Users - Program Sales'])
@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <input type="hidden" id="load_data" value="@isset($penjualan){{$penjualan}}@endisset">
        <form method="POST" action="{{$action}}">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-7">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                @csrf
                {{$method == 'PUT' ? method_field('PUT') : '' }}

                <div class="card-body" id="item-panel" style="overflow-y:scroll;min-height:300px">

                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Barang</th>
                        <th class="text-right">Jumlah</th>
                        <th class="text-right">Harga jual</th>
                        <th class="text-right">Sub total</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody id="item">
                      
                    </tbody>
                  </table>
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input autofocus type="text" name="productsearch" id="search-input" class="form-control float-right" placeholder="Search product...">

                    <div class="input-group-append">
                      <button type="button" id="search-btn" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
            </div>
            <!-- /.card -->

          </div>

          
          <div class="col-md-5">
          <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">SUMMARY</h3>
                <div class="card-tools">
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <p class="text-success text-xl">
                    <!-- <i class="ion ion-ios-refresh-empty"></i> -->
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                    TOTAL
                    </span>
                    <span class="text-muted" id="label_grandtotal" style="font-size:32px">0</span>
                    <input type="hidden" name="total" id="grandtotal">
                  </p>
                </div>
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <p class="text-warning text-xl">
                    <!-- <i class="ion ion-ios-cart-outline"></i> -->
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      PEMBAYARAN
                    </span>
                    <input type="text" onChange="payment_change(this.value)" name="bayar" id="bayar" class="text-right text-muted form-control" style="font-size:32px">
                  </p>
                </div>
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center mb-0">
                  <p class="text-danger text-xl">
                    <!-- <i class="ion ion-ios-people-outline"></i> -->
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      SELISIH KEMBALIAN
                    </span>
                    <span id="sisa" style="font-size:32px" class="text-muted">0</span>
                  </p>
                </div>
                <button type="submit" style="width:200px" class="mx-auto btn btn-block bg-gradient-primary">Submit</button>
                <!-- /.d-flex -->
              </div>
            </div>
          </div>

        </div>
        <!-- /.row (main row) -->
        </form>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    
    <div class="modal fade" id="productModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Choose product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-hover" id="mytable">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th style="width:20%">product</th>
                            <th style="width:15%">Deskripsi</th>
                            <th style="width:15%">Harga jual</th>
                        </tr>
                    </thead>
                    <tbody id="item-search">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection

@section('script')
<script>
  var inc = 0;
  var load_data = $('#load_data').val() != '' ? JSON.parse($('#load_data').val()) : '';

  $(document).ready(function(){
    $("#barang").select2();
    inc = 0;

    if(load_data !== ''){
      var form = '';
      $.each(load_data.detail, function( key, value ) {
        ++inc;
        var data = {
          id_inc  : inc,
          id      : value.barang_id,
          nama    : value.nama,
          jumlah      : value.jumlah,
          harga_jual  : value.harga_jual,
        }
        
        form = template_add_product(data);
        if(form !== ''){
          $('#item').append(form);
        }
        sub_total(inc);
      });
    }
  })
  
  //Initialize Select2 Elements
  $('#barang').select2({
    theme: 'bootstrap4'
  })

  
  $("#search-input").keydown(function(event){
    if (event.ctrlKey && event.keyCode == 13) {
    }else 
    if(event.keyCode == 13){
      
      event.preventDefault();
      $.ajax({
        url:"{{url('transaction/sales/search-product')}}"+'/'+$(this).val(),
        type:"get",
        success:function(result){
            console.log(result);
            if(result.data.length == 1){
              addProduct(result.data[0]);
            }else if(result.data.length > 1){
              choose_product(result.data);
              $('#productModal').modal('show');
              setTimeout(() => {
                $('#item-search').find('tr[tabindex="0"]').focus();
              }, 200); 
            }else{
              alert('Product not found!');
              $("#search-input").select();
            }
        }
      });
    }
  });

  function choose_product(data){
    var temp = '';
    $.each(data, function(k, r){
      var product = JSON.stringify(r);

      temp +='<tr tabindex="'+k+'" class="tr_item_search data-id="'+r.id+'" data-barang=\''+JSON.stringify(r)+'\' id="record_'+r.id+'">'+
                '<td>'+(k+1)+'</td>'+
                '<td>'+
                r.nama+
                '</td>'+
                '<td>'+
                (r.deskripsi != null ? r.deskripsi : '')+
                '<td>'+
                addCommas(r.harga_jual)+
                '</td>'+
              '</tr>';
    })

    $('#item-search').empty();
    $('#item-search').append(temp);
  }
  
  $('#item-search').on('keydown','tr', function(event){
    if(event.keyCode == 13) {
          $(this).trigger('click');
    }
  })
  
  $(document).on('click','.tr_item_search', function(event){
      $('#productModal').modal('hide');
      var product = $(this).data('barang');
      addProduct(product);
  })

  function addProduct(data){
    ++inc;
    let tiD = inc;
    var newData = {
      id_inc      : inc,
      id          : data.id,
      nama        : data.nama,
      jumlah      : 1,
      harga_beli  : data.harga_beli,
      harga_jual  : data.harga_jual,
    }

    var item = $('#item').children();
    var adaItem = false;
    if(item.length > 0){
      item.each(function(index, tr){
        if(newData.id == $(this).data('product') ){
          adaItem = true;
          var recJumlah = $('#jumlah_'+$(this).data('id'));
          recJumlah.val(parseInt(recJumlah.val())+parseInt(1));
        }
      });
    }
          
    if(!adaItem){  
      form = template_add_product(newData);
      $('#item').append(form);
    } 

    //check min jumlah
    qtyChange(tiD);
    sub_total(tiD);
    grandtotal();

    setTimeout(() => {
      $("#item-panel").animate({ scrollTop: $('#item-panel').prop("scrollHeight")}, 1000);
      $('#jumlah_'+tiD).select();
    }, 300);
  }
  
  function template_add_product(data){
    var temp ='<tr data-product="'+data.id+'" data-id="'+data.id_inc+'" id="record_'+data.id_inc+'">'+
                '<td>'+(data.id_inc)+'</td>'+
                '<td>'+
                  '<input type="hidden" name="product[]" value="'+data.id+'" id="barang_'+data.id_inc+'"/>'+
                  data.nama+
                '</td>'+
                '<td>'+
                  '<input type="number" min="1" class="form-control form-control-sm text-right" name="jumlah[]" value="'+data.jumlah+'" data-old_jumlah="'+data.jumlah+'" id="jumlah_'+data.id_inc+'" onChange="qtyChange('+data.id_inc+')" placeholder="Qty" /></td>'+
                '<td class="text-right">'+
                  '<span id="label_hargajual_'+data.id_inc+'">'+addCommas(data.harga_jual)+'</span>'+
                  '<input type="hidden" name="harga_jual[]" value="'+data.harga_jual+'" id="harga_jual_'+data.id_inc+'" /></td>'+
                '<td class="text-right">'+
                  '<input type="hidden" id="subtotal_'+data.id_inc+'" name="subtotal[]">'+
                  '<span class="h6" id="label_subtotal_'+data.id_inc+'"></span></td>'+
                '<td>'+
                  '<a style="font-size:24px;color:red" href="JavaScript:void(0);" data-id="'+data.id_inc+'" class="item-remove"><i class="mdi mdi-table-row-remove"></i></a>'+
                '</td>'+
              '</tr>';

            return temp;
  }
  
  $("#bayar").keyup(function(event){
    if(event.keyCode == 13){
      // $('#submit').focus();
      $('#submit').trigger('click');
    }else{
      payment_change($(this).val());
    }
  });

  function payment_change(bayar){
    var bayar = parseFloat(bayar.replace(/\,/g, ''));
    var kembalian = (bayar) - $('#grandtotal').val();

    $('#sisa').html(addCommas(kembalian));
  }

  function qtyChange(id){
    sub_total(id);
  }
  
  function sub_total(id){
    var hrgjual = $('#harga_jual_'+id).val().replace(/\,/g, '');
    var sub  = $('#jumlah_'+id).val()*(hrgjual);

    $('#label_subtotal_'+id).text(addCommas(sub));
    $('#subtotal_'+id).val(sub);

    grandtotal();
  }
  
  function grandtotal(){
    var total = 0;var grandtotal = 0;

    $('input[name^="subtotal"]').each(function() {
      var subtotal = parseFloat($(this).val());
      total = total + (isNaN(subtotal) ? 0 : subtotal);
    });

    grandtotal  = Math.round(total);

    $('#label_grandtotal').text(addCommas(grandtotal));  
    $('#grandtotal').val(grandtotal);  
  }
  
  function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

</script>
@endsection