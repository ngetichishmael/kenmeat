@extends('layouts.app')
{{-- page header --}}
@section('title', 'Restock Product')


{{-- content section --}}
@section('content')
    <!-- begin page-header -->
    <style>
       /* CSS styles */
       table {
          width: 100%;
          border-collapse: collapse;
       }

       th, td {
          padding: 8px;
          text-align: left;
          border-bottom: 1px solid #ddd;
       }

       .sku-field input {
          width: 100%;
          padding: 8px;
          box-sizing: border-box;
       }

       .sku-field .remove-sku {
          color: #fff;
          background-color: #24B263;
          border: none;
          padding: 8px 12px;
          cursor: pointer;
       }

       .sku-field .remove-sku:hover {
          background-color: #24B263;
       }
    </style>
    <h3 class="page-header"> Restock <b>{{$product_information->product_name ?? ''}}</b> Products </h3>
    <!-- end page-header -->
    <form class="needs-validation responsive mt-3 mb-3" action="{{ route('products.updatestock', [
        'id' => $id]) }}" method="POST"
          enctype="multipart/form-data" id="restock-form">
       @csrf
       <table id="sku-table responsive">
          <thead>
          <tr>
             <th>Product SKU Code</th>
             <th>Current Quantity</th>
             <th>Restock Quantity </th>
          </tr>
          </thead>
          <tbody id="sku-fields">
          <tr class="sku-field ">
             <td><input for="fp-date-time" type="text" class="form-control col-lg-1 col-md-3" name="sku_codes[]" value="{{$product_information->sku_code}}"  readonly required></td>
             <td><input for="fp-date-time" type="number" class="form-control col-lg-1 col-md-3" value="{{$product_information->inventory->current_stock}}" readonly ></td>
             <td><input for="fp-date-time" type="number" class="form-control col-lg-1 col-md-3" name="quantities[]" required></td>
{{--             <td><button for="fp-date-time"  type="button" class="remove-sku form-control btn btn-sm btn-outline-danger" style="width: fit-content">--}}
{{--                   <i data-feather="trash-2" class="mr-25"></i><span> &nbsp;Delete</span></button>--}}
{{--             </td>--}}
          </tr>
          </tbody>
       </table>
{{--       <div class="row">--}}
{{--          <div class="col-md-12 m-2">--}}
{{--             <button wire:click.prevent="addTargets" type="button" id="add-sku" class="btn btn-outline-primary">--}}
{{--                <i data-feather="plus" class="mr-25 font-medium bold"></i>--}}
{{--                <span>Add New Row</span>--}}
{{--             </button>--}}
{{--          </div>--}}
{{--       </div>--}}
       <div class=" col-l-1 mt-3 pe-4 text-right">
          <button wire:click.prevent="submit()" type="submit"
                  class="btn btn-primary data-submit w-10">Submit</button>
       </div>
    </form>

    <script>
       // Add SKU field
       document.getElementById('add-sku').addEventListener('click', function() {
          var skuFields = document.getElementById('sku-fields');
          var newField = document.createElement('tr');
          newField.classList.add('sku-field');
          newField.innerHTML = `
            <td><input for="fp-date-time" type="text" class="form-control col-lg-3 col-md-6" name="sku_codes[]" required></td>
             <td><input for="fp-date-time" type="number" class="form-control col-lg-1 col-md-3" name="quantities[]" required></td>
             <td><button for="fp-date-time"  type="button" class="remove-sku form-control btn btn-sm btn-outline-danger" style="width: fit-content">
                    <i class="fas fa-trash mr-25"></i><span> &nbsp;Delete</span></button>
             </td>
        `;
          skuFields.appendChild(newField);
       });

       // Remove SKU field
       document.addEventListener('click', function(event) {
          if (event.target.classList.contains('remove-sku')) {
             var skuField = event.target.closest('.sku-field');
             skuField.parentNode.removeChild(skuField);
          }
       });
    </script>
@endsection
{{-- page scripts --}}
@section('scripts')
@endsection
