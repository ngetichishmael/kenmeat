<div>
   <div>
      <div class="row mb-1">
         <div class="col-md-10">
            <label for="">Search</label>
            <input type="text" wire:model="search" class="form-control" placeholder="Enter delivery code, product name or status">
         </div>
         <div class="col-md-2">
            <label for="">Items Per</label>
            <select wire:model="perPage" class="form-control">`
               <option value="10" selected>10</option>
               <option value="25">25</option>
               <option value="50">50</option>
               <option value="100">100</option>
            </select>
         </div>
      </div>
      <div class="card card-default">
         <div class="card-body">
            <table class="table table-striped table-bordered">
               <thead>
               <th width="1%">#</th>
               <th>Product Name</th>
               <th>Delivery Code</th>
               <th>Total Amount</th>
               <th>Requested Quantity</th>
               <th>Allocated Quantity</th>
               <td>Sales Person</td>
               <td>Status</td>
               <td>Date</td>
{{--               <th width="15%">Action</th>--}}
               </thead>
               <tbody>
               @forelse ($allocations as $allocation)
                  @forelse ($allocation->DeliveryItems as $count =>$deliveryItem)
                     <tr>
                        {{-- Display the common allocation-related columns --}}
                        <td>{{ ++$count}}</td>
                        <td>{{ $deliveryItem->product_name }}</td>
                        <td>{{ $allocation->delivery_code }}</td>
                        <td>{{ $deliveryItem->total_amount }}</td>
                        <td>{{ $deliveryItem->requested_quantity }}</td>
                        <td>{{ $deliveryItem->allocated_quantity }}</td>
                        <td>{{ $allocation->User ?? '' }}</td>
                        <td>{{ $allocation->delivery_status }}</td>
                        <td>{{ $deliveryItem->created_at }}</td>
                     </tr>
                     @empty
                        <!-- Display a message for empty DeliveryItems -->
                        <tr>
                           <td colspan="10">No items found.</td>
                        </tr>
                     @endforelse
                     @empty
                        <!-- Display a message for empty allocations -->
                        <tr>
                           <td colspan="10">No allocations found.</td>
                        </tr>
                  @endforeach
               @endforeach
               </tbody>
            </table>
            {{ $allocations->links()  }}
         </div>
      </div>
   </div>
   @section('scripts')

   @endsection

</div>
