@extends('layouts.app')
@push('custom_css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@php
  $prdnames = $data['productsname'];
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product Entry</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Entry</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <div class="col-sm-8">
            <div class="mt-2 mb-2">
                @if(session('msg'))
                  <div class="alert alert-success">{{session('msg')}}</div>
                @endif
              </div>
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
                        <label for="name">Product Name</label> <br>
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
                        <label for="brand">Product Brand(Opt)</label>
                        <input type="text" name="brand" class="form-control" value="{{old('brand')}}" id="brand" placeholder="Enter product brand">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-6">
                             <div class="form-group">
                              <label for="brand">Product Quantity</label>
                              <input type="number" min="1" name="quantity" value="{{old('quantity')}}" class="form-control" id="quantity" placeholder="Enter product quantity">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="brand">Quantity In (kg,pcs,etc)</label>
                              <input readonly="" type="text" name="unit" value="{{old('unit')}}" class="form-control" id="unit">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Per Quantity Price</label>
                        <input type="number" min="1" name="quantityprice" value="{{old('quantityprice')}}" class="form-control" id="quantityprice" placeholder="Enter product quantity price">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Total Price</label>
                        <input type="number" min="1" name="totalprice" value="{{old('totalprice')}}" class="form-control" id="totalprice" readonly="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Grand Total</label>
                        <input type="number" min="1" name="grandtotal" value="{{old('grandtotal')}}" class="form-control" id="grandtotal" placeholder="Grand total">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                       <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Purchase From(Opt)</label>
                        <input type="text" placeholder="Purchase from" value="{{old('purchasefrom')}}" class="form-control" name="purchasefrom" id="purchasefrom" >
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Purchase Date</label>
                        <input type="text" name="purchasedate" readonly="" value="{{old('purchasedate')}}" class="form-control" id="purchasedate" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Requisition Dept(Opt)</label>
                      <input type="text" name="reqdept" value="{{old('reqdept')}}" class="form-control" id="reqdept" placeholder="Requisition department">
                    </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Purchase for Dept(Opt)</label>
                      <input type="text" name="purdept" class="form-control" value="{{old('purdept')}}" id="purdept" placeholder="Purchase for department">
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

//get prd unit
/*$(document).ready(function() {
    $("#name").on("change", function() {
         var nameid = $('#name').val();
         var URL = "{{url('/')}}";
        $.ajax({
           type:'POST',
           url: URL+'/get-product-unit',
           data: {"_token": "{{ csrf_token() }}","nameid": nameid}
           success:function(data) {
              //$("#msg").html(data.msg);
              alert(data);
           }
        });
    });
});*/
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
  $("#purchasedate").datepicker({ dateFormat: "dd-M-yy"}).datepicker("setDate", new Date());
</script>
@endpush
