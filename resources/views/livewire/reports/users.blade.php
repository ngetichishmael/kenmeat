<div class="row">
    @include('partials.stickymenu')
    <div class="col-md-8">
        <div class="card card-inverse">
           <div class="card-body">
              <table id="data-table-default" class="table table-striped table-bordered">
                 <thead>
                    <tr>
                       <th>#</th>
                       <th>User Type</th>
                       <th>Number of Users</th>
                       <th>Action</th>
                    </tr>
                 </thead>
                 <tbody>
               @foreach ($usercount as $key=>$user)
               <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $user->account_type }}</td>
                  <td>{{ $user->count}}</td>
                  <td>@if ($user->account_type ==="Admin")
                     <a href="{{ route('admin.details') }}" class="btn btn-success btn-sm">View</a>
                     @elseif($user->account_type ==="Customer")
                     <a href="{{ route('customer.details') }}" class="btn btn-success btn-sm">View</a>
                     @elseif($user->account_type ==="Account Sales Manager")
                     <a href="{{ route('asm.details') }}" class="btn btn-success btn-sm">View</a>
                     @elseif($user->account_type ==="Team Leader")
                     <a href="{{ route('teamleader.details') }}" class="btn btn-success btn-sm">View</a>
                     @elseif($user->account_type ==="GT Sales")
                     <a href="{{ route('gtsales.details') }}" class="btn btn-success btn-sm">View</a>
                     @elseif($user->account_type ==="Account Manager")
                     <a href="{{ route('asm.details') }}" class="btn btn-success btn-sm">View</a>
                     @elseif($user->account_type ==="HR")
                     <a href="{{ route('hr.details') }}" class="btn btn-success btn-sm">View</a>
                     @elseif($user->account_type ==="Data entry")
                     <a href="{{ route('dataentry.details') }}" class="btn btn-success btn-sm">View</a>
                     @elseif($user->account_type ==="Merchandiser")
                     <a href="{{ route('merchandiser.details') }}" class="btn btn-success btn-sm">View</a>
                     @elseif($user->account_type ==="Manager")
                     <a href="{{ route('manager.details') }}" class="btn btn-success btn-sm">View</a>
                     @elseif($user->account_type ==="Sales")
                     <a href="{{ route('sales.details') }}" class="btn btn-success btn-sm">View</a>
                     @endif
                     </td>
              </tr>
               @endforeach
                    
                 </tbody>
              </table>
           </div>
        </div>
     </div>
   </div>