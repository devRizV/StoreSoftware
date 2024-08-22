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
  $sum = $data['sum'] ?? null;
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <form class="form-inline" action="{{ route('usage.order.list') }}" method="get">
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
            <button style="background: #0af1c685; color:#000;" type="submit" class="">Search</button>
          </div>
           <div class="form-group mx-sm-3">
              <a style="background: #f10a5e; color:#fff;" class="reset-btn" href="{{ route('all-usage-product') }}">Reset</a>
           </div>
              <button style="background: #008000; color:#fff;" type="submit" name="download_excel" value="1">Download Excel</button>
        </form>
      </div><!-- /.container-fluid -->
      @if(session('msg'))
      <div  class="mt-2 mb-2">
          <div class="alert alert-success">{{session('msg')}}</div>
      </div>
      @endif
      
      @if($sum)
      <div  class="mt-2 mb-2">
          <div class="alert alert-success">{{$sum}}</div>
      </div>
      @endif
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
                <h3 class="card-title">Usage Product List</h3>
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
              @if(isset($products) && count($products) > 0)
                    {{-- @dd($products) --}}
                @foreach($products as $row)
                  
                  {{-- @dd($row) --}}
                  <tr>
                    @php
                      $prdName = DB::table('prd_name')->where('pk_no', $row->prd_name_id)->first();
                    @endphp
                    <td>{{$loop->iteration}}</td>
                    <td>{{$prdName->prd_name ?? ''}}</td>
                    <td>{{$row->dept}}</td>
                    <td>{{$row->prd_qty}}</td>
                    <td>{{$row->prd_unit}}</td>
                    <td>{{$row->prd_qty_price}}</td>
                    <td>{{$row->prd_price}}</td>
                    <td>{{$row->prd_grand_price}}</td>
                    <td>{{date('d-M-Y', strtotime($row->taken_date))}}</td>
                    <td>{{date('d-M-Y', strtotime($row->created_at))}}</td>
                    <td>{{$row->stock}}</td>
                    <td>
                      <a href="{{url('edit-usage-product/'.$row->pk_no)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                      <a href="{{url('view-product/'.$row->pk_no)}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                      <a onclick="return confirm('Are you really sure to delete ?');" href="{{url('delete-usage-product/'.$row->pk_no)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
@endsection
@push('scripts')
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
