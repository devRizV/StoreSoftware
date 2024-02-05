@extends('layouts.app')
@push('custom_css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@php
  $prdnames   = $data['productsname'];
  $department = $data['department'];
  $supplier = $data['supplier'];
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
                <h3 class="card-title">Product Purchase</h3>
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
              <form id="quickForm" action="{{route('save-product')}}" method="post">
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
                                <th width="48.2%"><label><b>Purchase Date<span style="color:red;">*</span></b></label></th>
                                <!-- <th width="30%"><label><b>Requisition Dept.<span style="color:red;">*</span></b></label></th> -->
                                <th width="44.8"><label><b>Supplier Name<span style="color:red;">*</span></b></label></th> 
                                <th width="7%"><label><b> # </b></label> </th>
                              </tr>
                              <tr>
                                <td>
                                <div class="form-group">
                                    <input type="text" name="purchasedate" placeholder="date"  class="form-control" id="purchasedate" readonly="" >
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
                                <select class="form-control" name="supplier" id="supplier">
                                  <option value="">select</option>
                                  @if($supplier->count() > 0)
                                    @foreach($supplier as $row)
                                      <option value="{{$row->supplier_name}}">{{$row->supplier_name}}</option>
                                    @endforeach
                                  @endif
                                </select></div>
                              </td>                              
                              <td style="word-wrap: break-word;" >
                                <div class="form-group">
                                  <input  type="text"  class="form-control" name='rowCount' id="rowCount" placeholder="No. of products" maxlength="2" readonly=""/>
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <div class="card card-primary">
                                <td bgcolor="007bff">
                                </td>
                                <td  bgcolor="007bff">
                                </td>
                                <td  bgcolor="007bff">
                                </td>
                              </div>
                            </tr> 
                          </thead>
                          </table>

                            <!-- Product Info -->

                          <table id="productlist" class="table table-bordered table-striped auto-index" >
                            <thead>
                            <tr>
                              <th width="30%">Product Name <span style="color:red;">*</span></th>
                              <th width="8.8%">Unit</th>
                              <th width="8.8%">Quantity<span style="color:red;">*</span></th>
                              <th>Purchase Price<span style="color:red;">*</span></th>
                              <th>Total Price<span style="color:red;">*</span></th>
                              <!-- <th>G. Total<span style="color:red;">*</span></th> -->
                              <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="body">
                            <tr id="mainRow">                             
                              <td>
                                <div class="form-group">
                                  <select class="js-example-basic-single form-control" name="name" id="name">
                                    <option value="">Product Name</option>
                                     @if(isset($prdnames) && count($prdnames) > 0)
                                      @foreach($prdnames as $row)
                                        @if(request()->get('name'))
                                          <option <?php if(request()->get('name') == $row->prd_name) echo 'selected';  ?> value="{{$row->pk_no}}">{{$row->prd_name}}</option>
                                        @else
                                          <option value="{{$row->pk_no}}">{{$row->prd_name}}</option>
                                        @endif
                                      @endforeach    
                                    @endif
                                  </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                  @if(request()->get('unit'))
                                      <input readonly="" type="text" name="unit" value="{{request()->get('unit')}}" class="form-control" id="unit">
                                  @else
                                  <input readonly="" type="text" name="unit" value="{{old('unit')}}" class="form-control" id="unit">
                                  @endif
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                              <input type="text"  name="quantity" value="{{old('quantity')}}" class="form-control" id="quantity" placeholder="Quantity">
                            </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="text"  name="quantityprice" value="{{old('quantityprice')}}" class="form-control quantityprice" id="quantityprice" placeholder="unit price">
                                  <span id="showmsg"></span>
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="text" name="totalprice" value="{{old('totalprice')}}" class="form-control" id="totalprice" readonly="">
                                </div>
                              </td>
                              <!-- <td>
                                <div class="form-group">
                                  <input type="text" name="grandtotal" value="{{old('grandtotal')}}" class="form-control" id="grandtotal" placeholder="Grand total" readonly="">
                                </div>
                              </td> -->
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
                  <input type="hidden" id="grandtotal" name="grandtotal" class="form-control" />
                  <input type="hidden" id="reqdept" name="reqdept" class="form-control" value="purchase" />
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
    const showmsg = [];
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
        showmsg.push('showmsg'+inc+'');
        var nameField ='<td> <div class="form-group"><select class="js-example-basic-single form-control" name='+names[count]+' id='+names[count]+'><option value="">Product Name</option>         @if(isset($prdnames) && count($prdnames) > 0)     @foreach($prdnames as $row)      @if(request()->get('name'))     <option <?php if(request()->get('name') == $row->prd_name) echo 'selected';  ?> value="{{$row->pk_no}}">{{$row->prd_name}}</option>        @else <option value="{{$row->pk_no}}">{{$row->prd_name}}</option>     @endif     @endforeach      @endif</select></div></td>';
        var qtyField = '<td><div class="form-group"><input type="text"  name='+quantities[count]+' value="{{old('quantity')}}" class="form-control" id='+quantities[count]+' placeholder="Quantity"> </div></td>';
        var unitField = '<td><div class="form-group"> @if(request()->get('unit')) <input readonly="" type="text" name="'+units[count]+'" value="{{request()->get('unit')}}" class="form-control" id="'+units[count]+'"> @else <input readonly="" type="text" name="'+units[count]+'" value="{{old('unit')}}" class="form-control" id="'+units[count]+'"> @endif </div> </td>';
        var priceField = '<td><div class="form-group"><input type="text"  name= "'+prices[count]+'" value="{{old('quantityprice')}}" class="form-control quantityprice" id="'+prices[count]+'" placeholder="Purchase price"> <span id="'+showmsg[count]+'"></span></div></td>';
        var totalpriceiField = '<td><div class="form-group"><input type="text" name="'+tprices[count]+'" value="{{old('totalprice')}}" class="form-control" id="'+tprices[count]+'" placeholder="total price" readonly=""></div></td>';
        // var gtotalpriceField = '<td><div class="form-group"><input type="text" name="'+gtotalprices[count]+'" value="{{old('grandtotal')}}" class="form-control" id="'+gtotalprices[count]+'" placeholder="Grand total" readonly=""> </div></td>';
        var delbtn = '<td><button type="button" class="btn btn-danger btn-remove" id="'+count+'"><i class="fa fa-times"></i></button></td>';
        var row = '<tr id= "row'+count+'">'+nameField+unitField+qtyField+priceField+totalpriceiField+delbtn+'</tr>';        
        // Append New Rows //
        $('#productlist').append(row);

        $(function(){
            $(document).on('change','#'+names[count]+'', function(){
              var nameid = $(this).val();
              $.ajax({
                  url:"{{route('get-product-unit')}}",
                  type:"GET",
                  data:{nameid:nameid},
                  success:function(data){
                      $('#'+units[count-1]+'').val(data);
                  }
              });
            });
        });
        $(document).on('keyup','#'+prices[count]+'',function(){
            var price   = $(this).val();
            var productId = $('#'+names[count-1]).val();
            if (productId == ""){
              alert('Product Name can not be empty !!')
            }else{
              $('#'+showmsg[count-1]+'').text('Processing...');
              $.ajax({
                url:"{{route('get-product-price')}}",
                type:"GET",
                data:{prdprice:price, productId:productId},
                success:function(data){
                    console.log(data);                        
                    if (data.status == 'error') {                         
                        $('#'+showmsg[count-1]+'').html('<span style="color:#ff0000;">Previous price-></span><br>'+data.price);
                    }else if(data.status == 'success'){
                        $('#'+showmsg[count-1]+'').html('<span style="color:#008000">Both price are same</span>');
                    }else if(data.status == 'fentry'){
                           $('#'+showmsg[count-1]+'').html('<span style="color:#008000">This is first entry</span>');
                    }else{
                           console.log('something wrong!!');
                    }
                }
              });
            }
          });
          //  this calculates values automatically  //            
          $("#"+quantities[count]+","+"#"+prices[count]+"").on("keydown keyup", function() {
              var num1 = document.getElementById(quantities[count-1]).value;
              var num2 = document.getElementById(prices[count-1]).value;
              var result = num1 * num2;
              if (!isNaN(result)) {
                document.getElementById(tprices[count-1]).value = result;
                // document.getElementById(gtotalprices[count-1]).value = result;
              }
            });
          // select2 //
        $('.js-example-basic-single').select2();
        // Number of Products //        
        if (rows.length > 0){
          document.getElementById("rowCount").value = rows.length-1;
        }
        count++;
      });
      // Remove row //
      $(document).on('click', '.btn-remove', function(){
        var button_id = $(this).attr("id"); 
        var row_id = '#row'+button_id+'';
        $(row_id).remove();
        var i = +button_id+1;
        skip += ""+i+"";
        delCount.value = skip;;
        var table = document.getElementById("productlist");
        var rows = table.getElementsByTagName("tr");
        document.getElementById("rowCount").value = rows.length-1;
      });
    });
