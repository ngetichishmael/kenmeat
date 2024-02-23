@extends('layouts.app') 

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Edit Outlet</div>

                <div class="card-body">
                    <form class="form" method="POST" action="{{ route('outlets.update', ['outlet' => $outletType->outlet_code]) }}">
                        @method('PATCH')
                        @csrf
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="outlet_code" style="display: none;">Outlet Code</label>
                                <input type="text" class="form-control" id="outlet_code" name="outlet_code" value="{{ old('outlet_code', $outletType->outlet_code) }}" style="display: none;">
                            </div>
                            <div class="form-group">
                                <label for="business_code" style="display: none;">Business Code</label>
                                <input type="text" class="form-control" id="business_code" name="business_code" value="{{ old('business_code', $outletType->business_code) }}" style="display: none;">
                            </div>
                            <div class="form-group">
                                <label for="outlet_name">Outlet Name</label>
                                <input type="text" class="form-control" id="outlet_name" name="outlet_name" value="{{ old('outlet_name', $outletType->outlet_name) }}">
                            </div>
                        </div>
                        <div class="my-1 col-sm-9 offset-sm-3">
                            <button type="submit" class="mr-1 btn btn" style="background-color:#1877F2; color:#ffffff;">Update Outlet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
