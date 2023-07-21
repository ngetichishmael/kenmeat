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
                <div class="col-md-2">
           <div class="form-group">
               <label for="validationTooltip01">Start Date</label>
               <input wire:model="start" name="startDate" type="date" class="form-control" id="validationTooltip01"
                   placeholder="YYYY-MM-DD HH:MM" required />
           </div>
       </div>
       <div class="col-md-2">
           <div class="form-group">
               <label for="validationTooltip01">End Date</label>
               <input wire:model="end" name="startDate" type="date" class="form-control" id="validationTooltip01"
                   placeholder="YYYY-MM-DD HH:MM" required />
           </div>
       </div>
             
            </div>
        </div>



   <!-- <div class="pt-0 pb-2 d-flex justify-content-end align-items-center mx-50 row">
       <div class="col-md-4">
           <div class="form-group">
               <label for="validationTooltip01">Start Date</label>
               <input wire:model="start" name="startDate" type="date" class="form-control" id="validationTooltip01"
                   placeholder="YYYY-MM-DD HH:MM" required />
           </div>
       </div>
       <div class="col-md-4">
           <div class="form-group">
               <label for="validationTooltip01">End Date</label>
               <input wire:model="end" name="startDate" type="date" class="form-control" id="validationTooltip01"
                   placeholder="YYYY-MM-DD HH:MM" required />
           </div>
       </div>

       <div class="col-md-2">
           <button type="button" class="btn btn-icon btn-outline-success" wire:click="export"
               wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="Export Excel">
              Export
           </button>
       </div>
   </div>
   <div class="mb-1 row">
       <div class="col-md-10">
           <label for="">Search</label>
           <input type="text" wire:model="search" class="form-control" placeholder="Search by User or Region">
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
            <div class="pt-0 card-datatable">
            <table class="table table-striped table-bordered zero-configuration table-responsive">
    <thead>
        <th width="1%">#</th>
        <th>Sales Associate</th>
        <th>Visit Count</th>
       
        <th>Total Trading Time</th>
        <th>View</th>
    </thead>
            <tbody>
                @if ($visits->count() > 0)
                    @foreach ($visits as $count => $visit)
                        <tr>
                            <td>{!! $count + 1 !!}</td>
                            <td>{!! $visit->name !!}</td>
                            <td>{!! $visit->visit_count !!} </td>
                            <td>{{ $visit->last_visit_time }}</td>
                          
                            <td>
                                <a href="{{ route('UsersVisits.show', ['user' => $visit->user_code]) }}"
                                    class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                @else
               
                            @if ($start == null && $end == null)  
                                <tr>
                                    <td colspan="8" style="text-align: center; "> No visits today.</td>
                                </tr>
                            @else
                                 <tr>
                                    <td colspan="8" style="text-align: center; ">  No visits found.</td>
                                </tr>
                               
                            @endif
                     
                @endif
            </tbody>
        </table>


               <div class="mt-1">
                   {{ $visits->links() }}
               </div>
           </div>
       </div>
   </div>
</div>
