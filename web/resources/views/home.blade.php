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
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
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
            <button class="float-right btn btn-info" id="printOut">Print me</button>
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
                  {{number_format($purchase,2)}}
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
                  {{number_format($todayPur,2)}}
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
            <div class="card-body table-responsive">
                <table id="tblalrtlist" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>SL.</th>
                    <th>Product</th>
                    <th>Supplier</th>
                    <th>Requisition Dept</th>
                    <th>Current Stock</th>
                    <th>Alert Qty</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
              @if(isset($notify) && count($notify) > 0)
                @foreach($notify as $row)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td style="color:#FF0000;">{{$row->prd_name}}</td>
                    <td>{{$row->supplier}}</td>
                    <td>{{$row->prd_req_dep}}</td>
                    <td>{{$row->prd_qty}} {{$row->prd_unit}}</td>
                    <td>{{$row->min_qty}} {{$row->prd_unit}}</td>
                    <td>
                     <a href="{{route('product-store',['unit'=>$row->prd_unit, 'name'=>$row->prd_name])}}" class="alert-link"> Take Action <i class="fa fa-arrow-right"></i></a>
                    </td>
                  </tr>
              @endforeach    
               @endif
                  </tbody>
                </table>
              </div>
          <!-- /.col -->
        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
    <div class="printarea d-none" id="printdata">
      <h2 style="text-align: center;font-size: 15px; font-weight: bold; padding: 10px;">Requisation Product List</h2>
         <table id="tblreqproductlist" style="border:1px solid #ddd; border-collapse: collapse;" cellpadding="3" class="">
                  <thead>
                    <tr style="border: 1px solid #ddd; padding: 5px;">
                      <th style="border: 1px solid #ddd; padding: 5px;">SL.</th>
                      <th style="border: 1px solid #ddd; padding: 5px;">Product</th>
                      <th style="border: 1px solid #ddd; padding: 5px;">Supplier</th>
                      <th style="border: 1px solid #ddd; padding: 5px;">Requisition Dept</th>
                      <th style="border: 1px solid #ddd; padding: 5px;">Current Stock</th>
                      <th style="border: 1px solid #ddd; padding: 5px;">Alert Qty</th>
                    </tr>
                  </thead>
                  <tbody>
              @if(isset($notify) && count($notify) > 0)
                @foreach($notify as $row)
                  <tr style="border: 1px solid #ddd; padding: 5px;">
                    <td style="border: 1px solid #ddd; padding: 5px;">{{$loop->iteration}}</td>
                    <td style="border: 1px solid #ddd; padding: 5px;">{{$row->prd_name}}</td>
                    <td style="border: 1px solid #ddd; padding: 5px;">{{$row->supplier}}</td>
                    <td style="border: 1px solid #ddd; padding: 5px;">{{$row->prd_req_dep}}</td>
                    <td style="border: 1px solid #ddd; padding: 5px;">{{$row->prd_qty}} {{$row->prd_unit}}</td>
                    <td style="border: 1px solid #ddd; padding: 5px;">{{$row->min_qty}} {{$row->prd_unit}}</td>
                  </tr>
                @endforeach    
               @endif
                  </tbody>
          </table>
    </div>
@endsection
@push('scripts')
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#tblalrtlist').DataTable();
  } );
    function printData(){
       var divToPrint=document.getElementById("printdata");
       newWin= window.open("");
       newWin.document.write(divToPrint.outerHTML);
       newWin.print();
       newWin.close();
    }

    $('#printOut').on('click',function(){
      printData();
    })
  </script>
@endpush
