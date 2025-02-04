
@push('custom_css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@php
  $product = $data['products'];
  $prdnames = $data['prdnames'];
@endphp
<div class="">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header modal-header">
                <h3 class="card-title"></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>              
              <!-- form start -->
              <form id="quickForm" action="{{route('update-product')}}" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                      <div class="col-sm-6">
                       <div class="form-group">
                        <label for="name">Product Name</label> <br>
                        <select class="js-example-basic-single form-control" name="name" id="name" disabled>
                          <option value="">Select Product Name</option>
                           @if(isset($prdnames) && count($prdnames) > 0)
                            @foreach($prdnames as $row)
                              <option disabled value="{{$row->pk_no}}" <?php if($row->pk_no == $product->prd_name_id){echo 'selected';}?>>{{$row->prd_name}}</option>
                            @endforeach    
                          @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Purchase Date <span style="color:red;">*</span></label>
                        <input type="text" name="purchasedate" value="{{date('d-M-Y', strtotime($product->taken_date))}}" disabled class="form-control" id="purchasedate" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-6">
                             <div class="form-group">
                              <label for="brand">Product Quantity</label>
                              <input type="number" disabled min="1" name="quantity" value="{{$product->prd_qty}}" class="form-control" id="quantity" placeholder="Enter product quantity">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="brand">Quantity In (kg,pcs,etc)</label>
                              <input disabled type="text" name="unit" value="{{$product->prd_unit}}" class="form-control" id="unit">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Per Quantity Price</label>
                        <input type="number" disabled min="1" name="quantityprice" value="{{$product->prd_qty_price}}" class="form-control" id="quantityprice" placeholder="Enter product quantity price">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Total Price</label>
                        <input type="number" disabled min="1" name="totalprice" value="{{$product->prd_price}}" class="form-control" id="totalprice" readonly="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Grand Total</label>
                        <input type="number" disabled min="1" name="grandtotal" value="{{$product->prd_grand_price}}" class="form-control" id="grandtotal" placeholder="Grand total">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Requisition Dept</label>
                      <input type="text" disabled name="reqdept" value="{{$product->dept}}" class="form-control" id="reqdept" placeholder="Requisition department">
                    </div>
                    </div>
                      <div class="col-sm-6">
                      <div class="form-group">
                        <label for="brand">Taken by</label>
                        <input type="text" readonly="" name="supplier" class="form-control" value="{{$product->taken_by}}" id="supplier" placeholder="Supplier name">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Product Brand(Opt)</label>
                        <input type="text" name="brand" class="form-control" value="{{$product->prd_brand}}" disabled id="brand" placeholder="Enter product brand">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Remarks</label>
                      <textarea rows="5" disabled placeholder="Product remarks" class="form-control" name="remarks" id="remarks">{{$product->prd_remarks}}</textarea>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div>
                      <label for="brand">Created At</label>
                      <input type="text" class="form-control" disabled value="{{date('d-M-y', strtotime($product->created_at))}}" name="">
                      <label for="brand">Last Updated At</label>
                      <input type="text" class="form-control" disabled value="{{date('d-M-y', strtotime($product->updated_at))}}" name="">
                    </div>
                  </div>
                  </div>
                 </div>
                <!-- /.card-body -->
                <div class="d-flex card-footer justify-content-end">
                  <a class="btn btn-danger px-4" data-bs-dismiss="modal">Close</a>
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
</div>

