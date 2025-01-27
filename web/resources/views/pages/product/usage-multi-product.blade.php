@extends('layouts.app')
@push('custom_css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .is-invalid-select2 .select2-selection {
        border-color: red !important;
    }
    .product-name {
          width: 150px;
      }
    
    #successMsg {
      position: relative;
      padding-right: 3rem; /* Ensure enough space for the close button */
    }

    .btn-close {
      position: absolute;
      top: 0;
      right: 0;
      margin-top: 10px;  /* Adjust the top margin */
      margin-right: 10px;  /* Adjust the right margin */
    }

  </style>
@endpush
@php
  $prdnames = $data['productsname'];
  $department = $data['department'];
@endphp
@section('content')
    <!-- Main content -->
    <section class="content pt-2">
      <div class="container-fluid">
        <div class="mt-2 mb-2">
          <div id="successMsg" class="position-relative alert">
          </div>
        </div>

        <!-- Main row -->
        <div class="row">
          <div class="col-sm-12">
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
              <form id="quickForm">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="row col-sm-12">
                      <div class="col-sm-4 form-group">
                        <label for="name">Taken Date <span style="color:red;">*</span></label> <br>
                        <input type="text" name="takendate" value="{{old('takendate')}}" placeholder="Taken date" class="form-control" id="takendate" >
                      </div>
                      <div class="col-sm-3 form-group">
                        <label for="brand">Taken by <span style="color:red;">*</span></label>
                        <input type="text" name="takenby" class="form-control" value="{{old('takenby')}}" id="takenby" placeholder="Enter taken by name">
                      </div>
                      <div class="col-sm-3 form-group">
                         <label for="brand">Requisition Dept. <span style="color:red;">*</span></label>
                          <select class="form-control" name="reqdept" id="reqdept">
                            <option value="">select</option>
                            @if($department->count() > 0)
                              {{$sl = 1}}
                              @foreach($department as $row)
                                <option value="{{$row->dep_name}}">{{$sl+=1}}. {{$row->dep_name}}</option>
                              @endforeach
                            @endif
                          </select>
                      </div>
                      <div class="col-sm-2 form-group">
                        <label for="">No. of Entries <span style="color: red">*</span></label><br>
                        <span name="entries" class="form-control" id="entryCount">0</span>
                      </div>                    
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <table class="table table-bordered product-table" id="product-table">
                        <thead>
                          <tr>
                            <th><label for="name[]">Product Name <span style="color: red">*</span></label></th>
                            <th><label for="quantity[]">Quantity <span style="color: red">*</span></label></th>
                            <th><label for="unit[]">Unit <span style="color: red">*</span></label></th>
                            <th><label for="quantityprice[]">Product Price <span style="color: red">*</span></label></th>
                            <th><label for="totalprice[]">Total Price <span style="color: red">*</span></label></th>
                            <th><label for="Action">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @include('pages.product.usage-add-row')
                          <tr>
                            <td colspan="1">
                              <button type="button" class="btn btn-secondary" id="add-row">Add More</button>
                            </td>
                            <td colspan="5">
                              <span for="showMsg" id="showMsg" class="text-success large"></span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                 </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="button" class="btn btn-primary" id="saveprd">Save Product</button>
                 </div>
              </form>
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
        initializeProductNameSelect2();
        $("#takendate").datepicker({ dateFormat: "dd-M-yy"});
        $('#reqdept').select2();

        $(document).on('click', '#add-row', function (e) {
          e.preventDefault();
          const $this = $(this);
          let row = `@include('pages.product.usage-add-row')`;
          $this.closest('tr').before(row);
          updateEntryCount();
          updateTotalPrice();
          initializeProductNameSelect2();
        });
        // Delete Row
        handleRowDeletion();
        // Get Unit AutoMatically
        fetchAndPopulateProductUnit();
        // Check for Product stock
        checkStock();
        // Automatically calculate total price
        updateTotalPrice();
        updateEntryCount();

        clearErrorMessagesOnInput('.quantity');
        clearErrorMessagesOnInput('.quantityprice');
        clearErrorMessagesOnInput('#takendate');
        clearErrorMessagesOnInput('#takenby');
        clearSelectErrorMessages();

        saveMultipleUsageProducts();
      });

      function checkStock() {
        $(document).on('keyup','.quantity',function(){
          const $this = $(this);
          const $row = $(this).closest('tr');
          const nameid      = $row.find('.product-name').val();
          var quantityval = $this.val();
          if (nameid == "") {
            alert('Product name can not be empty !!');
          }
          $.ajax({
              url:"{{route('get-product-qty') }}",
              type:"GET",
              data:{nameid:nameid,quantity:quantityval},
              success:function(data){
                    if (data.status == "over") {
                      alert('Sorry !! You have only -> '+data.qty+' products');
                      $this.val('');
                      $row.find('.totalprice').val('');
                      $("#saveprd").attr('disabled', true);
                    } else{
                      $("#saveprd").attr('disabled', false);
                    }
              }
          });
        });
      }

      function fetchAndPopulateProductUnit() {
        $(document).on('change', '.product-name', function (e) {
          e.preventDefault()
          const $productSelect = $(this); // The product name select element
          const $row = $productSelect.closest('tr'); // The row containing the product select
          const productId = $productSelect.val(); // The selected product ID

          // Check if the product name has already been entered
          if (isDuplicateProductName($productSelect)) {
              if ($productSelect.hasClass('select2-hidden-accessible')) {
                  // Clear the select and display an error message if duplicate
                  $productSelect.val(null).trigger('change')
                      .after(`<small class="text-danger error-msg">Product name already entered!</small>`);
              }
          } else {
            $.ajax({
              type: "GET",
              url: "{{ route('get-product-usage-unit') }}",
              data: {
                nameid:productId,
              },
              dataType: "json",
              success: function (data) {
                $row.find('.stock').text(`Stock available ${data.stock.prd_qty} ${data.unit}`);
                $row.find('.unit').val(data.unit);
                $row.find('.quantityprice').val(data.qtyprice).trigger('input');
              }
            });
          }
        });
      }
    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });
    
    function saveMultipleUsageProducts(params) {
      $(document).on('click', '#saveprd', function (e) {
          e.preventDefault();
          const $button = $(this); // The button that triggered the action
          $button.attr('disabled', true).html('Saving...'); // Change button text to indicate saving in progress
          const form = $button.closest('form'); // The form containing the product data
          const formData = form.serialize(); // Serializing form data for submission
          const url = "{{ route('save-multiple-storage-product') }}"; // The URL for the AJAX request
          const addRowSection = $('#product-table tbody tr:last-child').html(); // HTML for the last row to append
          const row = `@include('pages.product.usage-add-row')`;

          $.ajax({
              type: "POST",
              url: url,
              data: formData,
              dataType: "json",
              success: function (response) {
                  // On success, update the UI with the success message and reset the form
                  $('#product-table tbody').empty().append(row + addRowSection); // Remove previous rows and Add new row to the table
                  handleSessionMessage(response.msg, 'success');
                  resetFormAndSelect2(form);
                  initializeProductNameSelect2(); // Reinitialize Select2 for product names
                  $button.attr('disabled', false).html('Save Product'); // Reset button text
                  $button.after(`<small class='ml-2 text-success success-msg'>${response.msg}</small>`)
                      .next().fadeOut(4000); // Show success message and fade out
              },
              error: function (xhr) {
                  // On error, display the error message and handle validation errors
                  $button.attr('disabled', false).html('Save Product'); // Reset button text
                  $button.after(`<small class='ml-2 text-danger'>${xhr.responseJSON.message}</small>`)
                      .next().fadeOut(4000); // Show error message and fade out

                  if (xhr.responseJSON && xhr.responseJSON.errors) {
                      // Handle form validation errors
                      let errors = xhr.responseJSON.errors;
                      let errorList = '<ul>';
                      $('.is-invalid').removeClass('is-invalid');
                      $('.error-msg').remove();
                      $('.select2').removeClass('is-invalid-select2');

                      $.each(errors, function (field, messages) {
                          // Display field-specific errors
                          displayFieldError(field, messages);
                          messages.forEach(message => {
                              errorList += `<li>${message}</li>`; // List each error messageer
                          });
                      });

                      errorList += '</ul>';
                      handleSessionMessage(errorList, 'failed');
                  } else if (xhr.responseJSON && xhr.responseJSON.message) {
                      handleSessionMessage(xhr.responseJSON.message, 'failed');
                  } else {
                      handleSessionMessage('An unexpected error occurred. Please try again!', 'failed');
                  }
              }
          });
      });
    }
</script>
@endpush
