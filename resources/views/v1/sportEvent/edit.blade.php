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
        <h1 class="h3 mb-0 text-gray-800">Sport Events Management</h1>
        <div class="d-none d-sm-inline-block">
        </div>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Sport Events Form</h6>
                </div>
                <div class="card-body" style="overflow-x:auto;padding:20px;">
                    <form method="POST" action="{{ route('admin.v1.sport-events.update',$data['id']) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="eventDate" class="col-md-3 col-form-label text-md-right">{{ __('Event Date') }}</label>
                            <div class="col-md-8 mb-3 mb-sm-0">
                                <input id="eventDate" type="date" class="form-control form-control-user @error('eventDate') is-invalid @enderror" name="eventDate" value="{{ $data['eventDate'] }}" autocomplete="eventDate">
                                @error('eventDate')
                                    <span class="invalid-feedback" status="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="eventName" class="col-md-3 col-form-label text-md-right">{{ __('Event Name') }}</label>
                            <div class="col-md-8 mb-3 mb-sm-0">
                                <input id="eventName" type="text" class="form-control form-control-user @error('eventName') is-invalid @enderror" name="eventName" value="{{ $data['eventName'] }}" autocomplete="eventName">
                                @error('eventName')
                                    <span class="invalid-feedback" status="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="eventType" class="col-md-3 col-form-label text-md-right">{{ __('Event Type') }}</label>
                            <div class="col-md-8 mb-3 mb-sm-0">
                                <input id="eventType" type="text" class="form-control form-control-user @error('eventType') is-invalid @enderror" name="eventType" value="{{ $data['eventType'] }}" autocomplete="eventType">
                                @error('eventType')
                                    <span class="invalid-feedback" status="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="organizerId" class="col-md-3 col-form-label text-md-right">{{ __('Organizer') }}</label>
                            <div class="col-md-8 mb-3 mb-sm-0">
                                <select name="organizerId" id="organizerId"
                                    class="select2 form-control form-control-user @error('organizerId') is-invalid @enderror"
                                    value="{{ $data['organizer']['id'] }}" autocomplete="organizerId">
                                    <option value="" selected disabled>Pilih dari daftar</option>
                                    @foreach ($refs as $ref)
                                        <option value="{{ $ref['id'] }}" @if($data['organizer']['id'] == $ref['id']) selected @endif>{{ $ref['organizerName'] }}</option>
                                    @endforeach
                                </select>
                                @error('organizerId')
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
                                <a href="{{ route('admin.v1.sport-events.index') }}" type="submit" class="btn btn-user btn-danger btn-block text-white">
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
