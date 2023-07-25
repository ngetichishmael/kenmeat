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
                    </thead>
                    <tbody>
                        @foreach ($visits as $count => $visit)
                            <td>{!! $count + 1 !!}</td>
                            <td>{!! $visit->User->Region->name??'' !!}</td>
                            <td>{!! $visit->User->name??'' !!} </td>
                            <td> {{ $visit->Customer->customer_name??'' }}</td>
                           
                          
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
                                        <div class="badge badge-pill badge-dark"> {{ $durationInSeconds }} secs</div>
                                        
                                    @elseif ($durationInSeconds < 3600)
                                        <div class="badge badge-pill badge-dark">  {{ floor($durationInSeconds / 60) }} mins</div>
                                       
                                    @else
                                    <div class="badge badge-pill badge-dark">  {{ floor($durationInSeconds / 3600) }} hrs </div>
                                        
                                    @endif
                                @else
                                <span class="badge badge-pill badge-light-info mr-1">Visit Active</span>
                                @endif
                            </td>

                                <td>{{ $visit->created_at->format('d-m-Y') }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-1">
                    {{ $visits->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<br>