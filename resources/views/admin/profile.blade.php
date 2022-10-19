@extends('layouts.app')
@section('content')
    {{App::setLocale(Config::get("app.locale"))}}
    <div class="container">
        <h1>Profile</h1>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="container">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <img class="img-thumbnail rounded-circle" width="100%"
                                     src="{{\Illuminate\Support\Facades\Auth::user()->avatar?asset('storage/'.\Illuminate\Support\Facades\Auth::user()->avatar):'/assets/img/avatars/7.jpg'}}"
                                     alt="...">
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1"></div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <h4>
                                    {{\Illuminate\Support\Facades\Auth::user()->first_name}}
                                    {{\Illuminate\Support\Facades\Auth::user()->last_name}}
                                </h4>
                                <h6 class="text-muted">
                                    {{\Illuminate\Support\Facades\Auth::user()->email}} -
                                    {{\Illuminate\Support\Facades\Auth::user()->roles()->first()->name}}
                                </h6>
                                <form
                                    action="{{ route('update_avatar',[Config::get('app.locale'),\Illuminate\Support\Facades\Auth::id()]) }}"
                                    enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <input name="avatar" type="file"/>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <h2>Account</h2>
                    <hr>
                    <div class="card-body">
                        <form class="user" method="POST"
                              action="{{ route('update_profile_account',[Config::get('app.locale'),\Illuminate\Support\Facades\Auth::id()]) }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-2 mb-2 mb-sm-2">
                                    <label class="col-form-label text-gray-900"
                                           for="inputAddress">{{__('translations.first_name')}}</label>
                                </div>
                                <div class="col-sm-10 mb-10 mb-sm-10">
                                    <input type="text"
                                           class="form-control  @error('first_name') is-invalid @enderror"
                                           name="first_name"
                                           value="{{\Illuminate\Support\Facades\Auth::user()->first_name}}"
                                           required autocomplete="first_name"
                                           id="firstName"
                                           placeholder="{{__('translations.first_name')}}"
                                           autofocus>
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="col-sm-2 mb-2 mb-sm-2">
                                    <label class="col-form-label text-gray-900"
                                           for="inputAddress">{{__('translations.last_name')}}</label>
                                </div>
                                <div class="col-sm-10 mb-10 mb-sm-10">
                                    <input type="text"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           name="last_name"
                                           value="{{\Illuminate\Support\Facades\Auth::user()->last_name}}"
                                           required autocomplete="last_name"
                                           id="lastName"
                                           placeholder="{{__('translations.last_name')}}"
                                           autofocus>
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="col-sm-2 mb-2 mb-sm-2">
                                    <label class="col-form-label text-gray-900"
                                           for="inputAddress">{{__('translations.email')}}</label>
                                </div>
                                <div class="col-sm-10 mb-10 mb-sm-10">
                                    <input type="email"
                                           class="form-control  @error('email') is-invalid @enderror"
                                           name="email" value="{{\Illuminate\Support\Facades\Auth::user()->email}}"
                                           required autocomplete="email" id="exampleInputEmail"
                                           placeholder="{{__('translations.email')}}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="col-sm-2 mb-2 mb-sm-2">
                                    <label class="col-form-label text-gray-900"
                                           for="inputAddress">{{__('translations.change')}} {{__('translations.password')}}</label>
                                </div>
                                <div class="col-sm-10 mb-10 mb-sm-10">
                                    <input type="password" class="form-control
                                            @error('password') is-invalid @enderror"
                                           id="exampleInputPassword" placeholder="{{__('translations.Password')}}"
                                           name="password" autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-sm btn-success" type="submit">{{__('translations.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
