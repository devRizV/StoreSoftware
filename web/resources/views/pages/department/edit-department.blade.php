@extends('layouts.app')
@php
  $dep = $data['departments'];
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Update Department</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Department</li>
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
                @if(session('msg'))
                  <div class="alert alert-success">{{session('msg')}}</div>
                @endif
              </div>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Department</h3>
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
              <form id="quickForm" action="{{route('update-department')}}" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                      <div class="col-sm-6">
                       <div class="form-group">
                        <input type="hidden" name="id" value="{{$dep->pk_no}}">
                        <label for="name">Department Name</label>
                        <input type="text" name="name" value="{{$dep->dep_name}}" class="form-control" value="{{old('name')}}" id="name">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Remarks (Opt)</label>
                      <textarea rows="5" class="form-control"  name="remarks" id="remarks">{{$dep->dep_remarks}}</textarea>
                    </div>
                  </div>
                  </div>
                 </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update Department</button>
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
    },
    messages: {
      name: {
        required: "Please enter department name"
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