</script>


<script type="text/javascript">
  // In your Javascript (external .js resource or <script> tag)
  $(document).ready(function() {
      $('.js-example-basic-single').select2();
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
    $(document).on('keyup','#quantityprice',function(){
          var price     = $(this).val();
          var productId = $('#name').val();
          if (productId == "") {
            alert('Product Name can not be empty !!');
          }else{
            $('#showmsg').text('Processing...');
            $.ajax({
                url:"{{route('get-product-price') }}",
                type:"GET",
                data:{prdprice:price, productId:productId},
                success:function(data){
                    console.log(data);
                    if (data.status == 'error') {
                      $('#showmsg').html('<span style="color:#ff0000">Previous price was -></span>'+data.price);
                    }else if(data.status == 'success'){
                       $('#showmsg').html('<span style="color:#008000">Both price are same</span>');
                    }else if(data.status == 'fentry'){
                       $('#showmsg').html('<span style="color:#008000">This is first entry</span>');
                    }else{
                       console.log('something wrong !!');
                  }
                }
            });
          }
        });
      // Auto unit input based on Product name
    $(function(){
      $(document).on('change','#name', function(){
        var nameid = $('#name').val();
        $.ajax({
            url:"{{route('get-product-unit')}}",
            type:"GET",
            data:{nameid:nameid},
            success:function(data){
                $('#unit').val(data);
            }
        });
      });
    });
    $(document).on('keyup','#quantityprice',function(){
      var price     = $(this).val();
      var productId = $('#name').val();
      if (productId == "") {
        alert('Product Name can not be empty !!');
      }else{
        $('#showmsg').text('Processing...');
        $.ajax({
            url:"{{route('get-product-price') }}",
            type:"GET",
            data:{prdprice:price, productId:productId},
            success:function(data){
                console.log(data);
                if (data.status == 'error') {
                  $('#showmsg').html('<span style="color:#ff0000">Previous price was -></span>'+data.price);
                }else if(data.status == 'success'){
                   $('#showmsg').html('<span style="color:#008000">Both price are same</span>');
                }else if(data.status == 'fentry'){
                   $('#showmsg').html('<span style="color:#008000">This is first entry</span>');
                }else{
                   console.log('something wrong !!');
                }
            }
        });
      }
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
        document.getElementById('grandtotal').value = result;
    }
}
</script>
<script type="text/javascript">
  $("#purchasedate").datepicker({ dateFormat: "dd-M-yy"});
  //$("#purchasedate").datepicker({ dateFormat: "dd-mm-yy"});
  $("#expirydate").datepicker({ dateFormat: "dd-M-yy",changeYear:true, yearRange: "2021:2050"});
  $("#expiryalert").datepicker({ dateFormat: "dd-M-yy",changeYear:true, yearRange: "2021:2050"});
  $(document).ready(function () {
    $("#quickForm").submit(function () {
        $("#saveproduct").attr("disabled", true);
        return true;
    });
});
</script>


@endpush
