<div>
    <div class="card">
        <h5 class="card-header"></h5>
        <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
            <div class="col-md-3 user_role">
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
                    <label for="validationTooltip02">Start Date</label>
                    <input wire:model="start" name="start" type="date" class="form-control" id="validationTooltip02" required />
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="validationTooltip03">End Date</label>
                    <input wire:model="end" name="end" type="date" class="form-control" id="validationTooltip03" required />
                    @if ($end && $start && $end < $start)
                        <p class="text-danger">End date cannot be before the start date.</p>
                    @endif
                </div>
            </div>

            <div class="col-md-2">
{{--                <div class="btn-group">--}}
{{--                    --}}
{{--                    <button type="button" class="btn btn-icon btn-outline-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" wire:loading.attr="disabled" >--}}
{{--                        <img src="{{ asset('assets/img/excel.png') }}" alt="Export Excel" width="15" height="15">--}}
{{--                        Export--}}
{{--                    </button>--}}
{{--                    <div class="dropdown-menu">--}}
{{--                        <a class="dropdown-item" wire:click="export(null)">All</a>--}}
{{--                        <a class="dropdown-item" wire:click="export('today')">Today</a>--}}
{{--                        <a class="dropdown-item" wire:click="export('yesterday')">Yesterday</a>--}}
{{--                        <a class="dropdown-item" wire:click="export('this_week')">This Week</a>--}}
{{--                        <a class="dropdown-item" wire:click="export('this_month')">This Month</a>--}}
{{--                        <a class="dropdown-item" wire:click="export('this_year')">This Year</a>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--               <div class="btn-group">--}}
{{--                  <button type="button" class="btn btn-icon btn-outline-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" wire:loading.attr="disabled">--}}
{{--                     <img src="{{ asset('assets/img/excel.png') }}" alt="Export Excel" width="15" height="15">--}}
{{--                     Export--}}
{{--                  </button>--}}
{{--                  <div class="dropdown-menu">--}}
{{--                     <a class="dropdown-item" href="#" wire:click="setExportType('excel')">Excel</a>--}}
{{--                     <a class="dropdown-item" href="#" wire:click="setExportType('csv')">CSV</a>--}}
{{--                     <a class="dropdown-item" href="#" wire:click="setExportType('pdf')">PDF</a>--}}
{{--                  </div>--}}
{{--                  <div class="dropdown-submenu">--}}
{{--                     <a class="dropdown-item" href="#">Export Interval</a>--}}
{{--                     <div class="dropdown-menu">--}}
{{--                        <a class="dropdown-item" href="#" wire:click="export(null)">All</a>--}}
{{--                        <a class="dropdown-item" href="#" wire:click="export('today')">Today</a>--}}
{{--                        <a class="dropdown-item" href="#" wire:click="export('yesterday')">Yesterday</a>--}}
{{--                        <a class="dropdown-item" href="#" wire:click="export('this_week')">This Week</a>--}}
{{--                        <a class="dropdown-item" href="#" wire:click="export('this_month')">This Month</a>--}}
{{--                        <a class="dropdown-item" href="#" wire:click="export('this_year')">This Year</a>--}}
{{--                     </div>--}}
{{--                  </div>--}}
{{--               </div>--}}
               <!-- Button to open the modal -->
               <button type="button" class="btn btn-icon btn-outline-success" data-toggle="modal" data-target="#exportModal">
{{--                  <img src="{{ asset('assets/img/excel.png') }}" alt="Export Excel" width="15" height="15">--}}
                  Export
               </button>

               <!-- The modal -->
               <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true" wire:ignore>                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exportModalLabel">Select Export Type and Interval</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="form-group">
                              <label for="exportType">Export Type</label>
                              <select class="form-control" wire:model="selectedExportType" required>
                                 <option value="">Export As</option>
                                 <option value="excel">Excel</option>
                                 <option value="csv">CSV</option>
                                 <option value="pdf">PDF</option>
                              </select>
                           </div>
                           <div class="form-group">
                              <label for="interval">Export Interval</label>
                              <select class="form-control" wire:model="selectedInterval">
                                 <option value="">Select Interval</option>
                                 <option value="all">All</option>
                                 <option value="today">Today</option>
                                 <option value="yesterday">Yesterday</option>
                                 <option value="this_week">This Week</option>
                                 <option value="this_month">This Month</option>
                                 <option value="this_year">This Year</option>
                              </select>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           <button type="button" class="btn btn-primary" wire:click="export">Export</button>
                        </div>
                     </div>
                  </div>
               </div>

            </div>

        </div>
    </div>
    <div class="card card-default">
        <div class="card-body">
            <div class="pt-0 card-datatable">
                <table class="table table-striped table-bordered zero-configuration table-responsive">
                    <thead>
                        <th width="1%">#</th>
                        <th>Zone</th>
                        <th>User</th>
                        <th>Customer</th>
                        <th>Start/End Time</th>
                        <th>Duration</th>
                        <th>Date</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @forelse ($visits as $count => $visit)
                            <tr>
                                <td>{!! $count + 1 !!}</td>
                                <td>{!! $visit->User->Region->name ?? '' !!}</td>
                                <td>{!! $visit->User->name ?? '' !!}</td>
                                <td>{{ $visit->Customer->customer_name ?? '' }}</td>
                                @if ($visit->stop_time === null)
                                    <td>
                                        <div class="badge badge-pill badge-secondary">{{ \Carbon\Carbon::parse($visit->start_time)->format('h:i A') }}</div>
                                        <b> - </b>
                                        <span class="badge badge-pill badge-light-info mr-1">Visit Active</span>
                                    </td>
                                @else
                                    <td>
                                        <div class="badge badge-pill badge-secondary">{{ \Carbon\Carbon::parse($visit->start_time)->format('h:i A') }}</div>
                                        <b> - </b>
                                        <div class="badge badge-pill badge-secondary">{{ \Carbon\Carbon::parse($visit->stop_time)->format('h:i A') }}</div>
                                    </td>
                                @endif
                                <td>
                                    @if (isset($visit->stop_time))
                                        @php
                                            $start = \Carbon\Carbon::parse($visit->start_time);
                                            $stop = \Carbon\Carbon::parse($visit->stop_time);
                                            $durationInSeconds = $start->diffInSeconds($stop);
                                        @endphp

                                        @if ($durationInSeconds < 60)
                                            <div class="badge badge-pill badge-dark">{{ $durationInSeconds }} secs</div>
                                        @elseif ($durationInSeconds < 3600)
                                            <div class="badge badge-pill badge-dark">{{ floor($durationInSeconds / 60) }} mins</div>
                                        @else
                                            <div class="badge badge-pill badge-dark">{{ floor($durationInSeconds / 3600) }} hrs</div>
                                        @endif
                                    @else
                                        <span class="badge badge-pill badge-light-info mr-1">Visit Active</span>
                                    @endif
                                </td>
                                <td>{{ $visit->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('visit.details', ['id' => $visit->id]) }}" class="btn btn-sm"  style="background-color: #089000; color: white; font-size: 14px; padding: 5px 10px;">

                                        <i data-feather="eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; ">No visits found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-1">
                    {{ $visits->links() }}
                </div>
            </div>
        </div>
    </div>
   @push('scripts')
      <script>
         document.getElementById('submenuToggle').addEventListener('click', function() {
            var submenu = this.nextElementSibling;
            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
         });
      </script>
   @endpush
</div>

<br>
