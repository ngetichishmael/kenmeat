<div>

<div class="card">
            <h5 class="card-header"></h5>
            <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                <div class="col-md-4 user_role">
                    <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="search"></i></span>
                        </div>
                        <input wire:model="search" type="text" id="fname-icon" class="form-control" name="fname-icon" placeholder="Search" />
                    </div>
                </div>
                <div class="col-md-2 user_role">
                    <div class="form-group">
                        <label for="selectSmall">Per Page</label>
                        <select wire:model="perPage" class="form-control form-control-sm" id="selectSmall">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
       

             <div class="col-md-3">
                 <a href="{!! route('warehousing.create') !!}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Add Wirehouse</a>
                 <a href="{!! route('warehousing.import') !!}" class="btn btn-info btn-sm"><i class="fa fa-file-upload"></i> Import </a>
             </div>
             
            </div>
        </div>


   <!-- <div class="row mb-1">
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
   </div> -->
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
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle show-arrow " data-toggle="dropdown" style="background-color: #089000; color:white" >
                                        <i data-feather="settings"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{!! route('warehousing.show',['warehouse_code'=> $warehouse->warehouse_code]) !!}">
                                                <i data-feather="eye" class="mr-50"></i>
                                                <span>View Details</span>
                                            </a>
                                            <a class="dropdown-item" href="{!! route('warehousing.edit',$warehouse->warehouse_code) !!}">
                                                <i data-feather="eye" class="mr-50"></i>
                                                <span>Edit Details</span>
                                            </a>
                                            <a class="dropdown-item" href="{!! route('warehousing.products',$warehouse->warehouse_code) !!}">
                                                <i data-feather="eye" class="mr-50"></i>
                                                <span>View Inventory</span>
                                            </a>
                                            <a class="dropdown-item" href="{!! route('warehousing.assign',['warehouse_code'=> $warehouse->warehouse_code]) !!}">
                                                <i data-feather="eye" class="mr-50"></i>
                                                <span>Assign Manager</span>
                                            </a>
                              
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
