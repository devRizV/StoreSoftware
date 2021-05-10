@extends('layouts.app')
@push('custom_css')

@endpush
@php
  $products = $data['products'];
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
          <div class="col-sm-12">
            <form class="form-inline" action="{{ route('order.list') }}" method="get">
              <div class="form-group mx-sm-3 mb-2">
                <label for="from_date" class="sr-only">From Date</label>
                <input type="text" placeholder="from date" value="{{ request()->get('from_date') }}" readonly="" class="form-control" name="from_date" id="from_date" >
              </div>
              <div class="form-group mx-sm-3 mb-2">
                <label for="to_date" class="sr-only">To Date</label>
                <input type="text" placeholder="to date" value="{{ request()->get('to_date') }}" readonly="" class="form-control" name="to_date" id="to_date">
              </div>
              <div class="form-group mx-sm-3 mb-2">
                <label for="to_date" class="sr-only">Fix Date</label>
                <input type="text" placeholder="specific date" value="{{ request()->get('fix_date') }}"  readonly="" name="fix_date" class="form-control" id="fix_date">
              </div>
              <div class="form-group mx-sm-3">
                <button type="submit" class="btn btn-primary mb-2">Search</button>
              </div>
               <div class="form-group">
                  <a class="btn btn-default mb-2" href="{{ route('all-product') }}">Reset</a>
               </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-info mb-2 mx-sm-3" name="download_excel" value="1">Download Excel</button>
              </div>
            </form>
          </div>
        </div>
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
                <h3 class="card-title">Product List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Quantity Price</th>
                    <th>Price</th>
                    <th>Grand Total</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
              @if(isset($products) && count($products) > 0)
                @foreach($products as $row)
                  <tr>
                    @php
                       $prdName = DB::table('prd_name')->where('pk_no', $row->prd_id)->first();
                    @endphp
                    <td>{{$prdName->prd_name}}</td>
                    <td>{{$row->prd_qty}}</td>
                    <td>{{$row->prd_unit}}</td>
                    <td>{{$row->prd_qty_price}}</td>
                    <td>{{$row->prd_price}}</td>
                    <td>{{$row->prd_grand_price}}</td>
                    <td>
                      <a href="{{url('edit-product/'.$row->pk_no)}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                      <a href="{{url('view-product/'.$row->pk_no)}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                      <a onclick="return confirm('Are you really sure to delete ?');" href="{{url('delete-product/'.$row->pk_no)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
              @endforeach    
               @endif
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Quantity Price</th>
                    <th>Price</th>
                    <th>Grand Total</th>
                    <th>Action</th>
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
  } );
  </script>
@endpush
