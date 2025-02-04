@extends('layouts.app')
@push('custom_css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <style type="text/css">
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
  $sum = $data['sum'] ?? null;
@endphp
@section('content')
    <div class="modal fade" id="usageProductModal" tabindex="-1" aria-labelledby="usageProductModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body m-0 p-0" style="">
            {{-- The Modal Content will be shown here --}}
          </div>
        </div>
      </div>
    </div>

    <!-- Content Header (Page header) -->
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">Filter Usage Products:</h3>
      </div>
      <div class="content-body m-2 p-0">
        <div class="container-fluid">
          <form class="form-inline" id="filterTable" action="{{ route('usage.order.list')}}">
            <div class="form-floating mr-sm-3">
              <input type="text" value="{{ request()->get('from_date') }}" class="form-control" name="from_date" id="from_date" disabled>
              <label for="from_date">From date</label>
            </div>
            <div class="form-floating">
              <input type="email" class="form-control" id="floatingInput" placeholder="Email">
              <label for="floatingInput">Email address</label>
            </div>
            <div class="form-group mx-sm-3">
              <input type="text" placeholder="to date" value="{{ request()->get('to_date') }}" readonly="" class="form-control" name="to_date" id="to_date">
            </div>
            or
            <div class="form-group mx-sm-3">
              <input type="text" placeholder="specific date" value="{{ request()->get('fix_date') }}" readonly="" name="fix_date" class="form-control" id="fix_date">
            </div>
            <div class="form-group mx-sm-3">
              <select class="form-control" name="department" id="department">
                <option value="">select department</option>
                @if($department != null && $department->count() > 0)
                  @foreach($department as $row)
                    <option value="{{$row->dep_name}}" {{ request()->get('department') == $row->dep_name ? 'selected' : '' }}>{{$row->dep_name}}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="form-group gap-2">
              <button class="btn btn-primary" type="button" id="search-btn">Search</button>
              <button class="btn btn-danger" type="button" class="reset-btn mx-2" id="reset-btn">Reset</button>
            </div>
          </form>
        </div><!-- /.container-fluid -->
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Usage Product List</h3>
                <button type="buttom" id="download_excel" name="download_excel" value="1" class="btn btn-success ms-auto">Download Excel</button>
              </div>
              <div  class="mt-2 mb-2">
                <div id="show-alert" class="show-alert"></div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="productlist" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>SL.</th>
                    <th>Name</th>
                    <th>Req. Dept.</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Qty. Price</th>
                    <th>Price</th>
                    <th>G. Total</th>
                    <th>Taken Date</th>
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
                      <th colspan="6"></th>
                      <th colspan="6"></th>
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

      $('#department').select2({
        width: "100%",
      });

      $( "#from_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#to_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#fix_date" ).datepicker({ dateFormat: 'yy-mm-dd' });

      clearErrorMessagesOnInput('.quantity');
      clearErrorMessagesOnInput('.quantityprice');
      clearErrorMessagesOnInput('#takendate');
      clearSelectErrorMessages();

      updateTotalPrice();

      // Download excel
      bindFormSubmit('#download_excel', '#filterTable', 'download_excel', '1');

      table = initializeUsageDataTable("#productlist", "get-usage-products-list", [0, 'desc']);
      

      $(document).on('click', '#search-btn', function (e) {
        e.preventDefault();

        const button = $(this);
        const form = button.closest('form');
        const formData = form.serialize();
        const url = `usage-order-list?${formData}`;
        
        if ($.fn.DataTable.isDataTable('#productlist')) {
          table.destroy();
        }

        table = initializeUsageDataTable("#productlist", url, [0, 'asc']);
        
      });

      $(document).on('click', '#reset-btn', function (e) {
        e.preventDefault();
        const form  = $(this).closest('form') // Reset search form
        resetFormAndSelect2(form);
        if ($.fn.DataTable.isDataTable('#productlist')) {
          table.destroy();
        }

        table = initializeUsageDataTable("#productlist", "get-usage-products-list", [0, 'desc']);
      });

      $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();

        const productId = $(this).data('id');
        const deleteUrl = `delete-usage-product/${productId}`;
        
        handleDelete(
          deleteUrl,
          (response) => {
            // Handle session message on successful request
            handleSessionMessage(response.msg, response.status, "#show-alert");
            table.ajax.reload(null, false); // Reload Datatable without resetting pagination
          },
          (xhr, status, error) => {
            // Handle session message on unsuccessful request
            handleSessionMessage(xhr.responseJSON.message, status, "#show-alert");
          }
        );
      });

      $(document).on('click', '.edit-btn', function () {
        const button = $(this);
        const productId = button.data('id');
        const editUrl = `edit-usage-product/${productId}`;
        openProductEditModal(editUrl);
      });

      const openProductEditModal = (editUrl) => editProduct(
        editUrl,
        (response) => {
          $("#usageProductModal .modal-body").empty().html(response.html);
          const modal = $("#usageProductModal").modal("show");

          $("#takendate").datepicker({dateFormat: "dd-M-yy"});

          const select2Element = $('.product-name').select2({
            width: '100%',
            dropdownParent: modal,
          });
        },
        (xhr, status, error) => {
          let errors = xhr.responseJSON.message;
          handleSessionMessage(errors, status, '#show-alert');
        }
      );

      $(document).on('click', '.view-btn', function () {
        const button = $(this);
        const productId = button.data('id');
        const viewUrl = `view-usage-product/${productId}`;
        viewProduct(
          viewUrl,
          (response) => {
            $("#usageProductModal .modal-body").empty().html(response);
            $("#usageProductModal").modal("show");
          },
          (xhr, status, error) => {
            handleSessionMessage(xhr.responseJSON, status, "#show-alert")
          }
        )
      });

      $(document).on('click', '#editsubmit', function () {
        const form = $(this).closest('form');
        const formdata = form.serialize();
        const productId = form.find('#prdid').val();
        const updateUrl = `{{ route('update-usage-product', ['id' => '__ID__']) }}`.replace('__ID__', productId);

        $.ajax({
          type: "POST",
          url: updateUrl,
          data: formdata,
          dataType: "json",
          success: function (response) {
            $('#usageProductModal').modal('hide');
            message = `${response.msg}`
            handleSessionMessage(message, response.status, '#show-alert');
            table.ajax.reload(null, false); // Reload DataTable without resetting pagination            
          },
          error: function (xhr, status, error) {
            const errors = xhr.responseJSON.errors;
            let errorList = '<ul class="d-block">';
            if (errors) {
              $.each(errors, function (field, messages) {
                // display errors in each error fields
                displayFieldError(field, messages);

                messages.forEach(message => {
                  errorList += `<li>${field} : ${message}</li>`;
                });
              });
              
              errorList += `</ul>`;
              handleSessionMessage(errorList, status, ".show-error");
            } else {
              handleSessionMessage(xhr.responseJSON.message, status, "#show-alert");
            }
          }
        });

      });
    });
  </script>
@endpush
