@extends('layouts.app')
@push('custom_css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@php
  $product = $data['products'];
  $prdnames = $data['prdnames'];
@endphp
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <div class="col-sm-10">
            <div class="mt-2 mb-2">
                @if(session('msg'))
                  <div class="alert alert-success">{{session('msg')}}</div>
                @endif
              </div>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">View Product</h3>
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
              <form id="quickForm" action="{{route('update-product')}}" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                      <div class="col-sm-6">
                       <div class="form-group">
                        <label for="name">Product Name</label> <br>
                        <select class="js-example-basic-single form-control" name="name" id="name">
                          <option value="">Select Product Name</option>
                           @if(isset($prdnames) && count($prdnames) > 0)
                            @foreach($prdnames as $row)
                              <option  readonly="" value="{{$row->pk_no}}" <?php if($row->pk_no == $product->prd_id){echo 'selected';}?>>{{$row->prd_name}}</option>
                            @endforeach    
                          @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Purchase Date <span style="color:red;">*</span></label>
                        <input type="text" name="purchasedate" value="{{date('d-M-Y', strtotime($product->prd_purchase_date))}}" readonly="" class="form-control" id="purchasedate" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-6">
                             <div class="form-group">
                              <label for="brand">Product Quantity</label>
                              <input type="number" readonly="" min="1" name="quantity" value="{{$product->prd_qty}}" class="form-control" id="quantity" placeholder="Enter product quantity">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="brand">Quantity In (kg,pcs,etc)</label>
                              <input readonly=""  type="text" name="unit" value="{{$product->prd_unit}}" class="form-control" id="unit">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Per Quantity Price</label>
                        <input type="number" readonly="" min="1" name="quantityprice" value="{{$product->prd_qty_price}}" class="form-control" id="quantityprice" placeholder="Enter product quantity price">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Total Price</label>
                        <input type="number" readonly="" min="1" name="totalprice" value="{{$product->prd_price}}" class="form-control" id="totalprice" readonly="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Grand Total</label>
                        <input type="number" readonly="" min="1" name="grandtotal" value="{{$product->prd_grand_price}}" class="form-control" id="grandtotal" placeholder="Grand total">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Requisition Dept</label>
                      <input type="text" readonly="" name="reqdept" value="{{$product->prd_req_dep}}" class="form-control" id="reqdept" placeholder="Requisition department">
                    </div>
                  </div>
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Supplier</label>
                      <input type="text" readonly="" name="supplier" class="form-control" value="{{$product->supplier}}" id="supplier" placeholder="Supplier name">
                    </div>
                  </div>    
                   
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Purchase From</label>
                        <input type="text" readonly="" placeholder="Purchase from" value="{{$product->prd_purchase_from}}" class="form-control" name="purchasefrom" id="purchasefrom" >
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Product Brand(Opt)</label>
                        <input type="text" name="brand" class="form-control" value="{{$product->prd_brand}}" readonly="" id="brand" placeholder="Enter product brand">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Remarks</label>
                      <textarea rows="5" readonly="" placeholder="Product remarks" class="form-control" name="remarks" id="remarks">{{$product->prd_details}}</textarea>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label for="brand">Created At</label>
                    <input type="text" class="form-control" readonly="" value="{{date('d-M-y', strtotime($product->created_at))}}" name="">
                  </div>
                  </div>
                 </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <a href="{{route('all-product')}}" class="btn btn-primary">Back</a>
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


@endpush
