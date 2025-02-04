@php
  $product = $data['product'];
  $prdnames = $data['prdnames'];
  $department = $data['department'];
  $supplier = $data['supplier'];
@endphp

<div class="card card-primary">
  <div class="card-header modal-header">
    <h3 class="card-title">Update Purchase Product Details</h3>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="mt-2 mb-2">
    <div class="show-error"></div>
  </div>
  <!-- form start -->
  <form id="editform" method="post">
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
                  <option  value="{{$row->pk_no}}" <?php if($row->pk_no == $product->prd_id){echo 'selected';}?>>{{$row->prd_name}}</option>
                @endforeach    
              @endif
            </select>
          </div>
        </div>
        <input type="hidden" name="prdid" id="prdid" value="{{$product->pk_no}}">
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
                  <label for="brand">Product Quantity <span style="color:red;">*</span></label>
                  <input type="text" name="quantity" value="{{$product->prd_qty}}" class="form-control quantity" id="quantity" placeholder="Enter product quantity">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="brand">Quantity In (kg,pcs,etc) <span style="color:red;">*</span></label>
                  <input readonly="" type="text" name="unit" value="{{$product->prd_unit}}" class="form-control unit" id="unit">
                </div>
              </div>
            </div>
        </div>
        <div class="col-sm-6">
           <div class="form-group">
            <label for="brand">Per Quantity Price <span style="color:red;">*</span></label>
            <input type="text" name="quantityprice" value="{{$product->prd_qty_price}}" class="form-control quantityprice" id="quantityprice" placeholder="Enter product quantity price">
            <span id="showmsg"></span>
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-sm-6">
           <div class="form-group">
            <label for="brand">Total Price <span style="color:red;">*</span></label>
            <input type="text" name="totalprice" value="{{$product->prd_price}}" class="form-control" id="totalprice" readonly="">
          </div>
        </div>
        <div class="col-sm-6">
           <div class="form-group">
            <label for="brand">Grand Total <span style="color:red;">*</span></label>
            <input type="text"  name="grandtotal" value="{{$product->prd_grand_price}}" class="form-control" id="grandtotal" placeholder="Grand total">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
         <div class="form-group">
          <label for="brand">Requisition Dept <span style="color:red;">*</span></label>
          <select class="form-control" name="reqdept" id="reqdept">
            <option value="">select</option>
            @if($department->count() > 0)
              @foreach($department as $row)
                <option value="{{$row->dep_name}}"  <?php if($row->dep_name == $product->prd_req_dep){echo 'selected';}?>>{{$row->dep_name}}</option>
              @endforeach
            @endif
          </select>
        </div>
      </div>
      <div class="col-sm-6">
         <div class="form-group">
          <label for="brand">Supplier <span style="color:red;">*</span></label>
          <select class="form-control" name="supplier" id="supplier">
            <option value="">select</option>
            @if($supplier->count() > 0)
              @foreach($supplier as $row)
                <option value="{{$row->supplier_name}}" <?php if($row->supplier_name == $product->supplier){echo 'selected';}?> >{{$row->supplier_name}}</option>
              @endforeach
            @endif
          </select>
        </div>
      </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
           <div class="form-group">
            <label for="expirydate">Expiry Date</label>
            <input type="text" name="expirydate" readonly="" value="@if($product->expiry_date){date('d-M-Y', strtotime($product->expiry_date))} @endif"  class="form-control" id="expirydate" >
          </div>
        </div>
        <div class="col-sm-6">
           <div class="form-group">
            <label for="expiryalert">Expiry Alert Date</label>
            <input type="text" readonly="" name="expiryalert" value="@if($product->date_alert){date('d-M-Y', strtotime($product->date_alert))} @endif" class="form-control" id="expiryalert" >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
           <div class="form-group">
            <label for="brand">Product Brand(Opt)</label>
            <input type="text" name="brand" class="form-control" value="{{$product->prd_brand}}" id="brand" >
          </div>
        </div>
        <div class="col-sm-6">
           <div class="form-group">
            <label for="brand">Purchase From(Opt)</label>
          <input type="text" name="purchasefrom" class="form-control" value="{{$product->prd_purchase_from}}" id="purchasefrom">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
        <label for="brand">Created At</label>
        <input type="text" class="form-control" readonly="" value="{{date('d-M-y', strtotime($product->created_at))}}">
      </div>
      <div class="col-sm-6">
         <div class="form-group">
          <label for="brand">Remarks (Opt)</label>
          <textarea rows="5" class="form-control" name="remarks" id="remarks">{{$product->prd_details}}</textarea>
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
        


