@extends('layouts.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"/>
<style>
    .file-preview {
        height: 320px;
    }

    .file-drop-zone {
        height: 280px;
    }

    .kv-file-upload, .file-upload-indicator, .kv-file-download, .file-drag-handle {
        visibility: hidden !important;
    }
    .rating-container{
        padding: 5px;
    }
</style>
@section('content')
    <div class="container">
        <div class="col-md-12 ">
            <div class="card shadow mb-4 ">
                <div class="card-header py-3">
                    <div class="card-header">
                        <i class="c-icon cil-group"></i>Profile
                    </div>
                </div>
                <div class="card-body">
                    <form class="user" method="POST" action="{{ route('update_profile', $user->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-4">
                                <div class="col-sm-12 mb-12 mb-sm-12">
                                    <input id="avatar" type="file" name="avatar" class="file @error('avatar') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group row">
                                    <div class="col-sm-2 mb-2 mb-sm-2">
                                        <label class="col-form-label text-gray-900" for="inputAddress">{{__('translations.first_name')}}</label>
                                    </div>
                                    <div class="col-sm-10 mb-10 mb-sm-10">
                                        <input type="text"
                                               class="form-control  @error('first_name') is-invalid @enderror"
                                               name="first_name" value="{{ $user->first_name }}"
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
                                        <input type="text"
                                               class="form-control @error('last_name') is-invalid @enderror"
                                               name="last_name" value="{{ $user->last_name }}"
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
                                        <input type="email"
                                               class="form-control  @error('email') is-invalid @enderror"
                                               name="email" value="{{ $user->email }}"
                                               required autocomplete="email" id="exampleInputEmail"
                                               placeholder="{{__('translations.email')}}">
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
                                                   name="phone" value="{{ $user->phone }}"
                                                   required autocomplete="phone"
                                                   id="phone"
                                                   autofocus>
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-2 mb-sm-2">
                                        <label class="col-form-label text-gray-900" for="inputAddress">{{ __('translations.select') }} {{ __('translations.address') }}</label>
                                    </div>
                                    <div class="col-sm-10 mb-10 mb-sm-10 row">
                                        <div class="col-sm-4 mb-4 mb-sm-4">
                                            <select class="form-control" name="country_id">
                                                @foreach($countries as $country)
                                                    <option value="{{$country->id}}" {{$country->id == $user->country_id ? 'selected' : ''}}>{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4 mb-4 mb-sm-4">
                                            <select class="form-control" name="state_id" id="select_state">
                                                <option value="">{{ __('translations.select') }} {{ __('translations.state') }}</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}" {{$state->id == $user->state_id ? 'selected' : ''}}>{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4 mb-4 mb-sm-4">
                                            <select class="form-control" name="city_id" id="select_city">
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
                        <div class="card-footer text-center">
                            <button class="btn btn-sm btn-success" type="submit">{{ __('translations.submit') }}</button>
                            <a href="{{route('profile')}}" class="btn btn-sm btn-danger">
                                {{ __('translations.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var phones = [{ "mask": "+374 (##) ##-##-##"}, { "mask": "+374 (##) ##-##-##"}];
            $('#phone').inputmask({
                mask: phones,
                greedy: false,
                definitions: { '#': { validator: "[0-9]", cardinality: 1}} });

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        let avatar = '{{$user->avatar}}';
        console.log(avatar, 'avatar')
        let initialPreview = [];
        let initialPreviewConfig = [];
        if (avatar){
            initialPreview = ['/storage//uploads/users/' + avatar];
            initialPreviewConfig = [
                {caption: avatar, key: 'avatar'}
            ];
        }
        $("#avatar").fileinput({
            initialPreview: initialPreview,
            initialPreviewAsData: true,
            initialPreviewConfig: initialPreviewConfig,
            theme: 'fa',
            showUpload: false,
            uploadUrl: false,
            allowedFileExtensions: ['jpg', 'png', 'gif','jpeg'],
            overwriteInitial: false,
            maxFileSize: 2000,
            maxFilesNum: 1,
        });

        $(".kv-file-remove").click(function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            let id = '{{$user->id}}'
            let link = '{{$user->avatar}}'
            let type = 'image';
            let kv_file = $(this)
            $.ajax({
                type: "post",
                url: "/admin/profile/remove-image",
                data: {id:id, type:type, avatar:link},
                dataType:'json',
                success: function (data) {
                    if (data.alert === 'success'){
                        kv_file.parent().parent().parent().parent().remove()
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                },
                error: function (data) {
                    toastr.error(data.message);
                }
            });
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
