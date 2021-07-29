@extends('layouts.app')
@push('custom_css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@php
  $prdnames   = $data['productsname'];
  $department = $data['department'];
  $supplier = $data['supplier'];
@endphp
@section('content')
    <!-- Main content -->
    <section class="content pt-2">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <div class="col-sm-10">
            @if(session('msg'))
               <div class="mt-2 mb-2">
                  <div class="alert alert-success">{{session('msg')}}</div>
              </div>
              @endif
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Product Entry</h3>
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
              <form id="quickForm" action="{{route('save-product')}}" method="post">
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
                              <option value="{{$row->pk_no}}">{{$row->prd_name}}</option>
                            @endforeach    
                          @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Purchase Date <span style="color:red;">*</span></label>
                        <input type="text" name="purchasedate" placeholder="select date" readonly="" value="{{old('purchasedate')}}" class="form-control" id="purchasedate" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-6">
                             <div class="form-group">
                              <label for="brand">Product Quantity <span style="color:red;">*</span></label>
                              <input type="text"  name="quantity" value="{{old('quantity')}}" class="form-control" id="quantity" placeholder="Enter product quantity">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="brand">Quantity In (kg,pcs,etc) <span style="color:red;">*</span></label>
                              <input readonly="" type="text" name="unit" value="{{old('unit')}}" class="form-control" id="unit">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Per Quantity Price <span style="color:red;">*</span></label>
                        <input type="text"  name="quantityprice" value="{{old('quantityprice')}}" class="form-control quantityprice" id="quantityprice" placeholder="Enter product quantity price">
                        <span id="showmsg"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Total Price <span style="color:red;">*</span></label>
                        <input type="number" min="1" name="totalprice" value="{{old('totalprice')}}" class="form-control" id="totalprice" readonly="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Grand Total <span style="color:red;">*</span></label>
                        <input type="number" min="1" name="grandtotal" value="{{old('grandtotal')}}" class="form-control" id="grandtotal" placeholder="Grand total">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Requisition Dept. <span style="color:red;">*</span></label>
                      <select class="form-control" name="reqdept" id="reqdept">
                        <option value="">select</option>
                        @if($department->count() > 0)
                          @foreach($department as $row)
                            <option value="{{$row->dep_name}}">{{$row->dep_name}}</option>
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
                            <option value="{{$row->supplier_name}}">{{$row->supplier_name}}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Product Brand(Opt)</label>
                        <input type="text" name="brand" class="form-control" value="{{old('brand')}}" id="brand" placeholder="Enter product brand">
                      </div>
                    </div>
                   <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Purchase From(Opt)</label>
                      <input type="text" name="purchasefrom" class="form-control" value="{{old('purchasefrom')}}" id="purchasefrom" placeholder="Purchase from">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Remarks (Opt)</label>
                      <textarea rows="5" placeholder="Product remarks" class="form-control" name="remarks" id="remarks">{{old('remarks')}}</textarea>
                    </div>
                  </div>
                  <div class="col-sm-6"></div>
                  </div>
                 </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save Product</button>
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
</script>
@endpush
