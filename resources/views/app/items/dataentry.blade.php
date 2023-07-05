@extends('layouts.app')
{{-- page header --}}
@section('title','Data-Entry')

{{-- content section --}}
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">	Data Entry | Details</h2>
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
    <div class="col-md-12">
        <div class="card card-inverse">
           <div class="card-body">
              <table id="data-table-default" class="table table-striped table-bordered">
                 <thead>
                    <tr>
                       <th>#</th>
                       <th>User Name</th>
                       <th>No of Orders</th>
                       <th>Region</th>
                       <th>Subregion</th>
                    </tr>
                 </thead>
                 <tbody>
                  @foreach ($dataentry as $key => $dataentri)
                  <tr>
                     <td>{{ $key+1 }}</td>
                     <td>{{ $dataentri->name }}</td>
                     <td></td>
                     <td>{{ $dataentri->Region->name??'Not found' }}</td>
                     <td>{{ $dataentri->Subregion->name??'Not found' }}</td>
                 </tr>
                  @endforeach
                   
                    
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

