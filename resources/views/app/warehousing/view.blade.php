@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Warehouse')

{{-- content section --}}
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Edit Warehouse </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                     <li class="breadcrumb-item"><a href="{{route('warehousing.index')}}">Warehouses</a></li>
                     <li class="breadcrumb-item active">Edit</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   @include('partials._messages')
   <div class="row">
      <div class="col-md-8">
         <div class="card">
            <div class="card-body ml-5">

               <h2>Warehouse Details</h2>
               <p><strong>Region:</strong> {{ $warehouse->region->name ?? '' }}</p>
               <p><strong>Subregion:</strong> {{ $warehouse->subregion->name ?? '' }}</p>
               <p><strong>Created on:</strong> {{ $warehouse->created_at ?? '' }}</p>
            </div>
         </div>

         <div class="card mt-8">
            <div class="card-header">
               <h3>Shop Attendees</h3>
            </div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                  <tr>
                     <th>Name</th>
                     <th>Role</th>
                     <th>Assigned On</th>
                     <th>Assigned By</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if ($attendees->isEmpty())
                     <tr>
                        <td class=" " colspan="4" style="text-align: center;">
                           <p>No Warehouse Manager assigned at the Moment !!</p>
                           <a href="{!! route('warehousing.assign',['warehouse_code'=> $warehouse->warehouse_code]) !!}" style="text-align: center;" type="button" class="dropdown-item btn btn-sm" style="color: #a6f6a6; font-weight: bold; width: 200px">Assign a Manager</a>
                        </td>
                     </tr>
                  @else
                  @foreach ($attendees as $attendee)
                     <tr>
                        <td>{{ $attendee->managers->name ?? '' }}</td>
                        <td>{{ $attendee->position ?? ''}}</td>
                        <td>{{ $attendee->created_at ?? '' }}</td>
                        <td>{{ $attendee->user->name ?? '' }}</td>
                     </tr>
                  @endforeach
                  @endif
                  </tbody>
               </table>
            </div>
         </div>
      </div>
            </div>
   <center>
      <a href="{{ url()->previous() }}" class="btn btn-info mt-2">
         <i data-feather='arrow-left'></i> Back
      </a>
   </center>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
