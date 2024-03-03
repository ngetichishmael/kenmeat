<div>
   <div class="card">
      <h5 class="card-header"></h5>
      <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
         <div class="col-md-3 user_role">
            <div class="input-group input-group-merge">
               <div class="input-group-prepend">
                  <span class="input-group-text"><i data-feather="search"></i>&nbsp;</span>
               </div>
               <input wire:model="search" type="text" id="fname-icon" class="form-control" name="fname-icon"
                      placeholder="Search" />
            </div>
         </div>
         <div class="col-md-1 user_role">
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
         <!-- <div class="col-md-2">
            <div class="form-group">
               <label for="validationTooltip01">Start Date</label>
               <input wire:model="fromDate" name="fromDate" type="date" class="form-control"
                      id="validationTooltip01" placeholder="YYYY-MM-DD HH:MM" required />
            </div>
         </div>
         <div class="col-md-2">
            <div class="form-group">
               <label for="validationTooltip01">End Date</label>
               <input wire:model="toDate" name="startDate" type="date" class="form-control"
                      id="validationTooltip01" placeholder="YYYY-MM-DD HH:MM" required />
            </div>
         </div> -->

      </div>
   </div>
   <div>
      <div class="tab-content mt-3">
         <table class="table table-striped table-bordered">
            <thead>
            <tr>
               <th>#</th>
               <th>Customer</th>
               <th>Sales Agent</th>
               <th>Quantity</th>
               <th>Date</th>
               <!-- <th>Action</th> -->
            </tr>
            </thead>
            <tbody>
            @foreach ($stockLevels as $key => $lift)
               <tr>
                  <td>{{ $key + 1 }}</td>
            
                  <td>{{ $lift->customer->customer_name ?? '' }}</td>
                  <td>{{ $lift->user->name ?? '' }}</td>
                  <td>{{ $lift->stock_level ??'' }}</td>

                  <td>{{ $lift->created_at }}</td>
                  <td>
                  <a href="{{ route('stock-level.show', $lift->id) }}" class="btn btn-sm"
                      style="color:white;background-color:rgb(202, 50, 50)">View</a>

                        </td>
               </tr>
            @endforeach
            </tbody>
         </table>
         <div class="mt-1">{{ $stockLevels->links() }}</div>
      </div>
   </div>
</div>
