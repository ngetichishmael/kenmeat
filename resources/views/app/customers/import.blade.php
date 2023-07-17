@extends('layouts.app3')

{{-- page header --}}
@section('title', 'Import Customer')

{{-- content section --}}
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-default">
            <div class="card-body text-center"> {{-- Add text-center class --}}
                <h4>Upload Customer</h4>
                <form action="{{ route('user-import.store') }}" id="import_form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="clients_import" value="true">
                    <div class="mb-2 form-group form-group-default">
                        <label for="file_csv" class="control-label text-danger">
                            <small class="req text-danger">* </small>Choose CSV File
                        </label>
                        <br>
                        <input type="file" name="upload_import" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success submit">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- page scripts --}}
@section('script')

@endsection
