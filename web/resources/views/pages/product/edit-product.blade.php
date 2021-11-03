@extends('layouts.app')
@push('custom_css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@php
  $product = $data['products'];
  $prdnames = $data['prdnames'];
  $department = $data['department'];
  $supplier = $data['supplier'];
@endphp
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <div class="col-sm-10">
            <div class="mt-2 mb-2">
                @if(session('msg'))
                  <div class="alert alert-success">{{session('msg')}}</div>
                @endif
              </div>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Product</h3>
              </div>
              <!-- /.card-header -->
              @if ($errors->any())
                  <div class="alert alert-danger mt-2">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              <!-- form start -->
              <form id="editform" action="{{route('update-product')}}" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                      <div class="col-sm-6">
                       <div class="form-group">
                        <label for="name">Product Name <span style="color:red;">*</span></label> <br>
                        <select class="js-example-basic-single form-control" name="name" id="name">
                          <option value="">Select Product Name</option>
                           @if(isset($prdnames) && count($prdnames) > 0)
                            @foreach($prdnames as $row)
                              <option  value="{{$row->pk_no}}" <?php if($row->pk_no == $product->prd_id){echo 'selected';}?>>{{$row->prd_name}}</option>
                            @endforeach    
                          @endif
                        </select>
                      </div>
                    </div>
                    <input type="hidden" name="prdid" value="{{$product->pk_no}}">
                     <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Purchase Date <span style="color:red;">*</span></label>
                        <input type="text" name="purchasedate" value="{{date('d-M-Y', strtotime($product->prd_purchase_date))}}" readonly="" class="form-control" id="purchasedate" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-6">
                             <div class="form-group">
                              <label for="brand">Product Quantity <span style="color:red;">*</span></label>
                              <input type="text" name="quantity" value="{{$product->prd_qty}}" class="form-control" id="quantity" placeholder="Enter product quantity">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="brand">Quantity In (kg,pcs,etc) <span style="color:red;">*</span></label>
                              <input readonly="" type="text" name="unit" value="{{$product->prd_unit}}" class="form-control" id="unit">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Per Quantity Price <span style="color:red;">*</span></label>
                        <input type="text" name="quantityprice" value="{{$product->prd_qty_price}}" class="form-control" id="quantityprice" placeholder="Enter product quantity price">
                        <span id="showmsg"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Total Price <span style="color:red;">*</span></label>
                        <input type="text" name="totalprice" value="{{$product->prd_price}}" class="form-control" id="totalprice" readonly="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Grand Total <span style="color:red;">*</span></label>
                        <input type="text"  name="grandtotal" value="{{$product->prd_grand_price}}" class="form-control" id="grandtotal" placeholder="Grand total">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Requisition Dept <span style="color:red;">*</span></label>
                      <select class="form-control" name="reqdept" id="reqdept">
                        <option value="">select</option>
                        @if($department->count() > 0)
                          @foreach($department as $row)
                            <option value="{{$row->dep_name}}"  <?php if($row->dep_name == $product->prd_req_dep){echo 'selected';}?>>{{$row->dep_name}}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Supplier <span style="color:red;">*</span></label>
                      <select class="form-control" name="supplier" id="supplier">
                        <option value="">select</option>
                        @if($supplier->count() > 0)
                          @foreach($supplier as $row)
                            <option value="{{$row->supplier_name}}"<?php if($row->supplier_name == $product->supplier){echo 'selected';}?> >{{$row->supplier_name}}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="expirydate">Expiry Date</label>
                        <input type="text" name="expirydate" readonly="" value="@if($product->expiry_date){date('d-M-Y', strtotime($product->expiry_date))} @endif"  class="form-control" id="expirydate" >
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="expiryalert">Expiry Alert Date</label>
                        <input type="text" readonly="" name="expiryalert" value="@if($product->date_alert){date('d-M-Y', strtotime($product->date_alert))} @endif" class="form-control" id="expiryalert" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Product Brand(Opt)</label>
                        <input type="text" name="brand" class="form-control" value="{{$product->prd_brand}}" id="brand" >
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Purchase From(Opt)</label>
                      <input type="text" name="purchasefrom" class="form-control" value="{{$product->prd_purchase_from}}" id="purchasefrom">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                    <label for="brand">Created At</label>
                    <input type="text" class="form-control" readonly="" value="{{date('d-M-y', strtotime($product->created_at))}}">
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Remarks (Opt)</label>
                      <textarea rows="5" class="form-control" name="remarks" id="remarks">{{$product->prd_details}}</textarea>
                    </div>
                  </div>
                  </div>
                 </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="editsubmit">Update Product</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('scripts')
    <script>
  $(function(){
    $(document).on('change','#name',function(){
      var nameid = $('#name').val();
      $.ajax({
          url:"{{route('get-product-unit') }}",
          type:"GET",
          data:{nameid:nameid},
          success:function(data){
              $('#unit').val(data);
          }
      });
    });
  });
//check previous price
 $(document).on('keyup','#quantityprice',function(){
      var price     = $(this).val();
      var productId = $('#name').val();
      if (productId == "") {
        alert('Product Name can not be empty !!');
      }else{
        $('#showmsg').text('Processing...');
        $.ajax({
            url:"{{route('get-product-price') }}",
            type:"GET",
            data:{prdprice:price, productId:productId},
            success:function(data){
                console.log(data);
                if (data.status == 'error') {
                  $('#showmsg').html('<span style="color:#ff0000">Previous price was -></span>'+data.price);
                }else if(data.status == 'success'){
                   $('#showmsg').html('<span style="color:#008000">Both price are same</span>');
                }else if(data.status == 'fentry'){
                   $('#showmsg').html('<span style="color:#008000">This is first entry</span>');
                }else{
                   console.log('something wrong !!');
                }
            }
        });
      }
    });
//multiplication
$(document).ready(function() {
    //this calculates values automatically 
    sum();
    $("#quantity, #quantityprice").on("keydown keyup", function() {
        sum();
    });
});

function sum() {
    var num1 = document.getElementById('quantity').value;
    var num2 = document.getElementById('quantityprice').value;
    var result = num1 * num2;
    if (!isNaN(result)) {
        document.getElementById('totalprice').value = result;
        document.getElementById('grandtotal').value = result;
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
  // In your Javascript (external .js resource or <script> tag)
  $(document).ready(function() {
      $('.js-example-basic-single').select2();
  });
</script>
<script type="text/javascript">
  $("#purchasedate").datepicker({ dateFormat: "dd-M-yy"});
  $("#expirydate").datepicker({ dateFormat: "dd-M-yy",changeYear:true, yearRange: "2021:2050"});
  $("#expiryalert").datepicker({ dateFormat: "dd-M-yy",changeYear:true, yearRange: "2021:2050"});
  $(document).ready(function () {
    $("#editform").submit(function () {
        $("#editsubmit").attr("disabled", true);
        return true;
    });
});
</script>
@endpush
