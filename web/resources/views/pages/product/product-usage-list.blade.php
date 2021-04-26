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
            <h1 class="m-0">Usage Product List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Usage Product List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
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
                <h3 class="card-title">Usage Product List</h3>
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
                       $prdName = DB::table('prd_name')->where('pk_no', $row->prd_name_id)->first();
                    @endphp
                    <td>{{$prdName->prd_name}}</td>
                    <td>{{$row->prd_qty}}</td>
                    <td>{{$row->prd_unit}}</td>
                    <td>{{$row->prd_qty_price}}</td>
                    <td>{{$row->prd_price}}</td>
                    <td>{{$row->prd_grand_price}}</td>
                    <td>
                      <a href="{{url('edit-usage-product/'.$row->pk_no)}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
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

@endpush
