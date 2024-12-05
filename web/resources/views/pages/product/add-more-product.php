@extends('layouts.app')
@push('custom_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@php
$prdnames = $data['productsname'];
$department = $data['department'];
$supplier = $data['supplier'];
@endphp
@section('content')
<!-- Main content -->
<section class="content pt-2">
  <div class="container-fluid">
    <!-- Product entry form -->
    <div class="row">
      <div class="col-sm-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Product Entry</h3>
          </div>
          <div class="row">
            <div class="col-sm-10">
              @if(session('msg'))
              <div class="mt-2 mb-2">
                <div class="alert alert-success">{{session('msg')}}</div>
              </div>
              @endif

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
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Form Start -->
    <form id="quickForm" action="{{route('save-product')}}" method="post">
      @csrf
      <!-- Top row -->
      <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            <label for="purchasedate">Purchase Date <span style="color:red;">*</span></label>
            <input type="text" name="purchasedate" placeholder="Select date" value="{{ old('purchasedate') }}" class="form-control" id="purchasedate">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label for="reqdept">Requisition Dept. <span style="color:red;">*</span></label>
            <select class="form-control" name="reqdept" id="reqdept">
              <option value="">Select a department</option>
              @if($department->count() > 0)
                @foreach($department as $row)
                  <option value="{{$row->dep_name}}">{{$row->dep_name}}</option>
                @endforeach
              @endif
            </select>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label for="supplier">Supplier <span style="color:red;">*</span></label>
            <select class="form-control" name="supplier" id="supplier">
              <option value="">Select a supplier</option>
              @if($supplier->count() > 0)
                @foreach($supplier as $row)
                  <option value="{{$row->supplier_name}}">{{$row->supplier_name}}</option>
                @endforeach
              @endif
            </select>
          </div>
        </div>
        <div class="col-sm-1">
          <div class="form-group">
            <label for="no_of_product">#</label>
            <input type="number" name="no_of_product" class="form-control" value="{{ old('no_of_product') }}" min="1">
          </div>
        </div>
      </div>
      <!-- Entry table -->
      <div class="row">
        <div class="col-sm-12">
          <table id="product-table" class="table table-bordered">
            <thead>
              <tr>
                <th width="35%">Product Name <span style="color:red;">*</span></th>
                <th width="8%">Unit<span style="color:red;">*</span></th>
                <th width="15%">Quantity <span style="color:red;">*</span></th>
                <th width="20%">Per Quantity Price <span style="color:red;">*</span></th>
                <th width="15">Total Price</th>
                <th width="7">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr id="row_1">
                <td width="35%">
                  <select class="js-example-basic-single form-control" name="name[]" id="name">
                    <option value="">Select Product Name</option>
                    @if(isset($prdnames) && count($prdnames) > 0)
                    @foreach($prdnames as $row)
                    @if(request()->get('name'))
                    <option <?php if (request()->get('name') == $row->prd_name) echo 'selected'; ?> value="{{$row->pk_no}}">{{$row->prd_name}}</option>
                    @else
                    <option value="{{$row->pk_no}}">{{$row->prd_name}}</option>
                    @endif
                    @endforeach
                    @endif
                  </select>
                </td>
                <td width="8%">
                  <input type="text" name="unit[]" id="unit" class="form-control" value="{{ old('unit') }}" readonly>
                </td>
                <td width="15%">
                  <input type="text" name="quantity[]" id="quantity" class="form-control" value="{{ old('quantity') }}">
                </td>
                <td width="15%">
                  <input type="text" name="quantityprice[]" id="quantityprice" class="form-control" value="{{ old('price') }}">
                </td>
                <td width="20%">
                  <input type="text" name="totalprice[]" id="totalprice" class="form-control" readonly>
                </td>
                <td width="7%">
                  <button type="button" class="btn btn-danger btn-md delete-row">
                    <i class="fas fa-times"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </form>

    <!-- Add Row button -->
    <div class="row mt-2">
      <div class="col-sm-12">
        <button type="button" class="btn btn-primary btn-md" id="add-row">
          <i class="fas fa-plus fa-sm"></i> Add More
        </button>
      </div>
    </div>
    <!-- Save Product button -->
    <div class="row mt-2">
      <div class="col-sm-12">
        <button type="submit" class="btn btn-success btn-md"> <i class="far fa-circle fa-sm"></i> Save Product</button>
      </div>
    </div>
  </div>
</section>
@endsection
@push('scripts')


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script src="text/javascript">
  $(document).ready(function() {

  });
</script>


{{-- <script type="text/javascript">
 $(document).ready(function() {
  var rowCounter = 1; // Counter for unique row IDs

  function initializeSelect2(element) {
    $(element).select2();
  }

  // Add More button click event
  $('#add-row').click(function() {
    var newRowHtml = `
      <tr id="row_${rowCounter}">
        <td width="35%">
          <select class="js-example-basic-single form-control product-name" name="name[]" id="name_${rowCounter}">
            <option value="">Select Product Name</option>
            @if(isset($prdnames) && count($prdnames) > 0)
              @foreach($prdnames as $row)
                @if(request()->get('name'))
                  <option <?php if (request()->get('name') == $row->prd_name) echo 'selected'; ?> value="{{$row->pk_no}}">{{$row->prd_name}}</option>
@else
<option value="{{$row->pk_no}}">{{$row->prd_name}}</option>
@endif
@endforeach
@endif
</select>
</td>
<td width="8%">
  <input type="text" name="unit[]" class="form-control unit" value="" readonly id="unit_${rowCounter}">
</td>
<td width="8%">
  <input type="text" name="quantity[]" class="form-control quantity" value="" id="quantity_${rowCounter}">
</td>
<td width="15%">
  <input type="text" name="quantityprice[]" class="form-control quantity-price" value="" id="quantityprice_${rowCounter}">
</td>
<td width="20%">
  <input type="text" name="totalprice[]" class="form-control total-price" readonly id="totalprice_${rowCounter}">
</td>
<td width="7%">
  <button type="button" class="btn btn-danger btn-md delete-row">
    <i class="fas fa-times"></i>
  </button>
</td>
</tr>
`;

var newRow = $(newRowHtml);
$('#product-table tbody').append(newRow);

// Initialize Select2 for the new row's product name select element
initializeSelect2(newRow.find('.product-name'));

rowCounter++; // Increment row counter for unique IDs
});
// Delete Row button click event
$(document).on('click', '.delete-row', function() {
$(this).closest('tr').remove();
});

$(document).ready(function() {
//this calculates values automatically
sum();
$(".quantity, .quantity-price").on("keydown keyup", function() {
sum();
});
});
function sum() {
var qty = $(this).closest("tr").find(".quantity").val();
var qtyPrice = $(this).closest("tr").find('.quantity-price').val();
var totalprice = qty*qtyPrice;
if (!isNaN(totalprice)) {
$(this).closest("tr").find(".total-price").val(totalprice);
}
}

$(document).on('change', '.product-name', function() {
var row = $(this).closest('tr');
var selectedProductId = $('.product-name').val();

// Find the unit input field within the current row
var unitInput = row.find('.unit');

$.ajax({
url: "{{ route('get-product-unit') }}",
type: "GET",
data: { nameid: selectedProductId },
success: function(data) {
unitInput.val(data);
},
error: function() {
console.log('Error occurred while retrieving product unit');
}
});
});


// Function to initialize Select2
initializeSelect2('.product-name');
});

</script>
--}}
{{-- <script type="text/javascript">
  // In your Javascript (external .js resource or <script> tag)
  $(document).ready(function() {
      $('.js-example-basic-single').select2();
      $('#reqdept').select2();
  });
</script> --}}

{{-- <script>
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
var price = $(this).val();
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
}
}
</script> --}}

