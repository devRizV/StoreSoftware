@extends('layouts.app')
@push('custom_css')

@endpush
@php
  $users = $data['users'];
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
                <h3 class="card-title">User List</h3>
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
              @if(isset($users) && count($users) > 0)
                @foreach($users as $row)
                  <tr>
                    <td>{{$row->name}}</td>
                    <td>{{$row->email}}</td>
                    <td>
                      <a href="{{url('edit-user/'.$row->id)}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                      <a onclick="return confirm('Are you really sure to delete ?');" href="{{url('delete-user/'.$row->id)}}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
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
