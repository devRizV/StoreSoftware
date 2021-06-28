@extends('layouts.app')
@push('custom_css')

@endpush
@php
  $departments = $data['departments'];
@endphp
@section('content')
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
                <h3 class="card-title">Department List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Remarks</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
              @if(isset($departments) && count($departments) > 0)
                @foreach($departments as $row)
                  <tr>
                    <td>{{$row->dep_name}}</td>
                    <td>{{$row->dep_remarks}}</td>
                    <td>
                      <a href="{{url('edit-department/'.$row->pk_no)}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                      <a onclick="return confirm('Are you really sure to delete ?');" href="{{url('delete-department/'.$row->pk_no)}}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
              @endforeach    
               @endif
                  </tbody>
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