{{-- <script type="text/javascript">
  $("#purchasedate").datepicker({ dateFormat: "dd-M-yy"});
  $("#expirydate").datepicker({ dateFormat: "dd-M-yy",changeYear:true, yearRange: "2021:2050"});
  $("#expiryalert").datepicker({ dateFormat: "dd-M-yy",changeYear:true, yearRange: "2021:2050"});
  
  $(document).ready(function () {
    $("#quickForm").submit(function () {
        $("#saveproduct").attr("disabled", true);
        return true;
    });
});
</script> --}}
@endpush



{{-- <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="name">Product Name <span style="color:red;">*</span></label> <br>
                    <select class="form-control" name="name" id="name">
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
      <label for="takendate">Taken Date <span style="color:red;">*</span></label> <br>
      <input type="text" name="takendate" readonly="" value="{{old('takendate')}}" placeholder="Taken date" class="form-control" id="takendate">
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
      <input type="text" min="1" name="quantityprice" value="{{old('quantityprice')}}" class="form-control" id="quantityprice" placeholder="Enter product quantity price">
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <label for="brand">Total Price <span style="color:red;">*</span></label>
      <input type="text" name="totalprice" value="{{old('totalprice')}}" class="form-control" id="totalprice" readonly="">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="form-group">
      <label for="brand">Grand Total <span style="color:red;">*</span></label>
      <input type="number" name="grandtotal" value="{{old('grandtotal')}}" class="form-control" id="grandtotal" placeholder="Grand total">
    </div>
  </div>
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
      <label for="brand">Remarks (Opt)</label>
      <textarea rows="5" placeholder="Product remarks" class="form-control" name="remarks" id="remarks">{{old('remarks')}}</textarea>
    </div>
  </div>
</div>
</div> --}}
<!-- /.card-body -->
{{-- <div class="card-footer">
              <button type="submit" class="btn btn-primary" id="saveprd">Save Product</button>
            </div> --}}