@extends('layouts.app')
@php
  $user = $data['users'];
@endphp
@section('content')
    <!-- Main content -->
    <section class="content pt-2">
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
                <h3 class="card-title">Update User</h3>
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
              <form id="quickForm" action="{{route('update-user')}}" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                     <div class="col-sm-6">
                       <div class="form-group">
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <label for="name">User Name</label>
                        <input type="text" required="" name="name" value="{{$user->name}}" class="form-control" value="{{old('name')}}" id="name">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" required="" value="{{$user->email}}" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                      </div>
                    </div>
                  </div>
                 </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update User</button>
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
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        password: true,
      },
    },
    messages: {
      name: {
        required: "Please enter user name"
      },
      email: {
        required: "Please enter email"
      },
      password: {
        required: "Please enter password"
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
