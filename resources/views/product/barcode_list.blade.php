<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Print Product Barcode
  </title>
  <style>
    body{
      background: #dee2e6;
    }

    .content-wrapper {
        background: #ffffff;
        margin-top: 10px
    }

    .form-group {
      margin-bottom: 1rem;
    }
    select.form-control {
      color: #495057!important;
    }
    .table th, .table td {
      padding: 0.25rem 0.25rem;
    }
    .mdi{
      font-size: 18px;
    }

    .table{
      border: 2px solid black;
    }

    .table thead th {
        border: 2px solid black;
    }

    .table tbody td, .table tfoot td {
        border: 1px dashed black;
    }
    
    #item-search tr:focus {
      background-color: var(--gray-lightest);
      outline: 0; /*remove outline*/
    }
    
  </style>

</head>
<body>

  <div class="container-scroller p-4">
  
    <div class="row d-print-none">
        <div class="col-12">
            <h3><strong>Print Product Barcode</strong></h3>
        </div>
    </div>

    <div class="content-wrapper d-print-block p-3" style="padding:12px">
        <?php $key = 0;$jenis = "";$jenisBaru = true;?>
            @foreach($product as $list)

                  @if(strlen($list->kode) <= 30)
                    <div class="col-md-3 text-center">
                        <div class="m-2">
                          {!! DNS1D::getBarcodeHTML($list->kode, 'C128',1.25,25,'black',false) !!}
                          <p class="text-left" style="margin-top:5px">{{$list->kode}}</p>
                        </div>
                        <!-- <img src="data:image/png,{{DNS1D::getBarcodePNG($list->kode, 'C128')}}" alt="barcode"   /> -->
                    </div>
                  @else
                      <div class="col-md-6 text-center">
                          <div class="m-2">{!! DNS1D::getBarcodeHTML($list->kode, 'C128',1,25,'black',true) !!}</div>
                          <!-- <img src="data:image/png,{{DNS1D::getBarcodePNG($list->kode, 'C128')}}" alt="barcode"   /> -->
                      </div>
                  @endif

            @endforeach
    </div>

    <div class="row d-print-none mt-4">
        <div class="col-12">
            <button type="button" id="btn_print" class="btn btn-primary">Print</button>
            <button type="button" id="tab_close" class="btn btn-secondary">Close</button>
        </div>
    </div>
      <!-- main-panel ends -->
      
  </div>
  <!-- container-scroller -->
  <script>
    document.getElementById("btn_print").addEventListener("click", barcodePrint);
    function barcodePrint(){
      window.print();
    }
  </script>
  
  <!-- End custom js for this page-->
</body>

</html>

