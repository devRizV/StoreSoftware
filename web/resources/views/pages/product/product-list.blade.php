@extends('layouts.app')
@push('custom_css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

  <style type="text/css">
    .is-invalid-select2 .select2-selection {
        border-color: red !important;
    }
    .input-field {
      border-radius: 4px;
      border: 1px solid #ddd;
      padding: 3px 5px;
    }
    button, .reset-btn {
      background: #ffff;
      border: 1px solid #dddd;
      border-radius: 3px !important;
      color: #000;
      padding: 3px 10px;
    }
    input#from_date,input#to_date,input#specific_date {
        width: 101px;
    }
  </style>
@endpush
@php
  $department = $data['department'] ?? null;
  $supplier = $data['supplier'] ?? null;
@endphp
@section('content')
  {{-- Product Edit and display modal --}}
    <div class="modal fade" id="purchaseProductModal" tabindex="-1" aria-labelledby="purchaseProductModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body m-0 p-0" style="">
            {{-- The Modal Content will be shown here --}}
          </div>
        </div>
      </div>
    </div>
    {{-- Filter products --}}
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">
          Filter Purchase Products:
        </h3>
      </div>
      <div class="card-body">
        <div class="container-fluid">
          <form class="form-inline" action="{{ route('order.list') }}" method="get" id="filterTable">
            <div class="form-group mr-sm-3">
              <input type="text" placeholder="from date" value="{{ request()->get('from_date') }}" readonly="" class="input-field p-2" name="from_date" id="from_date">
            </div>
            <div class="form-group mr-sm-3">
              <input type="text" placeholder="to date" value="{{ request()->get('to_date') }}" readonly="" class="input-field p-2" name="to_date" id="to_date">
            </div>
            or 
            <div class="form-group mx-sm-3">
              <input type="text" placeholder="specific date" value="{{ request()->get('fix_date') }}"  readonly="" name="fix_date" class="input-field p-2" id="fix_date">
            </div>
            <div class="form-group">
              <select name="department" id="department" class="input-field">
                <option value="">select department</option>
                @if($department != null && $department->count() > 0)
                  @foreach($department as $row)
                    <option value="{{$row->dep_name}}" {{ request()->get('department') == $row->dep_name ? 'selected' : '' }}>
                      {{$row->dep_name}}
                    </option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="form-group mx-sm-2">
              <select name="supplier" id="supplier" class="input-field">
                <option value="">select supplier</option>
                @if($supplier != null && $supplier->count() > 0)
                  @foreach($supplier as $row)
                    <option value="{{$row->supplier_name}}" {{ request()->get('supplier') == $row->supplier_name ? 'selected' : '' }} >
                      {{$row->supplier_name}}
                    </option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="form-group gap-2">
              <button class="btn btn-primary" type="button" id="search-btn">Search</button>
              <button class="btn btn-danger" type="button" class="reset-btn mx-2" id="reset-btn">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Product Purchase List</h3>
                <button id="download_excel" name="download_excel" value="1" class="btn btn-success ms-auto">
                  Download Excel
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="productlist" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>SL.</th>
                    <th>Name</th>
                    <th>Req. Dept.</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Purchase Price</th>
                    <th>Total Price</th>
                    <th>G. Total</th>
                    <th>Purchase Date</th>
                    <th>Created</th>
                    <th>Stock</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    {{-- Table content here --}}
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="6">{{-- Sum of tatal price --}}</th>
                      <th colspan="6">{{-- Sum of tatal price for current page --}}</th>
                    </tr>
                  </tfoot>
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
@endsection
@push('scripts')
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  {{-- Select2 --}}
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      let table;

      $('#supplier').select2();
      $('#department').select2();
      $( "#from_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#to_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#fix_date" ).datepicker({ dateFormat: 'yy-mm-dd' });

      clearErrorMessagesOnInput('.quantity');
      clearErrorMessagesOnInput('.quantityprice');
      clearErrorMessagesOnInput('#purchasedate');
      clearSelectErrorMessages();

      updateTotalPrice();
      
      // Download excel
      bindFormSubmit('#download_excel', '#filterTable', 'download_excel', '1');

      table = initializePurchaseDataTable("#productlist", "get-purchase-product-list", [0, 'desc']);

      $(document).on('click', '#search-btn', function (e) {
        e.preventDefault();

        const button = $(this);
        const form = button.closest('form');
        const formData = form.serialize();
        const url = `order-list?${formData}`;
        
        if ($.fn.DataTable.isDataTable('#productlist')) {
          table.destroy();
        }

        table = initializePurchaseDataTable("#productlist", url, [0, 'asc']);
        
      });

      $(document).on('click', '#reset-btn', function (e) {
        e.preventDefault();
        $(this).closest('form')[0].reset(); // Reset search form
        if ($.fn.DataTable.isDataTable('#productlist')) {
          table.destroy();
        }

        table = initializePurchaseDataTable("#productlist", "get-purchase-product-list", [0, 'desc']);
      });

      $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();

        const productId = $(this).data('id');
        
        const deleteUrl = `delete-product/${productId}`;

        handleDelete(
          deleteUrl,
          (response) => {
            // Handle Session Message on Successful request
            handleSessionMessage(response.msg, "success", "#show-alert");
            table.ajax.reload(null, false); // Reload DataTable without resetting pagination
          },
          (xhr, status, error) => { 
            // Handle Session Message on unsuccessful request
            handleSessionMessage(xhr.responseJSON, status, "#show-alert");
          }
        );
      });

      $(document).on('click','.edit-btn', function () {
        const button = $(this);
        const productId = button.data('id');
        const editUrl = `edit-product/${productId}`;
        openProductEditModal(editUrl);
      });

      const openProductEditModal = (editUrl) => editProduct(
          editUrl,
          (response) => {
            $('#purchaseProductModal .modal-title').empty().html("Update Product Details");
            $("#purchaseProductModal .modal-body").empty().html(response.html);

            const modal = $("#purchaseProductModal").modal('show'); // Show the modal
 
            $("#purchasedate").datepicker({ dateFormat: "dd-M-yy"}); // Initiate datepicker for purchase date field
            $("#expirydate").datepicker({ dateFormat: "dd-M-yy",changeYear:true, yearRange: "2021:2050"}); // Initiate datepicker for expiry date field
            $("#expiryalert").datepicker({ dateFormat: "dd-M-yy",changeYear:true, yearRange: "2021:2050"}); // Initiate datepicker for expiry alert date field

            const select2Element = $('.product-name').select2({width: '100%', dropdownParent: modal});

            // To fetch and populate the product unit field in the edit form
            fetchAndPopulateProductUnit('/get-product-unit');
          },
          (xhr, status, error) => {
            let errors = xhr.responseJSON.message;
            handleSessionMessage(errors, status, '#show-alert');
          }
        );

      $(document).on('click', '.view-btn', function () {
        const button = $(this);
        const productId = button.data('id');
        const viewUrl = `view-product/${productId}`;
        viewProduct(
          viewUrl,
          (response) => {
            $("#purchaseProductModal .modal-body").empty().html(response);
            $("#purchaseProductModal").modal('show');
          },
          (xhr, status, error) => {
            handleSessionMessage(xhr.responseJSON.message, status, "#show-alert");
          }
        );
      });

      $(document).on('click', '#editsubmit', function () {
        const form = $(this).closest('form');
        const formdata = form.serialize();
        const updateUrl = `{{route('update-product')}}`;

        $.ajax({
          type: "POST",
          url: updateUrl,
          data: formdata,
          dataType: "json",
          success: function (response) {
            $('#purchaseProductModal').modal('hide');
            message = `${response.msg}`
            handleSessionMessage(message, response.status, '#show-alert');
            table.ajax.reload(null, false); // Reload DataTable without resetting pagination            
          },
          error: function (xhr, status, error) {
            const errors = xhr.responseJSON.errors;
            let errorList = '<ul class="d-block">';
            $.each(errors, function (field, messages) {

              // display errors in each error fields
              displayFieldError(field, messages);

              messages.forEach(message => {
                errorList += `<li>${field} : ${message}</li>`;
               });
            });
            
            errorList += `</ul>`;
            handleSessionMessage(errorList, status, ".show-error");
          }
        });

      });
    });    
  </script>
@endpush
