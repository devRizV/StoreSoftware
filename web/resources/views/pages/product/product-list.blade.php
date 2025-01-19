@extends('layouts.app')
@push('custom_css')
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
  // $products = $data['products'];
  $department = $data['department'] ?? null;
  $supplier = $data['supplier'] ?? null;
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <form class="form-inline" action="{{ route('order.list') }}" method="get">
                <input type="text" placeholder="from date" value="{{ request()->get('from_date') }}" readonly="" class="input-field" name="from_date" id="from_date" >
              <div class="form-group mx-sm-3">
                <input type="text" placeholder="to date" value="{{ request()->get('to_date') }}" readonly="" class="input-field" name="to_date" id="to_date">
              </div>
              or
              <div class="form-group mx-sm-3">
                <input type="text" placeholder="specific date" value="{{ request()->get('fix_date') }}"  readonly="" name="fix_date" class="input-field" id="fix_date">
              </div>
              <div class="form-group mx-sm-3">
                <select class="input-field" name="department">
                  <option value="">select department</option>
                  @if($department != null && $department->count() > 0)
                    @foreach($department as $row)
                      <option value="{{$row->dep_name}}" {{ request()->get('department') == $row->dep_name ? 'selected' : '' }}>{{$row->dep_name}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
              <div class="form-group mx-sm-3">
                <select class="input-field" name="supplier">
                  <option value="">select supplier</option>
                  @if($supplier != null && $supplier->count() > 0)
                    @foreach($supplier as $row)
                      <option value="{{$row->supplier_name}}" {{ request()->get('supplier') == $row->supplier_name ? 'selected' : '' }} >{{$row->supplier_name}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
              <div class="form-group mx-sm-3">
                <button style="background: #0af1c685; color:#000;" type="submit" class="">Search</button>
              </div>
               <div class="form-group">
                  <a style="background: #f10a5e; color:#fff;" class="reset-btn" href="{{ route('all-product') }}">Reset</a>
               </div>
                  <button style="background: #008000; color:#fff;" type="submit" class="mt-2" name="download_excel" value="1">Download Excel</button>
            </form>
      </div><!-- /.container-fluid -->
      <div  class="mt-2 mb-2">
        @if(session('msg'))
          <div class="alert alert-success">{{session('msg')}}</div>
        @endif
        <div id="show-alert" class="show-alert"></div>
      </div>
      <div  class="mt-2 mb-2">
          <div id="sum"><div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product List</h3>
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
                    {{-- Previous server side loading.
                    @if(isset($products) && count($products) > 0)
                      @foreach($products as $row)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$row->prd_name}}</td>
                          <td>{{$row->prd_req_dep}}</td>
                          <td>{{$row->prd_qty}}</td>
                          <td>{{$row->prd_unit}}</td>
                          <td>{{$row->prd_qty_price}}</td>
                          <td>{{$row->prd_price}}</td>
                          <td>{{$row->prd_grand_price}}</td>
                          <td>{{date('d-M-Y', strtotime($row->prd_purchase_date))}}</td>
                          <td>{{date('d-M-Y', strtotime($row->created_at))}}</td>
                          <td>{{$row->stock ?? ''}}</td>
                          <td>
                            <a href="{{url('edit-product/'.$row->pk_no)}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                            <a href="{{url('view-product/'.$row->pk_no)}}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                            <a onclick="return confirm('Are you really sure to delete ?');" href="{{url('delete-product/'.$row->pk_no)}}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                    @endforeach
                    @endif 
                    --}}
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
  <script>
    $( function() {
      $( "#from_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#to_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#fix_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });
  </script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      const table = $('#productlist').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('all-product') }}",
          type: 'GET',
          dataSrc: function (response) {  
            const loadedTotalPriceContainer = $("#productlist tfoot th:nth-child(1)");
            const totalPriceContainer = $("#productlist tfoot th:nth-child(2)");

            if (loadedTotalPriceContainer) {
              loadedTotalPriceContainer.html(`Current page total: ${response.loadedTotalPriceSum}`);
            }
            if (totalPriceContainer) {
              totalPriceContainer.html(`Total: ${response.totalPriceSum.toFixed(3)}`);
            }

            return response.data;
          },
        },
        columns: [
          { data: 'sl', title: 'SL' }, // SL
          { data: 'prd_name', title: 'Name' }, // Name
          { data: 'prd_req_dep', title: 'Req. Dept.' }, // Req. Dept.
          { data: 'prd_qty', title: 'Quantity' }, // Quantity.
          { data: 'prd_unit', title: 'Unit' }, // Unit
          { data: 'prd_qty_price', title: 'Purchase Date' }, // Purchase price
          { data: 'prd_price', title: 'Total Price' }, // Total Price
          { data: 'prd_grand_price', title: 'G. Total Price' }, // G. Total Price
          { data: 'prd_purchase_date', Title: 'Purchase Date' }, // Purchase Date
          { data: 'created_at', title: "Created" }, // Created
          { data: 'stock', title: 'Stock' }, // Stock
          { 
            data: 'pk_no',
            title: 'Action',
            render: function (data, type, row) { 
              return `
                <a href="edit-product/${data}" class="btn btn-primary btn-xs"> 
                  <i class="fa fa-edit"></i>
                  </a>
                <a href="view-product/${data}" class="btn btn-primary btn-xs"> 
                  <i class="fa fa-eye"></i>
                </a>
                <a class="btn btn-danger btn-xs delete-btn" data-id=${data}> 
                  <i class="fa fa-trash"></i>
                </a>
              `;
            },
            orderable: false,
          }, // Action
        ],
        order: [[0, 'desc']], // Default sorting (by SL)
      });

      $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();

        const productId = $(this).data('id');
        console.log(productId);
        
        const url = `delete-product/${productId}`;

        if (confirm("Are you sure to delete you want to delete this product?")) {
          console.log("delete");
          $.ajax({
            type: "POST",
            url: url,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
              handleSessionMessage(response.msg, "success",  '#show-alert');
              table.ajax.reload(null, false);
            },
            error: function (xhr, stutus, error) { 
              handleSessionMessage(xhr.responseJSON.message, status, "#show-alert");
            }
          });
        }
      });

    });
  </script>
@endpush
