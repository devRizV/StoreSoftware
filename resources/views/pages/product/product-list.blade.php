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
  $products = $data['products'];
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
              <!-- <div class="form-group mx-sm-3">
                <select class="input-field" name="department">
                  <option value="">select department</option>
                  @if($department != null && $department->count() > 0)
                    @foreach($department as $row)
                      <option value="{{$row->dep_name}}" {{ request()->get('department') == $row->dep_name ? 'selected' : '' }}>{{$row->dep_name}}</option>
                    @endforeach
                  @endif
                </select>
              </div> -->
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
                  <button style="background: #008000; color:#fff;" type="submit"  name="download_excel" value="1">Download Excel</button>
            </form>
      </div><!-- /.container-fluid -->
      <div  class="mt-2 mb-2">
        @if(session('msg'))
          <div class="alert alert-success">{{session('msg')}}</div>
        @endif
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
                <h3 class="card-title">Purchased Product List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="productlist" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>SL.</th>
                    <th>Name</th>
                    <!-- <th>Req. Dept.</th> -->
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Purchase Price</th>
                    <th>Total Price</th>
                    <!-- <th>G. Total</th> -->
                    <th>Purchase Date</th>
                    <th>Created</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
              @if(isset($products) && count($products) > 0)
                @php
                  $sum = 0;
                @endphp
                @foreach($products as $row)
                  <tr>
                    @php
                       $prdName = DB::table('prd_name')->where('pk_no', $row->prd_id)->first();
                       $price = $row->prd_price;$sum = $sum+$price;
                    @endphp
                    <td>{{$loop->iteration}}</td>
                    <td>{{$prdName->prd_name ?? ''}}</td>
                    <!-- <td>{{$row->prd_req_dep}}</td> -->
                    <td>{{$row->prd_qty}}</td>
                    <td>{{$row->prd_unit}}</td>
                    <td>{{$row->prd_qty_price}}</td>
                    <td>{{$row->prd_price}}</td>
                    <!-- <td>{{$row->prd_grand_price}}</td> -->
                    <td>{{date('d-M-Y', strtotime($row->prd_purchase_date))}}</td>
                    <td>{{date('d-M-Y', strtotime($row->created_at))}}</td>
                    <td>
                      <a href="{{url('edit-product/'.$row->pk_no)}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                      <a href="{{url('view-product/'.$row->pk_no)}}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                      <a onclick="return confirm('Are you really sure to delete ?');" href="{{url('delete-product/'.$row->pk_no)}}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                @endforeach 
              @endif
                  </tbody>
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
  <div> 
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
        <table class="table table-bordered table-striped">
          <tr>
            <td>TOTAL:{{$sum ?? ''}}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
@push('scripts')

  <script type="text/javascript">
    var sum = 0;
    <?php foreach ($products as $row): ?>
      
    <?php endforeach ?>
  </script>

  <script>
  $( function() {
    $( "#from_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#to_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#fix_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#productlist').DataTable();
  } );
  </script>
@endpush
