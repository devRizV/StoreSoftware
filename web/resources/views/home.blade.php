@extends('layouts.app')
@section('content')
@push('custom_css')
  <style type="text/css">
    .alert-danger {
        color: #fff;
        background-color: #f44336;
        border-color: #f44336;
        border-radius: 0;
        padding: 7px;
    }
    a.alert-link.pull-right {
      display: inline-block;
      float: right;
  }
  </style>
@endpush
@php
  $notify = $data['notify'] ?? '';
@endphp
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Welcome to Store Management Software</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Reporting Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Purchased Product (this month)</span>
                <span class="info-box-number">
                  {{round($purchase,2)}}
                  <small>tk</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Purchased Product (today)</span>
                <span class="info-box-number">
                  {{round($todayPur,2)}}
                  <small>tk</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number">{{$users}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Department</span>
                <span class="info-box-number">{{$department}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
      </div><!--/. container-fluid -->
      <hr>
      <div class="container-fluid landing-warning">
        <!-- Info boxes -->
        <div class="row">
          @if(count($notify) > 0)
            @foreach($notify as $row)
          <div class="col-12 col-sm-4">
            <div class="alert alert-danger" role="alert">
                <strong><span style="color: #000;">Warning !!</span> {{$row->product_name}} {{$row->pk_no}} </strong> less than minimum quantity. <a href="#" class="alert-link pull-right"> Take Action <i class="fa fa-arrow-right"></i></a>
              </div>
          </div>
          @endforeach
            @endif
          <!-- /.col -->
        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection
