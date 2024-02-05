@extends('layouts.app')
@push('custom_css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@php
  $prdnames = $data['productsname'];
  $department = $data['department'];
@endphp
@section('content')
    <!-- Main content -->
    <section class="content pt-2">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <div class="col-lg-12">
            @if(session('msg'))
            <div class="mt-2 mb-2">
                  <div class="alert alert-success">{{session('msg')}}</div>
              </div>
              @endif
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Product Sale</h3>
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
              <form id="quickForm" action="{{route('save-storage-product')}}" method="post">
                @csrf
                <div class="container-fluid">
                  <!-- Main row -->
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                          <!-- Purchase Date - Requisition Dept. - Supplier Name -->
                          <table id="productlisthead" class="table table-bordered table-striped" >
                            <thead>
                            <tr>
                              <th><label><b>Taken Date<span style="color:red;">*</span></b></label></th>
                              <!-- <th width="30%"><label><b>Requisition Dept.<span style="color:red;">*</span></b></label></th> -->
                              <th><label><b>Taken by<span style="color:red;">*</span></b></label></th>
                              <th width="7%"><label><b> # </b></label> </th>
                            </tr>
                            <tr>
                              <td>
                              <div class="form-group">
                                <input type="text" name="takendate" readonly="" value="{{old('takendate')}}" placeholder="Taken date" class="form-control" id="takendate">
                              </div>
                              </td>
                              <!-- <td>
                              <div class="form-group">
                                <select class="form-control" name="reqdept" id="reqdept">
                                  <option value="">select</option>
                                  @if($department->count() > 0)
                                    @foreach($department as $row)
                                      <option value="{{$row->dep_name}}">{{$row->dep_name}}</option>
                                    @endforeach
                                  @endif
                                </select>
                              </div>
                              </td> -->
                              <td>
                                <div class="form-group">
                                  <input type="text" name="takenby" class="form-control" value="{{old('takenby')}}" id="takenby" placeholder="Enter taken by name">
                                </div>
                              </td>
                              <td style="word-wrap: break-word;" >
                                <div class="form-group">
                                  <input  type="text"  class="form-control" name='rowCount' id="rowCount" placeholder="No. of products" maxlength="99" readonly=""/>
                                </div>
                              </td>
                            </tr>
                            <tr><div class="card card-primary"><td colspan ="4" bgcolor="007bff"></td></div></tr> 
                          </thead>
                          </table>

                            <!-- Product Info -->

                          <table id="productlist" class="table table-bordered table-striped auto-index" >
                            <thead>
                            <tr>
                              <th width="30%">Product Name <span style="color:red;">*</span></th>
                              <th width="10%">Unit</th>
                              <th>Quantity<span style="color:red;">*</span></th>
                              <th>Purchase Price<span style="color:red;">*</span></th>
                              <th>Sold Price<span style="color:red;">*</span></th>
                              <th>Total<span style="color:red;">*</span></th>
                              <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="body">
                            <tr id="mainRow">                             
                              <td>
                                <div class="form-group">
                                  <select class="js-example-basic-single form-control" name="name" id="name">
                                    <option value="">Select Product Name</option>
                                     @if(isset($prdnames) && count($prdnames) > 0)
                                      @foreach($prdnames as $row)
                                        <option value="{{$row->pk_no}}">{{$row->prd_name}}</option>
                                      @endforeach    
                                    @endif
                                  </select>
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input readonly="" type="text" name="unit" value="{{old('unit')}}" class="form-control" id="unit">
                                </div>
                              </td>
                              <td>
                                <div class="form-group">  
                              <input type="text" min="1" name="quantity" value="{{old('quantity')}}" class="form-control" id="quantity" placeholder="Quantity">
                            </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="text" name="grandtotal" value="{{old('grandtotal')}}" class="form-control" id="grandtotal" placeholder="Purchase Price"  readonly="">
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="text" min="1" name="quantityprice" value="{{old('quantityprice')}}" class="form-control" id="quantityprice" placeholder="Sold price">
                                  <span id="showmsg"></span>
                                </div>
                              </td>
                              
                              <td>
                                <div class="form-group">
                                  <input type="text" name="totalprice" value="{{old('totalprice')}}" class="form-control" id="totalprice">
                                </div>
                              </td>
                              <td width="5%"><button type="button" class="btn btn-danger" id="btn-remove"><i class="fa fa-times"></i></button></td>
                            </tr>
                            </tbody>
                          </table>
                          <div class="float-right">
                            <button type="button" id="add" class="btn btn-info"> <i class="fa fa-plus"></i> Add More</button>
                          </div>
                        </div>                        
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" id="saveproduct" class="btn btn-primary btn-block">Save Product</button>
                  <input type="hidden" id="delCount" name="delCount" class="form-control"/>
                  <input type="hidden" id="reqdept" name="reqdept" class="form-control" value="sold" />
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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function(){
    var count = 0;
    const names = [];
    const quantities = [];
    const prices = [];
    const tprices = [];
    const gtotalprices = [];
    const units = [];
    var delCount  = document.getElementById("delCount");
    var table = document.getElementById("productlist");
    var rows = table.getElementsByTagName("tr");
    var skip = '';   
    $("#add").click(function(){
      var inc = count+1
      names.push('name'+inc+'');
      quantities.push('quantity'+inc+'');
      prices.push('quantityprice'+inc+'');
      tprices.push('totalprice'+inc+'');
      gtotalprices.push('grandtotal'+inc+'');
      units.push('unit'+inc+'');
      var nameField ='<td> <div class="form-group"><select class="js-example-basic-single form-control" name="'+names[count]+'" id="'+names[count]+'"> <option value="">Select Product Name</option>   @if(isset($prdnames) && count($prdnames) > 0)   @foreach($prdnames as $row) <option value="{{$row->pk_no}}">{{$row->prd_name}}</option>  @endforeach    @endif </select></div></td>';
      var qtyField = '<td><div class="form-group"><input type="text"  name='+quantities[count]+' value="{{old('quantity')}}" class="form-control" id='+quantities[count]+' placeholder="Quantity"> </div></td>';
      var unitField = '<td><div class="form-group"><input readonly="" type="text" name="'+units[count]+'" value="{{old('unit')}}" class="form-control" id="'+units[count]+'"> </div></td>';
      var priceField = '<td><div class="form-group"><input type="text"  name= "'+prices[count]+'" value="{{old('quantityprice')}}" class="form-control quantityprice" id="'+prices[count]+'" placeholder="Purchase Price"> <span id="'+showmsg[count]+'"></span></div></td>';
      var totalpriceiField = '<td><div class="form-group"><input type="text" name="'+tprices[count]+'" value="{{old('totalprice')}}" class="form-control" id="'+tprices[count]+'" placeholder="total price" readonly=""></div></td>';
      var gtotalpriceField = '<td><div class="form-group"><input type="text" name="'+gtotalprices[count]+'" value="{{old('grandtotal')}}" class="form-control" id="'+gtotalprices[count]+'" placeholder="Grand total" readonly=""> </div></td>';
      var delbtn = '<td><button type="button" class="btn btn-danger btn-remove" id="'+count+'"><i class="fa fa-times"></i></button></td>';                    
      var row = '<tr id= "row'+count+'">'+nameField+unitField+qtyField+gtotalpriceField+priceField+totalpriceiField+delbtn+'</tr>';
      //  Add New Rows //
      $("#productlist").append(row);

      $('.js-example-basic-single').select2();      

      $(function(){
        $(document).on('change','#'+names[count]+'',function(){
          var nameid = $(this).val();
          $.ajax({
              url:"{{route('get-product-usage-unit')}}",
              type:"GET",
              data:{nameid:nameid},
              success:function(data){
                  $('#'+units[count-1]+'').val(data.unit);
                  $('#'+gtotalprices[count-1]+'').val(data.qtyprice);
              }
          });
        });
      });

      $(document).on('keyup',"#"+quantities[count]+"",function(){
        var nameid      = $('#'+names[count-1]+'').val();
        var quantityval = $("#"+quantities[count]+"").val();
        if (nameid == "") {
          alert('Product name can not be empty !!');
        }
        $.ajax({
            url:"{{route('get-product-qty') }}",
            type:"GET",
            data:{nameid:nameid,quantity:quantityval},
            success:function(data){
                  if (data.status == "over") {
                    alert('Sorry !! You have only -> '+data.qty+' products');
                    $("#saveprd").attr('disabled', true);
                  }else{
                    //alert('success');
                    $("#saveprd").attr('disabled', false);
                  }                
            }
        });
      });

      $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
      });

      //multiplication
      $(document).ready(function() {
          //this calculates values automatically 
          sum();
          $("#"+quantities[count]+","+"#"+prices[count]+"").on("keydown keyup", function() {
              sum();
          });
      });
      function sum() {
          var num1 = document.getElementById(quantities[count-1]).value;
          var num2 = document.getElementById(prices[count-1]).value;
          var result = num1 * num2;
          if (!isNaN(result)) {
              document.getElementById(tprices[count-1]).value = result;
              // document.getElementById(gtotalprices[count-1]).value = result;
          }
      }
      // Number of Products //        
      if (rows.length > 0){
        document.getElementById("rowCount").value = rows.length-1;
      }
      count++;
    });
    // Remove Row //
    $(document).on('click', '.btn-remove', function(){
      var button_id = $(this).attr("id"); 
      var row_id = '#row'+button_id+'';
      $(row_id).remove();
      var i = +button_id+1;
      skip += ""+i+"";
      delCount.value = skip;
      var table = document.getElementById("productlist");
      var rows = table.getElementsByTagName("tr");
      document.getElementById("rowCount").value = rows.length-1;
    });
  });
</script>

<script>
  $(document).ready(function(){
       $(document).on('click', '#btn-remove', function(){
          $('#mainRow').remove();
          var delCount  = document.getElementById("delCount");
          if(delCount.value>0){
            delCount.value += '0';
          }else{
            delCount.value = '0';
          }
          var table = document.getElementById("productlist");
          var rows = table.getElementsByTagName("tr");
          if (rows.length > 0){
            document.getElementById("rowCount").value = rows.length-1;
         }
      });
      var table = document.getElementById("productlist");
      var rows = table.getElementsByTagName("tr");
      document.getElementById("rowCount").value = rows.length-1;
    });
  
  $(function(){
    $(document).on('change','#name',function(){
      var nameid = $('#name').val();
      $.ajax({
          url:"{{route('get-product-usage-unit')}}",
          type:"GET",
          data:{nameid:nameid},
          success:function(data){
              $('#unit').val(data.unit);
              //$('#reqdept').val(data.dep);
              $('#grandtotal').val(data.qtyprice);
          }
      });
    });

    //quantity check
    $(document).on('keyup','#quantity',function(){
      var nameid      = $('#name').val();
      var quantityval = $('#quantity').val();
      if (nameid == "") {
        alert('Product name can not be empty !!');
      }
      $.ajax({
          url:"{{route('get-product-qty') }}",
          type:"GET",
          data:{nameid:nameid,quantity:quantityval},
          success:function(data){
                if (data.status == "over") {
                  alert('Sorry !! You have only -> '+data.qty+' products');
                  $("#saveprd").attr('disabled', true);
                }else{
                  //alert('success');
                  $("#saveprd").attr('disabled', false);
                }              
          }
      });
    });
  });
