@extends('layouts.app')
@push('custom_css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
@endpush
@php
  $reqlist = $data['reqlist'];
@endphp

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Requisation Product List </h3>
                <button class="float-right btn btn-info" id="printOut">Print me</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="productlist" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>SL.</th>
                    <th>Product Name</th>
                    <th>Unit</th>
                    <th>Current Stock</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                  </tr>
                  </thead>
                  <tbody>
              @if(isset($reqlist) && count($reqlist) > 0)
                @foreach($reqlist as $row)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$row->prd_name}}</td>
                    <td>{{$row->prd_unit}}</td>
                    <td>{{$row->prd_qty}}</td>
                    @php $price = DB::table('prd_master')->where('prd_id', $row->pk_no)->orderBy('created_at', 'desc')->first('prd_qty_price'); @endphp
                    <td>{{$price->prd_qty_price ?? ''}}</td>
                    <td><input type="text" data-id="{{$row->pk_no}}" data-price="{{$price->prd_qty_price ?? ''}}" class="form-control getqty"></td>
                    <td data-total="" id="total{{$row->pk_no}}">0</td>
                  </tr>
              @endforeach    
                  <tr>
                    <td colspan="6" class="text-right">Grand Total</td>
                    <td colspan="1" id="grandtotal">0</td>
                  </tr>
               @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
    <div class="printarea d-none" id="printdata">
      <h2 style="text-align: center;font-size: 15px; font-weight: bold; padding: 10px;">Requisation Product List</h2>
         <table id="tblreqproductlist" style="border:1px solid #ddd;" cellpadding="3" class="table table-bordered table-striped">
                  <thead>
                  <tr style="border: 1px solid #ddd; padding: 5px;">
                    <th style="border: 1px solid #ddd; padding: 5px;">SL.</th>
                    <th style="border: 1px solid #ddd; padding: 5px;">Product Name</th>
                    <th style="border: 1px solid #ddd; padding: 5px;">Unit</th>
                    <th style="border: 1px solid #ddd; padding: 5px;">Current Stock</th>
                    <th style="border: 1px solid #ddd; padding: 5px;">Price</th>
                    <th style="border: 1px solid #ddd; padding: 5px;">Quantity</th>
                  </tr>
                  </thead>
                  <tbody>
              @if(isset($reqlist) && count($reqlist) > 0)
                @foreach($reqlist as $row)
                  <tr style="border: 1px solid #ddd; padding: 5px;">
                    <td style="border: 1px solid #ddd; padding: 5px;">{{$loop->iteration}}</td>
                    <td style="border: 1px solid #ddd; padding: 5px;">{{$row->prd_name}}</td>
                    <td style="border: 1px solid #ddd; padding: 5px;">{{$row->prd_unit}}</td>
                    <td style="border: 1px solid #ddd; padding: 5px;">{{$row->prd_qty}}</td>
                    <td style="border: 1px solid #ddd; padding: 5px;">{{$price->prd_qty_price}}</td>
                    <td style="border: 1px solid #ddd; padding: 5px;" ></td>
                  </tr>
              @endforeach    
               @endif
                  </tbody>
          </table>
    </div>
@endsection
@push('scripts')
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#tblreqproductlist').DataTable();
  } );


    function printData(){
       var divToPrint=document.getElementById("printdata");
       newWin= window.open("");
       newWin.document.write(divToPrint.outerHTML);
       newWin.print();
       newWin.close();
    }

    $('#printOut').on('click',function(){
      printData();
    })

    $('.getqty').keyup(function(e){

       var qty = $(this).val();
       var price = $(this).attr('data-price')
       var id = $(this).attr('data-id')
       var total = qty*price;
       $('#total'+id).html(total);
       $('#total'+id).attr( 'data-total',total);

       //var gtotal = $('#total'+id).attr('data-total');
       //var grandtotal = parseInt(preValue, 10) + parseInt(gtotal, 10);
      var totalPrice = 0;
      $('.getqty').each(function () {
        totalPrice += parseInt($(this).attr('data-total'), 10);
    });
       $('#grandtotal').html(totalPrice);
    });

  </script>
@endpush
