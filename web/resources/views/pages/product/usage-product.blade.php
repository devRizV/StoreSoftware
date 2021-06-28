@extends('layouts.app')
@push('custom_css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@php
  $prdnames = $data['productsname'];
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
                <h3 class="card-title">Usage Product</h3>
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
              <form id="quickForm" action="{{route('save-storage-product')}}" method="post">
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
                        <label for="brand">Taken by <span style="color:red;">*</span></label>
                        <input type="text" name="takenby" class="form-control" value="{{old('takenby')}}" id="takenby" placeholder="Enter taken by name">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="name">Taken Date <span style="color:red;">*</span></label> <br>
                        <input type="text" name="takendate" readonly="" value="{{old('takendate')}}" placeholder="Taken date" class="form-control" id="takendate" >
                      </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                          <div class="col-6">
                             <div class="form-group">
                              <label for="brand">Product Quantity <span style="color:red;">*</span></label>
                              <input type="number" min="1" name="quantity" value="{{old('quantity')}}" class="form-control" id="quantity" placeholder="Enter product quantity">
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
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Per Quantity Price <span style="color:red;">*</span></label>
                        <input type="number" min="1" name="quantityprice" value="{{old('quantityprice')}}" class="form-control" id="quantityprice" placeholder="Enter product quantity price">
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Total Price <span style="color:red;">*</span></label>
                        <input type="number" min="1" name="totalprice" value="{{old('totalprice')}}" class="form-control" id="totalprice" readonly="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Grand Total <span style="color:red;">*</span></label>
                        <input type="number" min="1" name="grandtotal" value="{{old('grandtotal')}}" class="form-control" id="grandtotal" placeholder="Grand total">
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Product Brand(Opt)</label>
                        <input type="text" name="brand" class="form-control" value="{{old('brand')}}" id="brand" placeholder="Enter product brand">
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
                  </div>
                 </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="saveprd">Save Product</button>
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
$(function () {
  $('#quickForm').validate({
    rules: {
      name: {
        required: true,
        name: true,
      },
      quantity: {
        required: true,
        quantity: true,
      },
      unit: {
        required: true,
      },
      quantityprice: {
        required: true,
        quantityprice: true,
      },
      grandtotal: {
        required: true,
        grandtotal: true,
      },
      purchasedate: {
        required: true,
        purchasedate: true,
      },
      takenby: {
        required: true,
        takenby: true,
      },
      takendate: {
        required: true,
        takendate: true,
      },
      
    },
    messages: {
      name: {
        required: "Please enter product name"
      },
      quantity: {
        required: "Please enter product quantity"
      },
      unit: {
        required: "Please enter quantity unit name"
      },
      quantityprice: {
        required: "Please enter product quantity price"
      },
      grandtotal: {
        required: "Please enter grand total"
      },
      purchasedate: {
        required: "Please enter purchase date",
      },
      takenby: {
        required: "Please enter taken by name",
      },
      takendate: {
        required: "Please enter taken date",
      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});

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
    //quantity check
    $(document).on('change','#quantity',function(){
      var nameid      = $('#name').val();
      var quantityval = $('#quantity').val();
      if (nameid == "") {
        alert('Product name can not be empty !!');
      }
      $.ajax({
          url:"{{route('get-product-qty') }}",
          type:"GET",
          data:{nameid:nameid,quantity:quantityval},
          success:function(data){
                if (data == "over") {
                  alert('Sorry !! you do not have enough storage');
                  $("#saveprd").attr('disabled', true);
                }else{
                  //alert('success');
                  $("#saveprd").attr('disabled', false);
                }
              
          }
      });
    });
  });
$(document).on("wheel", "input[type=number]", function (e) {
    $(this).blur();
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
    var result = parseInt(num1) * parseInt(num2);
    if (!isNaN(result)) {
        document.getElementById('totalprice').value = result;
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
  $("#takendate").datepicker({ dateFormat: "dd-M-yy"});
</script>
@endpush
