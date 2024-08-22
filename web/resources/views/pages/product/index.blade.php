@extends('layouts.app')
@push('custom_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@php
$prdnames = $data['productsname'];
$department = $data['department'];
$supplier = $data['supplier']
@endphp
@section('content')
<!-- Main content -->
<section class="content pt-2">
  <div class="container-fluid">
    <!-- Main row -->
    <div class="row">
      <div class="col-sm-12">
        @if(session('msg'))
        <div class="mt-2 mb-2">
          <div id="successMsg" class="alert alert-success">{{session('msg')}}</div>
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
          <div>
            <!-- form start -->
            <form id="quickForm" action="{{ route('save-product') }}" method="POST">
              @csrf
              @method('post')
              <div class="card-body">
                <div class="row">
                  <div class="row col-md-12">
                    <div class="col-sm-4 form-group">
                      <label for="purchasedate">Purchase Date <span style="color: red">*</span></label><br>
                      <input type="text" name="purchasedate" value="{{old('purchasedate')}}" placeholder="Purchase date" class="form-control" id="purchasedate">
                    </div>
                    <div class="col-sm-3 form-group">
                      <label for="reqdept"> Requistion Department <span style="color: red">*</span></label><br>
                      <select class="form-control" name="reqdept" id="reqdept">
                        <option value="">select</option>
                        @if($department->count() > 0)
                        {{$sl = 0 }}
                        @foreach($department as $row)
                        <option value="{{$row->dep_name}}">{{ $sl +=1 }}.  {{$row->dep_name}}</option>
                        @endforeach
                        @endif
                      </select>
                    </div>
                    <div class="col-sm-3 form-group">
                      <label for="supplier">Supplier <span class="text-danger">*</span></label>
                      {{-- Supplier --}}
                      <select class="form-control" name="supplier" id="supplier">
                        <option value="">Select</option>
                        @if(isset($supplier) && $supplier->count() > 0)
                          {{$sl = 0 }}
                          @foreach($supplier as $row)
                            <option value="{{$row->supplier_name}}">{{ $sl +=1 }}. {{$row->supplier_name}}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                    <div class="col-sm-2 form-group">
                      <label for="">No. of Entries <span style="color: red">*</span></label><br>
                      <label for="entryCount" name="entries" class="form-control" id="entryCount">0</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      {{-- Product Table --}}
                      <table class="table table-bordered product-table" id="product-table">
                        <thead>
                          <tr>
                            <th><label for="name[]">Product Name <span style="color: red">*</span></label></th>
                            <th><label for="quantity[]">Quantity <span style="color: red">*</span></label></th>
                            <th><label for="unit[]">Unit <span style="color: red">*</span></label></th>
                            <th><label for="quantityprice[]">Product Price <span style="color: red">*</span></label></th>
                            <th><label for="totalprice[]">Total Price <span style="color: red">*</span></label></th>
                            <th><label for="Action">Action</th>
                          <tr>
                        </thead>
                        <tbody>
                          {{-- the product details here --}}
                          @include('pages/product/store-add-row')
                          <tr>
                            <td colspan="1">
                              <button type="button" class="btn btn-secondary" id="add-row">Add More</button>
                            </td>
                            <td colspan="5">
                              <label for="showMsg" id="showMsg" class="text-success large"></label>
                            </td>
                          </tr>
                        </tbody>
                      </table>
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
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!--/. container-fluid -->
</section>

<!-- /.content -->
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function () {
    $('.product-name').select2();
    $('#reqdept').select2();
    $('#supplier').select2();
    $("#purchasedate").datepicker({dateFormat: "dd-M-yy"});
    // Add new row for product entry    
    $(document).on('click', '#add-row', function (e) {
      e.preventDefault();
      var $this = $(this);  
      var row = `@include("pages/product/store-add-row")`;
      $this.closest('tr').before(row);
      $('.product-name').select2();
      getUnit();
      getTotalPrice();
      getEntryNumber();
    });
    // Delete row 
    deleteRow();
    // Get unit and show previous price 
    getUnit();
    // Get total price
    getTotalPrice();
    // Get entry numbers
    getEntryNumber();
    // Form Submission 
    $('#quickform').on("submit", function (e) {       
      $('#saveprd').prop('disabled', true); // Disable the submit button
    });
  });

  function checkValid() {
    let isValid = true;
    $("#quickform input, #quickform select, #quickform textarea").each(function () {
      if ($(this).val() === "") {
        isValid = false;
      }
    });
    if (!isValid) {
      alert("Please input all fields!!");
      saveButton.prop("disabled", false);
      return false;
    }
  }

  function getEntryNumber() {
    var num = $('.product-table tbody tr').length-1;
    $('#entryCount').text(num);
  }

  function getTotalPrice() {
    var totalprice = 0.00;
    $(document).on('input', '.quantity, .quantityprice', function () {
      const $this = $(this);
      const $row = $this.closest('tr');
      const msg = $row.find('.priceMsg');
      const product_id = $row.find('.product-name').val();
      if(product_id){
        const qtyprice = parseFloat($row.find('.quantityprice').val());
        const quantity = parseFloat($row.find('.quantity').val());
        totalprice = (qtyprice * quantity ? qtyprice * quantity : 0.000 );
        $row.find('.totalprice').val(totalprice.toFixed(3));
        if (qtyprice) {
          msg.removeClass('text-danger').addClass('text-success').text('processing...');
          checkPrice(qtyprice, product_id, function (message, cls) {
              (msg.hasClass('text-danger') ? 
                      msg.removeClass('text-danger').addClass(cls).text(message) 
                        : msg.removeClass('text-success').addClass(cls).text(message));
            });
        }
      } else{
          alert("Product name can't be empty!!!")
      }
    });
  }

   function checkPrice(price, id, callback) {
     var msg = '';
     var cls = '';
     $.ajax({
       type: "GET",
       url: "{{ route('get-product-price') }}",
       data: {prdprice:price, productId:id},
       dataType: "json",
       success: function (data) {
         if (data.status == 'error') {
           msg = `The previous price was - ${data.price}`;
           cls = 'text-danger';
         } else if (data.status == 'success') {
           msg = "The prices are same!!";
           cls = "text-success";
         } else if (data.status == 'fentry') {
           msg = 'First entry!!';
           cls = 'text-success';
         } else {
           console.log('something went wrong!!');
           msg = 'Something went wrong!!';
           cls = 'text-danger';
         }
         callback(msg, cls);
        },
        error: function(xhr, status, error) {
            console.error('AJAX error', error);
            callback('Something was wrong!!');
        }
      });
   }

  function checkDuplicate(check) {
    var isDuplicate = false;
    var productName = check.val();
    $('.product-name').not(check).each(function(){
      if($(this).val() === productName) {
        isDuplicate = true;
      }
    });
    return isDuplicate;
  }

  function getUnit() {
    $(document).on('change', '.product-name', function (e) {
      e.preventDefault();
      var $this = $(this);
      var $row = $this.closest('tr');
      var product_id = $this.val();
      if (checkDuplicate($this)) {
        $row.find('.showErrorMsg').text('Pruduct already entered!!!'); // Show error msg 
        $this.val();
      } else {
        $row.find('.showErrorMsg').text('');  // Reset any error
        // Request for product unit
        $.ajax({
          type: "GET",
          url: "{{ route('get-product-unit') }}",
          data: {
            nameid: product_id,
          },
          dataType: "json",
          success: function (data) {
            $row.find('.unit').val(data.unit); // Get product unit
          },
        });        
      }
    });
  }

  function deleteRow() {
    $(document).on('click', '.deleteRow', function (event) {
      // row deletion logic
      event.preventDefault();
      let isConfirmed = confirm("Do you want delete this row?");
      if(isConfirmed){
        var $this = $(this);
        const $row = $this.closest('tr');
        $row.remove();
        $("#showMsg").text('Row was deleted!!!').fadeOut(3000);
        getEntryNumber();
      }else {
        $("#showMsg").text('Row was not deleted!!!');
      }
    });
  }

  function submit() {
    
  }
</script>
@endpush
