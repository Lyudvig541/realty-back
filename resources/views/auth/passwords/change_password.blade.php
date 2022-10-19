@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="c-icon mr-2 fa fa-key"></i>
                                {{__('translations.change_password')}}
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('update_password') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="current_password" class="col-md-4 col-form-label text-md-right">Current Password</label>

                                        <div class="col-md-6">
                                            <input id="current_password" type="password" value="{{ old('current_password') }}" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="new_password" class="col-md-4 col-form-label text-md-right">New Password</label>

                                        <div class="col-md-6">
                                            <input id="new_password" type="password" value="{{ old('new_password') }}" class="form-control @error('new_password') is-invalid @enderror" name="new_password" autocomplete="current-password">
                                            @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="new_confirm_password" class="col-md-4 col-form-label text-md-right">New Confirm Password</label>

                                        <div class="col-md-6">
                                            <input id="new_confirm_password" type="password" class="form-control @error('new_confirm_password') is-invalid @enderror" name="new_confirm_password" autocomplete="current-password">
                                            @error('new_confirm_password')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Update Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
