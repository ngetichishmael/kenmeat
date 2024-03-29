@extends('layouts.app')
{{-- page header --}}
@section('title','Items')

{{-- content section --}}
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Reconciled | items</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   @include('partials._messages')
   <div class="row">
    <div class="col-md-8">
        <div class="card card-inverse">
           <div class="card-body">
              <table id="data-table-default" class="table table-striped table-bordered">
                 <thead>
                    <tr>
                       <th>#</th>
                       <th>Product Name</th>
                       <th>Quantity</th>
                       <th>Date</th>
                    </tr>
                 </thead>
                 <tbody>
                 @if ($reconciled->isEmpty())

                    <td colspan="4" style="font-weight: bold; text-align: center">No reconciled items found.</td>
                 @else
                    @foreach ($reconciled as $key => $reconcile)
                       <tr>
                          <td>{{ $key + 1 }}</td>
                          <td>{{ $reconcile->name }}</td>
                          <td>{{ $reconcile->amount }}</td>
                          <td>{{ $reconcile->date }}</td>
                       </tr>
                    @endforeach
                 @endif
                 </tbody>
              </table>
           </div>
        </div>
     </div>
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection

