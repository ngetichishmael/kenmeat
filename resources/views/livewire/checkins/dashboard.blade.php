@php
    use Illuminate\Support\Str;
@endphp
<div>
<div class="card">
            <h5 class="card-header"></h5>
            <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                <div class="col-md-3 user_role">
                    <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="search"></i></span>
                        </div>
                        <input wire:model.debounce.300ms="search" type="text" id="fname-icon" class="form-control" name="fname-icon" placeholder="Search" />
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
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="validationTooltip01">Start Date</label>
                        <input wire:model="startDate" name="startDate" type="date" class="form-control" id="validationTooltip01"
                            placeholder="YYYY-MM-DD HH:MM" required />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="validationTooltip01">End Date</label>
                        <input wire:model="endDate" name="startDate" type="date" class="form-control" id="validationTooltip01"
                            placeholder="YYYY-MM-DD HH:MM" required />
                    </div>
                </div>


       <!-- <div class="col-md-2">
            <button type="button" class="btn btn-icon btn-outline-success" wire:click="export"
                wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="Export Excel">
                <img src="{{ asset('assets/img/excel.png') }}"alt="Export Excel" width="25" height="15"
                    data-toggle="tooltip" data-placement="top" title="Export Excel">Export
            </button>
        </div> -->
             
            </div>
        </div>
<!-- 
      <div class="pt-0 pb-2 d-flex justify-content-end align-items-center mx-50 row">
         <div class="col-md-2">
            <div>
               <label for="">Filter By User: </label>
               <select wire:model="userCode" class="form-control">
                        <option value="">Select User</option>
                  
               </select>
            </div>
         </div>
      </div> -->

      


      <div class="card card-default">
            <div class="card-body">
                <table class="table table-striped table-bordered" style="font-size: small">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>User Type</th>
                            <th>Date</th>
                            <th>Time</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checkins as $key => $checkin)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $checkin->user->name ?? 'NA' }}</td>
                                <td>{{ $checkin->user->account_type ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($checkin->time)->format('Y-m-d') }}</td> 
                                <td>{{ \Carbon\Carbon::parse($checkin->time)->format('g:i A') }}</td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;"> No Check-Ins Found </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-1">{{ $checkins->links() }}</div>
            </div>
        </div>



</div>
<br>