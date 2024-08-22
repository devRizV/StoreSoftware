

@extends('layouts.app')
@section('content')
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
                <h3 class="card-title">Product Name Entry</h3>
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
              <form id="quickForm" action="{{route('store-product')}}" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                      <div class="col-sm-6">
                       <div class="form-group">
                        <label for="name">Product Name <span style="color:red;">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}" id="name" placeholder="Enter product name">
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Quantity In (kg,pcs,etc) <span style="color:red;">*</span></label>
                        <input type="text" name="unit" value="{{old('unit')}}" class="form-control" id="unit" placeholder="kg,pcs,etc">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="minqty">Minimum Alert Qty</label>
                        <input type="text" name="minqty" value="{{old('minqty')}}" class="form-control" id="minqty" placeholder="Min Qty">
                      </div>
                    </div>
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
                  <button type="submit" class="btn btn-primary">Save Product Name</button>
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
-->