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
            <h1 class="m-0">Product Name List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Name List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <div class="col-12">
            <div class="mt-2 mb-2">
                @if(session('msg'))
                  <div class="alert alert-success">{{session('msg')}}</div>
                @endif
              </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product Name List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Unit</th>
                    <th>Remarks</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
              @if(isset($products) && count($products) > 0)
                @foreach($products as $row)
                  <tr>
                    <td>{{$row->prd_name}}</td>
                    <td>{{$row->prd_unit}}</td>
                    <td>{{$row->prd_remarks}}</td>
                    <td>
                      <a href="{{url('edit-product-name/'.$row->pk_no)}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                      <a onclick="return confirm('Are you really sure to delete ?')" href="{{url('delete-product-name/'.$row->pk_no)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
              @endforeach    
               @endif
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Product Name</th>
                    <th>Remarks</th>
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
