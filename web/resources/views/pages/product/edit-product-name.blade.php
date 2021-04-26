@extends('layouts.app')
@php
  $prd = $data['products'];
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Update Product Name</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Product Name</li>
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
          <div class="col-sm-8">
            <div class="mt-2 mb-2">
                @if(session('success'))
                  <div class="alert alert-success">{{session('success')}}</div>
                @endif
                @if(session('error'))
                  <div class="alert alert-danger">{{session('error')}}</div>
                @endif
              </div>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Product Name</h3>
              </div>
              <!-- /.card-header -->
              @if ($errors->any())
                  <div class="alert alert-danger mt-2">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              <!-- form start -->
              <form id="quickForm" action="{{route('update-product-name')}}" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                      <div class="col-sm-6">
                       <div class="form-group">
                        <input type="hidden" name="id" value="{{$prd->pk_no}}">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" value="{{$prd->prd_name}}" class="form-control" value="{{old('name')}}" id="name">
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Quantity In (kg,pcs,etc)</label>
                        <input type="text" name="unit" value="{{$prd->prd_unit}}" class="form-control" id="unit" placeholder="kg,pcs,etc">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Remarks (Opt)</label>
                      <textarea rows="5" class="form-control"  name="remarks" id="remarks">{{$prd->prd_remarks}}</textarea>
                    </div>
                  </div>
                  </div>
                 </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update Product Name</button>
                </div>
              </form>
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
$(function () {
  $('#quickForm').validate({
    rules: {
      name: {
        required: true,
        name: true,
      },
      unit: {
        required: true,
        unit: true,
      },
    },
    messages: {
      name: {
        required: "Please enter product name"
      },
      unit: {
        required: "Please enter product unit"
      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});



</script>
@endpush
