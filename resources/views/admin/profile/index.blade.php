@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12 ">
            <div class="card shadow mb-4 ">
                <div class="card-header py-3">
                    <div class="card-header">
                        <i class="c-icon cil-group"></i>Profile
                        <div class="card-header-actions">
                            <a href="{{route('edit_profile', $user->id)}}" class = "btn btn-sm btn-success">Edit Profile</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="user" method="POST" action="">
                        @csrf
                        <div class="row">
                                <div class="col-4">
                                    <div class="profile-img">
                                        <img class="img-thumbnail" src="{{$user->avatar ? asset('/storage/uploads/users/'.$user->avatar) : '/assets/img/avatar.png'}}" alt=""/>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group row">
                                        <div class="col-sm-2 mb-2 mb-sm-2">
                                            <label class="col-form-label text-gray-900" for="inputAddress">{{__('translations.first_name')}}</label>
                                        </div>
                                        <div class="col-sm-10 mb-10 mb-sm-10">
                                            <input type="text"
                                                   disabled
                                                   class="form-control  @error('first_name') is-invalid @enderror"
                                                   name="first_name" value="{{ $user->first_name }}"
                                                   required autocomplete="first_name"
                                                   id="firstName"
                                                   placeholder="{{__('translations.first_name')}}"
                                                   autofocus>
                                        </div>
                                        <div class="col-sm-2 mb-2 mb-sm-2">
                                            <label class="col-form-label text-gray-900" for="inputAddress">{{__('translations.last_name')}}</label>
                                        </div>
                                        <div class="col-sm-10 mb-10 mb-sm-10">
                                            <input type="text"
                                                   disabled
                                                   class="form-control @error('last_name') is-invalid @enderror"
                                                   name="last_name" value="{{ $user->last_name }}"
                                                   required autocomplete="last_name"
                                                   id="lastName"
                                                   placeholder="{{__('translations.last_name')}}"
                                                   autofocus>
                                        </div>
                                        <div class="col-sm-2 mb-2 mb-sm-2">
                                            <label class="col-form-label text-gray-900" for="inputAddress">{{__('translations.email')}}</label>
                                        </div>
                                        <div class="col-sm-10 mb-10 mb-sm-10">
                                            <input type="email"
                                                   disabled
                                                   class="form-control  @error('email') is-invalid @enderror"
                                                   name="email" value="{{ $user->email }}"
                                                   required autocomplete="email" id="exampleInputEmail"
                                                   placeholder="{{__('translations.email')}}">
                                        </div>
                                        <div class="col-sm-2 mb-2 mb-sm-2">
                                            <label class="col-form-label text-gray-900" for="phone">{{ __('translations.phone') }}</label>
                                        </div>
                                        <div class="col-sm-10 mb-10 mb-sm-10">
                                            <div class="input-group">
                                                <input type="text"
                                                       disabled
                                                       class="form-control @error('phone') is-invalid @enderror"
                                                       name="phone" value="{{ $user->phone }}"
                                                       required autocomplete="phone"
                                                       id="phone"
                                                       autofocus>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 mb-2 mb-sm-2">
                                            <label class="col-form-label text-gray-900" for="inputAddress">{{ __('translations.select') }} {{ __('translations.address') }}</label>
                                        </div>
                                        <div class="col-sm-10 mb-10 mb-sm-10 row">
                                            <div class="col-sm-4 mb-4 mb-sm-4">
                                                <select class="form-control" name="country_id" disabled>
                                                    @foreach($countries as $country)
                                                        <option value="{{$country->id}}" {{$country->id == $user->country_id ? 'selected' : ''}}>{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-4 mb-4 mb-sm-4">
                                                <select class="form-control" name="state_id" id="select_state" disabled>
                                                    <option value="">{{ __('translations.select') }} {{ __('translations.state') }}</option>
                                                    @foreach($states as $state)
                                                        <option value="{{$state->id}}" {{$state->id == $user->state_id ? 'selected' : ''}}>{{$state->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-4 mb-4 mb-sm-4">
                                                <select class="form-control" name="city_id" id="select_city" disabled>
                                                    <option value="">{{ __('translations.select') }} {{ __('translations.city') }}</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}" {{$city->id == $user->city_id ? 'selected' : ''}}>{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        $('#select_state').on('change', function() {
            $.ajax({
                type: "post",
                url: "/admin/settings/cities/city_by_state_id",
                data: {"_token": "{{ csrf_token() }}", state_id:this.value},
                dataType:'json',
                success: function (data) {
                    $('#select_city').empty();
                    if (data && data.cities){
                        $.each(data.cities , function (key, city) {
                            $('#select_city').append('<option value="'+city.id+'">'+city.name+'</option>');
                        });
                    }
                },
                error: function (data) {

                }
            });
        });
    </script>
@endsection
