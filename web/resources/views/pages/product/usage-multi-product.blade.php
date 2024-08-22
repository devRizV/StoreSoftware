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
          <div class="col-sm-10">
            @if(session('msg'))
            <div class="mt-2 mb-2">
                  <div class="alert alert-success">{{session('msg')}}</div>
              </div>
              @endif
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Usage Product</h3>
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
              <form id="quickForm" action="{{route('save-multiple-storage-product')}}" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="row col-sm-12">
                      <div class="col-sm-4 form-group">
                        <label for="name">Taken Date <span style="color:red;">*</span></label> <br>
                        <input type="text" name="takendate" value="{{old('takendate')}}" placeholder="Taken date" class="form-control" id="takendate" >
                      </div>
                      <div class="col-sm-3 form-group">
                        <label for="brand">Taken by <span style="color:red;">*</span></label>
                        <input type="text" name="takenby" class="form-control" value="{{old('takenby')}}" id="takenby" placeholder="Enter taken by name">
                      </div>
                      <div class="col-sm-3 form-group">
                         <label for="brand">Requisition Dept. <span style="color:red;">*</span></label>
                          <select class="form-control" name="reqdept" id="reqdept">
                            <option value="">select</option>
                            @if($department->count() > 0)
                              {{$sl = 1}}
                              @foreach($department as $row)
                                <option value="{{$row->dep_name}}">{{$sl+=1}}. {{$row->dep_name}}</option>
                              @endforeach
                            @endif
                          </select>
                      </div>
                      <div class="col-sm-2 form-group">
                        <label for="">No. of Entries <span style="color: red">*</span></label><br>
                        <span name="entries" class="form-control" id="entryCount">0</span>
                      </div>                    
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <table class="table table-bordered product-table" id="product-table">
                        <thead>
                          <tr>
                            <th><label for="name[]">Product Name <span style="color: red">*</span></label></th>
                            <th><label for="quantity[]">Quantity <span style="color: red">*</span></label></th>
                            <th><label for="unit[]">Unit <span style="color: red">*</span></label></th>
                            <th><label for="quantityprice[]">Product Price <span style="color: red">*</span></label></th>
                            <th><label for="totalprice[]">Total Price <span style="color: red">*</span></label></th>
                            <th><label for="Action">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @include('pages.product.usage-add-row')
                          <tr>
                            <td colspan="1">
                              <button type="button" class="btn btn-secondary" id="add-row">Add More</button>
                            </td>
                            <td colspan="5">
                              <span for="showMsg" id="showMsg" class="text-success large"></span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                 </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="saveprd">Save Product</button>
                 </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
      $(document).ready(function () {
        $('.product-name').select2();
        $("#takendate").datepicker({ dateFormat: "dd-M-yy"});
        $('#reqdept').select2();
        getEntryNumber();
        $(document).on('click', '#add-row', function (e) {
          e.preventDefault();
          const $this = $(this);
          let row = `@include('pages.product.usage-add-row')`;
          $this.closest('tr').before(row);
          $('.product-name').select2();
          getEntryNumber();
          getUnit();
          checkStock();
          getTotalPrice();
        });
        // Delete Row
        deleteRow();
        // Get Unit AutoMatically
        getUnit();
        // Check for Product stock
        checkStock();
        // Automatically calculate total price
        getTotalPrice();

        $("#quickForm").submit(function () {
          $("#saveprd").attr("disabled", true);
          console.log($(this).serialize());
          
          return true;
        });

      });

      // Funciton
      function getTotalPrice() {
        $(document).on('keyup keydown', '.quantity, .quantityprice', function () {
          const $this = $(this);
          const $row  = $this.closest('tr');
          const productId = $row.find('.product-name');
          if (productId) {
            var quantity = parseFloat($row.find('.quantity').val());
            var quantityprice = parseFloat($row.find('.quantityprice').val());
            var totalprice = (quantity*quantityprice ? quantity*quantityprice : 0.000) ;
            $row.find('.totalprice').val(totalprice.toFixed(3));
          } else {
            alert('Product name can not be empty');
          }
        });
      }

      function deleteRow() {
        $(document).on('click', '.deleteRow', function (e) {
          e.preventDefault();
          let isConfirmed = confirm('Do you want to remove this product?');
          if (isConfirmed) {
            const $this = $(this);
            const $row  = $this.closest('tr');
            $row.remove();
            $("#showMsg").empty().text('Row was deleted!!!').fadeOut(3000).empty();
            getEntryNumber();
          } else {
            $("#showMsg").empty().text('Row was was not deleted!').fadeOut(3000).empty();
          }
        });
      }

      function checkStock() {
        $(document).on('keyup','.quantity',function(){
          const $this = $(this);
          const $row = $(this).closest('tr');
          const nameid      = $row.find('.product-name').val();
          var quantityval = $this.val();
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
                      $this.val('');
                      $row.find('.totalprice').val('');
                      $("#saveprd").attr('disabled', true);
                    }else{
                      $("#saveprd").attr('disabled', false);
                    }
              }
          });
        });
      }

      function getEntryNumber() {
        var num = $('.product-table tbody tr').length-1;
        $('#entryCount').text(num);
      }

      function checkDuplicate(check) {
        var isDuplicate = false;
        var productName = check.val();
        $('.product-name').not(check).each(function (index, element) {
          if ($(this).val() === productName) {
            isDuplicate = true;
          }
        });
        return isDuplicate;
      }

      function getUnit() {
        $(document).on('change', '.product-name', function () {
          const $this = $(this);
          const $row = $this.closest('tr');
          const nameid = $this.val();

          if(checkDuplicate($this)) {
            $row.find('.showErrorMsg').text('Pruduct already entered!!!'); // Show error msg 
            $this.val();
            $row.find('.unit').val('');
            $row.find('.quantityprice').val('');
          } else {
            $row.find('.showErrorMsg').text(''); // Empty error msg
            $.ajax({
              type: "GET",
              url: "{{ route('get-product-usage-unit') }}",
              data: {
                nameid:nameid,
              },
              dataType: "json",
              success: function (data) {
                $row.find('.stock').text(`Stock available ${data.stock} ${data.unit}`);
                $row.find('.unit').val(data.unit);
                $row.find('.quantityprice').val(data.qtyprice);
              }
            });
          }
        });
      }
    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });
</script>
<script type="text/javascript">

</script>
@endpush
