@extends('v1.layouts.main')
@section('content')
    @if(session('error'))
        <div class="card shadow bg-danger text-white" style="margin-bottom:20px;">
            <div class="card-body" style="overflow-x:auto;padding:10px;">{!! session('error') !!}</div>
        </div>
    @endif
    @if(session('success'))
        <div class="card shadow bg-success text-white" style="margin-bottom:20px;">
            <div class="card-body" style="overflow-x:auto;padding:10px;">{!! session('success') !!}</div>
        </div>
    @endif
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Organizer Management</h1>
        <div class="d-none d-sm-inline-block">
        </div>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Organizer Form</h6> 
                </div>
                <div class="card-body" style="overflow-x:auto;padding:20px;">
                    <form method="POST" action="{{ route('admin.v1.organizer.update',$data['id']) }}" enctype="multipart/form-data">
                        @csrf  
                        @method('PUT')
                        <div class="form-group row">
                            <label for="organizerName" class="col-md-3 col-form-label text-md-right">{{ __('Organizer Name') }}</label>
                            <div class="col-md-8 mb-3 mb-sm-0">
                                <input id="organizerName" type="text" class="form-control form-control-user @error('organizerName') is-invalid @enderror" name="organizerName" value="{{ $data['organizerName'] }}" autocomplete="organizerName">
                                @error('organizerName')
                                    <span class="invalid-feedback" status="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="imageLocation" class="col-md-3 col-form-label text-md-right">{{ __('Image') }}</label>
                            <div class="col-md-8 mb-3 mb-sm-0">
                                <img src="{{ $data['imageLocation'] }}" width="300" class="mb-2">
                                <input id="imageLocation" type="file" class="form-control form-control-user @error('imageLocation') is-invalid @enderror" name="imageLocation" autocomplete="imageLocation">
                                @error('imageLocation')
                                    <span class="invalid-feedback" status="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-12">
                                <button type="submit" class="btn btn-user btn-primary btn-block">
                                    {{ __('Save') }}
                                </button>
                            </div>
                            <div class="col-md-6 offset-md-12">
                                <a href="{{ route('admin.v1.organizer.index') }}" type="submit" class="btn btn-user btn-danger btn-block text-white">
                                    {{ __('Back') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#checkall").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
