<tr>
  <td class="w-full">
    {{-- Product Name Entry --}}
    <select class="form-control product-name" name="name[]">
      <option value="">Select Product Name</option>
      @if(isset($prdnames) && count($prdnames) > 0)
        @foreach($prdnames as $row)
          <option value="{{$row->pk_no}}">{{$row->prd_name}}</option>
        @endforeach
      @endif
    </select>
  </td>
  <td>
    {{-- Product Quantity --}}
    <input type="text" min="1" name="quantity[]" value="{{old('quantity[]')}}" class="form-control quantity" placeholder="Enter quantity">
  </td>
  <td>
    {{-- Product Unit --}}
    <input readonly="" type="text" name="unit[]" value="{{old('unit[]')}}" class="form-control unit" placeholder="Product Unit">
  </td>
  <td>
    {{-- Product Price --}}
    <input type="text" min="1" name="quantityprice[]" value="{{old('quantityprice[]')}}" class="form-control quantityprice" id="quantityprice" placeholder="Enter price">
    <label id="priceMsg" for="priceMsg" class="small priceMsg"></label>
    {{-- <input type="hidden" name="grandtotal" value="" class="grandtotal"> --}}
  </td>
  <td>
    {{-- Total Price --}}
    <input type="text" name="totalprice[]" value="{{old('totalprice[]')}}" class="form-control totalprice" readonly="">
  </td>
  <td>
    {{-- Action --}}
    <button type="button" class="btn btn-danger deleteRow"><i for="deleteRow" class="fas fa-times"></i></button>
  </td>
</tr>