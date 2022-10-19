@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card shadow mb-4 ">
                <div class="card-header py-3">
                    <h4 class="h4 m-0 font-weight-bold text-primary text-center">{{__('translations.create')}} {{__('translations.user')}}</h4>
                </div>
                <div class="card-body">
                    <form class="user" method="POST" action="{{ route('store_user') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-2 mb-2 mb-sm-2">
                                <label class="col-form-label text-gray-900" for="inputAddress">{{__('translations.first_name')}}</label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <input type="text" class="form-control  @error('first_name') is-invalid @enderror"
                                       name="first_name" value="{{ old('first_name') }}"
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
                                <label class="col-form-label text-gray-900" for="inputAddress">{{__('translations.last_name')}}</label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <input type="text" class="form-control  @error('last_name') is-invalid @enderror"
                                       name="last_name" value="{{ old('last_name') }}"
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
                                <label class="col-form-label text-gray-900" for="inputAddress">{{__('translations.email')}}</label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <input type="email" class="form-control  @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}"
                                       required autocomplete="email" id="exampleInputEmail" placeholder="{{__('translations.email')}}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-sm-2 mb-2 mb-sm-2">
                                <label class="col-form-label text-gray-900" for="phone">{{ __('translations.phone') }}</label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <div class="input-group">
                                    <input type="text"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           name="phone" value="{{ old('phone') }}"
                                           required autocomplete="phone"
                                           id="phone"
                                           placeholder="+374(00)00-00-00"
                                           autofocus>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-2 mb-2 mb-sm-2">
                                <label class="col-form-label text-gray-900" for="inputLimit">{{__('translations.limit')}}</label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <input type="number" class="form-control  @error('limit') is-invalid @enderror"
                                       name="limit" value="{{ old('limit') }}"
                                       required autocomplete="limit" id="limit" placeholder="{{__('translations.limit')}}">
                                @error('limit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-2 mb-2 mb-sm-2">
                                <label class="col-form-label text-gray-900" for="inputAddress">
                                    {{__('translations.role')}}
                                </label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <select class="form-select form-control" name="role">
                                    @foreach($roles as $role)
                                        @if($role->slug != 'super_admin')
                                            <option value="{{$role->id}}" {{ old('role') == $role->id  ? 'selected' : '' }}> {{$role->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-sm btn-success" type="submit">
                                {{__('translations.submit_person')}}
                            </button>
                            <a href="{{route('users')}}" class="btn btn-sm btn-danger">
                                {{__('translations.cancel')}}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        $(document).ready(function(){
            var phones = [{ "mask": "+374 (##) ##-##-##"}, { "mask": "+374 (##) ##-##-##"}];
            $('#phone').inputmask({
                mask: phones,
                greedy: false,
                definitions: { '#': { validator: "[0-9]", cardinality: 1}} });

        });
    </script>
@endsection
