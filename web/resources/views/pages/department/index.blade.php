@extends('layouts.app')
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
                <h3 class="card-title">Department Entry</h3>
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
              <form id="quickForm" action="{{route('save-department')}}" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                      <div class="col-sm-6">
                       <div class="form-group">
                        <label for="name">Department Name</label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}" id="name" placeholder="Enter department name">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Remarks (Opt)</label>
                      <textarea rows="5" placeholder="Department remarks" class="form-control" name="remarks" id="remarks">{{old('remarks')}}</textarea>
                    </div>
                  </div>
                  </div>
                 </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save Department</button>
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
