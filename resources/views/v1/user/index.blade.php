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
        <h1 class="h3 mb-0 text-gray-800">Profile Page {{ $data['firstName'].' '.$data['lastName'] }}</h1>
        <div class="d-none d-sm-inline-block">
        </div>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">User Form</h6>
                    <div class="justify-content-end">
                        <button type="button" class="d-inline btn btn-sm btn-warning" data-toggle="modal" data-target="#changePassword">
                            {{ __('Change Password') }}
                        </button>
                        <a href="{{ route('admin.v1.user.delete') }}" onclick="return confirm('Are You Sure?')" class="btn d-inline btn-sm btn-user btn-danger btn-block text-white">
                            {{ __('Delete This User') }}
                        </a>
                    </div>
                </div>
                <div class="card-body" style="overflow-x:auto;padding:20px;">
                    <form method="POST" action="{{ route('admin.v1.user.update') }}" enctype="multipart/form-data">
                        @csrf  
                        @method('PUT')
                        <div class="form-group row">
                            <label for="firstName" class="col-md-3 col-form-label text-md-right">{{ __('First Name') }}</label>
                            <div class="col-md-8 mb-3 mb-sm-0">
                                <input id="firstName" type="text" class="form-control form-control-user @error('firstName') is-invalid @enderror" name="firstName" value="{{ $data['firstName'] }}" autocomplete="firstName">
                                @error('firstName')
                                    <span class="invalid-feedback" status="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lastName" class="col-md-3 col-form-label text-md-right">{{ __('Last Name') }}</label>
                            <div class="col-md-8 mb-3 mb-sm-0">
                                <input id="lastName" type="text" class="form-control form-control-user @error('lastName') is-invalid @enderror" name="lastName" value="{{ $data['lastName'] }}" autocomplete="lastName">
                                @error('lastName')
                                    <span class="invalid-feedback" status="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('Email') }}</label>
                            <div class="col-md-8 mb-3 mb-sm-0">
                                <input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ $data['email'] }}" autocomplete="email">
                                @error('email')
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
                                <a href="{{ route('admin.v1.dashboard') }}" type="submit" class="btn btn-user btn-danger btn-block text-white">
                                    {{ __('Back') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.v1.user.change_password') }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label for="oldPassword" class="col-md-3 col-form-label text-md-right">{{ __('Old Password') }}</label>
                            <div class="col-md-8 mb-3 mb-sm-0">
                                <input id="oldPassword" type="password" class="form-control form-control-user @error('oldPassword') is-invalid @enderror" name="oldPassword" autocomplete="oldPassword">
                                @error('oldPassword')
                                    <span class="invalid-feedback" status="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="newPassword" class="col-md-3 col-form-label text-md-right">{{ __('New Password') }}</label>
                            <div class="col-md-8 mb-3 mb-sm-0">
                                <input id="newPassword" type="password" class="form-control form-control-user @error('newPassword') is-invalid @enderror" name="newPassword" autocomplete="newPassword">
                                @error('newPassword')
                                    <span class="invalid-feedback" status="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="repeatPassword" class="col-md-3 col-form-label text-md-right">{{ __('Repeat Password') }}</label>
                            <div class="col-md-8 mb-3 mb-sm-0">
                                <input id="repeatPassword" type="password" class="form-control form-control-user @error('repeatPassword') is-invalid @enderror" name="repeatPassword" autocomplete="repeatPassword">
                                @error('repeatPassword')
                                    <span class="invalid-feedback" status="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
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