$(document).on("wheel", "input[type=number]", function (e) {
    $(this).blur();
});

//multiplication
$(document).ready(function() {
    //this calculates values automatically 
    sum();
    $("#quantity, #quantityprice").on("keydown keyup", function() {
        sum();
    });
});

function sum() {
    var num1 = document.getElementById('quantity').value;
    var num2 = document.getElementById('quantityprice').value;
    var result = num1 * num2;
    if (!isNaN(result)) {
        document.getElementById('totalprice').value = result;
        // document.getElementById('grandtotal').value = result;
    }
}
</script>

<script type="text/javascript">
  // In your Javascript (external .js resource or <script> tag)
  $(document).ready(function() {
      $('.js-example-basic-single').select2();
  });
</script>
<script type="text/javascript">
  $("#takendate").datepicker({ dateFormat: "dd-M-yy"});
  $(document).ready(function () {
    $("#quickForm").submit(function () {
        $("#saveprd").attr("disabled", true);
        return true;
    });
});
</script>
@endpush



<!-- 
                <div class="card-body">
                  <div class="row">
                      <div class="col-sm-6">
                       <div class="form-group">
                        <label for="name">Product Name <span style="color:red;">*</span></label> <br>
                        <select class="js-example-basic-single form-control" name="name" id="name">
                          <option value="">Select Product Name</option>
                           @if(isset($prdnames) && count($prdnames) > 0)
                            @foreach($prdnames as $row)
                              <option value="{{$row->pk_no}}">{{$row->prd_name}}</option>
                            @endforeach    
                          @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="brand">Taken by <span style="color:red;">*</span></label>
                        <input type="text" name="takenby" class="form-control" value="{{old('takenby')}}" id="takenby" placeholder="Enter taken by name">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="name">Taken Date <span style="color:red;">*</span></label> <br>
                        <input type="text" name="takendate" readonly="" value="{{old('takendate')}}" placeholder="Taken date" class="form-control" id="takendate" >
                      </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                          <div class="col-6">
                             <div class="form-group">
                              <label for="brand">Product Quantity <span style="color:red;">*</span></label>
                              <input type="text" min="1" name="quantity" value="{{old('quantity')}}" class="form-control" id="quantity" placeholder="Enter product quantity">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="brand">Quantity In (kg,pcs,etc) <span style="color:red;">*</span></label>
                              <input readonly="" type="text" name="unit" value="{{old('unit')}}" class="form-control" id="unit">
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Per Quantity Price <span style="color:red;">*</span></label>
                        <input type="text" min="1" name="quantityprice" value="{{old('quantityprice')}}" class="form-control" id="quantityprice" placeholder="Enter product quantity price">
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Total Price <span style="color:red;">*</span></label>
                        <input type="text" name="totalprice" value="{{old('totalprice')}}" class="form-control" id="totalprice" readonly="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                        <label for="brand">Grand Total <span style="color:red;">*</span></label>
                        <input type="text" name="grandtotal" value="{{old('grandtotal')}}" class="form-control" id="grandtotal" placeholder="Grand total">
                      </div>
                    </div>
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Requisition Dept. <span style="color:red;">*</span></label>
                      <select class="form-control" name="reqdept" id="reqdept">
                        <option value="">select</option>
                        @if($department->count() > 0)
                          @foreach($department as $row)
                            <option value="{{$row->dep_name}}">{{$row->dep_name}}</option>
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
                        <input type="text" name="brand" class="form-control" value="{{old('brand')}}" id="brand" placeholder="Enter product brand">
                      </div>
                    </div>
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label for="brand">Remarks (Opt)</label>
                      <textarea rows="5" placeholder="Product remarks" class="form-control" name="remarks" id="remarks">{{old('remarks')}}</textarea>
                    </div>
                  </div>
                  </div>
                 </div> 
               -->