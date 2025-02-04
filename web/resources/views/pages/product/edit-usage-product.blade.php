
@php
  $product = $data['product'];
  $prdnames = $data['prdnames'];
  $departments = $data['departments'];
@endphp
<!-- Main row -->
<div class="card card-primary">
  <div class="card-header modal-header">
    <h3 class="card-title">Update Usage Product Details</h3>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  {{-- Show request errors --}}
  <div class="mt-2 mb-2">
    <div class="show-error"></div>
  </div>
  <!-- form start -->
  <form id="quickForm">
    @csrf
    <div class="card-body">
      <div class="row">
          <div class="col-sm-6">
           <div class="form-group">
            <label for="name">Product Name <span style="color:red;">*</span></label> <br>
            <select class="product-name" name="name" id="name">
              <option value="">Select Product Name</option>
               @if(isset($prdnames) && count($prdnames) > 0)
                @foreach($prdnames as $row)
                  <option  value="{{$row->pk_no}}" <?php if($row->pk_no == $product->prd_name_id){echo 'selected';}?>>{{$row->prd_name}}</option>
                @endforeach    
              @endif
            </select>
          </div>
        </div>
        <input type="hidden" name="prdid" id="prdid" value="{{$product->pk_no}}">
        <div class="col-sm-6">
            <div class="form-group">
              <input type="text" name="takenby" value="{{$product->taken_by}}" class="form-control takenby" id="takenby" placeholder="Enter taken by name">
              <label for="takenby">Taken by <span style="color:red;">*</span></label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
           <div class="form-group">
            <label for="name">Taken Date <span style="color:red;">*</span></label> <br>
            <input type="text" name="takendate" value="{{date('d-M-Y', strtotime($product->taken_date))}}" readonly="" id="takendate" class="form-control takendate" id="takendate" >
          </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
              <div class="col-6">
                 <div class="form-group">
                  <label for="brand">Product Quantity <span style="color:red;">*</span></label>
                  <input type="text" min="1" name="quantity" value="{{$product->prd_qty}}" class="form-control quantity" id="quantity" placeholder="Enter product quantity">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="brand">Quantity In (kg,pcs,etc) <span style="color:red;">*</span></label>
                  <input readonly="" type="text" name="unit" value="{{$product->prd_unit}}" class="form-control" id="unit">
                </div>
              </div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
           <div class="form-group">
            <label for="brand">Per Quantity Price <span style="color:red;">*</span></label>
            <input type="text" min="1" name="quantityprice" value="{{$product->prd_qty_price}}" class="form-control quantityprice" id="quantityprice" placeholder="Enter product quantity price">
          </div>
        </div>
        <div class="col-sm-6">
           <div class="form-group">
            <label for="brand">Total Price <span style="color:red;">*</span></label>
            <input type="text" name="totalprice" value="{{$product->prd_price}}" class="form-control totalprice" id="totalprice" readonly="">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
           <div class="form-group">
            <label for="brand">Grand Total <span style="color:red;">*</span></label>
            <input type="text" name="grandtotal" value="{{$product->prd_grand_price}}" class="form-control grandtotal" id="grandtotal" placeholder="Grand total">
          </div>
        </div>
        <div class="col-sm-6">
         <div class="form-group">
          <label for="brand">Requisition Dept <span style="color:red;">*</span></label>
          <select class="form-control reqdept" name="reqdept" id="reqdept">
            <option value="">select</option>
            @if($departments->count() > 0)
              @foreach($departments as $row)
                <option value="{{$row->dep_name}}"  <?php if($row->dep_name == $product->dept){echo 'selected';}?>>{{$row->dep_name}}</option>
              @endforeach
            @endif
          </select>
        </div>
      </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
           <div class="form-group">
            <label for="brand">Product Brand(Opt)</label>
            <input type="text" name="brand" class="form-control" value="{{$product->prd_brand}}" id="brand" placeholder="Enter product brand">
          </div>
        </div>
        <div class="col-sm-6">
         <div class="form-group">
          <label for="brand">Remarks (Opt)</label>
          <textarea rows="5" placeholder="Product remarks" class="form-control" name="remarks" id="remarks">{{$product->prd_remarks}}</textarea>
        </div>
      </div>
      </div>
     </div>
    <!-- /.card-body -->
    <div class="card-footer d-flex justify-content-end">
      <button type="button" class="btn btn-primary mx-2" id="editsubmit">Update Product</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
    </div>
  </form>
</div>
