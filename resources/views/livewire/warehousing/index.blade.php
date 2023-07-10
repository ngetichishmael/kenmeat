<div>
   <div class="row mb-1">
      <div class="col-md-10">
         <label for="">Search</label>
         <input type="text" wire:model="search" class="form-control" placeholder="Enter name">
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
         <table class="table table-striped table-bordered table-responsive" style="font-size: small">
            <thead>
            <th width="1%">#</th>
            <th>Name</th>
            <th>Region</th>
            <th>Sub Region</th>
            <th>Action</th>
            </thead>
            <tbody>
            @foreach($warehouses as $count=>$warehouse)
                  <tr>
                     <td>{!! $count+1 !!}</td>
                     <td>{!! $warehouse->name ?? '' !!}</td>
                     <td>{!! $warehouse->region->name ?? ''!!}</td>
                     <td>{!! $warehouse->subregion->name ?? '' !!}</td>
                     {{--                         <td>{!! $warehouse->manager->name ?? 'NA' !!}</td>--}}
{{--                     <td>{!! $warehouse->product_information_count !!}</td>--}}
                     <td>
                        <div class="dropdown" >
                           <button class="btn btn-md btn-primary dropdown-toggle mr-2" type="button" id="dropdownMenuButton" data-bs-trigger="click" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                              <i data-feather="settings"></i>
                           </button>
                           <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a href="{!! route('warehousing.show',['warehouse_code'=> $warehouse->warehouse_code]) !!}" type="button" class="dropdown-item btn btn-sm" style="color:#8f918f; font-weight: bold"><i data-feather="eye"></i>&nbsp; View Details</a>
                              <a href="{!! route('warehousing.edit',$warehouse->warehouse_code) !!}" type="button" class="dropdown-item btn btn-sm" style="color:#8f918f;font-weight: bold"><i data-feather="edit"></i> &nbsp;Edit Details</a>
                              <a href="{!! route('warehousing.products',$warehouse->warehouse_code) !!}" type="button" class="dropdown-item btn btn-sm" style="color: #8f918f; font-weight: bold"><i data-feather="eye"></i>&nbsp; View Inventory</a>
                              <a href="{!! route('warehousing.assign',['warehouse_code'=> $warehouse->warehouse_code]) !!}" type="button" class="dropdown-item btn btn-sm" style="color: #8f918f; font-weight: bold"><i data-feather="user"></i>&nbsp; Assign A Manager</a>
                           </div>
                        </div>
                     </td>
                  </tr>
            @endforeach
            </tbody>
         </table>
         {!! $warehouses->links() !!}
      </div>
   </div>
</div>
@section('scripts')

@endsection
