@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.6/css/star-rating.min.css"/>
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
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="h4 m-0 font-weight-bold text-primary text-center">{{ __('translations.edit') }} {{ __('translations.broker') }}</h4>
                </div>
                <div class="card-body">
                    <form class="user" method="POST" action="{{ route('edit'.$slug.'_broker', $broker->id)}}" enctype="multipart/form-data">
                        @csrf
                        @if($slug)
                            <div class="form-group row">
                                <div class="col-12 nav-tabs-boxed">
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach($languages as $language)
                                            <li class="nav-item">
                                                <a class='{{$language === app()->getLocale() ? "nav-link active":"nav-link"}}'
                                                   data-toggle="tab" href="#name_{{$language}}" role="tab" aria-controls="home">
                                                    {{$language}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach($languages as $language)
                                            <div class='{{$language === app()->getLocale()? "tab-pane active":"tab-pane"}}'
                                                 id="name_{{$language}}" role="tabpanel">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 mb-3 mb-sm-3">
                                                        <label class="col-form-label text-gray-900" for="description">
                                                            {{__('translations.name')}}
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-9 mb-9 mb-sm-9">
                                                        <div class="md-form">
                                                            <input id="name_{{$language}}"
                                                                   class="md-textarea form-control"
                                                                   placeholder="{{__('translations.first_name')}}"
                                                                   name="name_{{$language}}"
                                                                   value="@if($broker->translate($language)){{$broker->translate($language)->name}}@endif"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(!$slug)
                        <div class="form-group row">
                                <div class="col-sm-2 mb-2 mb-sm-2">
                                    <label class="col-form-label text-gray-900" for="inputAddress">{{ __('translations.first_name') }}</label>
                                </div>
                                <div class="col-sm-10 mb-10 mb-sm-10">
                                    <input type="text"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           name="first_name" value="{{ $broker->first_name }}"
                                           required autocomplete="first_name"
                                           id="first_name"
                                           placeholder="{{ __('translations.first_name') }}"
                                           autofocus>
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        <div class="form-group row">
                            <div class="col-sm-2 mb-2 mb-sm-2">
                                <label class="col-form-label text-gray-900" for="inputAddress">{{ __('translations.last_name') }}</label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $broker->last_name }}"
                                       required autocomplete="last_name" id="last_name" placeholder="{{ __('translations.last_name') }}" autofocus>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <div class="col-sm-2 mb-2 mb-sm-2">
                                <label class="col-form-label text-gray-900" for="inputAddress">{{ __('translations.email') }}</label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $broker->email }}" required autocomplete="email"
                                       id="email"placeholder="{{ __('translations.email') }}" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2 mb-2 mb-sm-2">
                                <label class="col-form-label text-gray-900" for="phone">{{ __('translations.phone') }}</label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <div class="input-group">
                                    <input type="text"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           name="phone" value="{{ $broker->phone }}"
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
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2 mb-2 mb-sm-2">
                                <label class="col-form-label text-gray-900" for="rating">{{ __('translations.rating') }}</label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <input id="rating" name="rating" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $broker->averageRating }}" data-size="xs">
                                @error('rating')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2 mb-2 mb-sm-2">
                                <label class="col-form-label text-gray-900" for="inputAddress">{{ __('translations.select') }} {{ __('translations.address') }}</label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10 row">
                                <div class="col-sm-4 mb-4 mb-sm-4">
                                    <select class="form-control" name="country_id">
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" {{$country->id == $broker->country_id ? 'selected' : ''}}>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4 mb-4 mb-sm-4">
                                    <select class="form-control" name="state_id" id="select_state">
                                        <option value="">{{ __('translations.select') }} {{ __('translations.state') }}</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" {{$state->id == $broker->state_id ? 'selected' : ''}}>{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4 mb-4 mb-sm-4">
                                    <select class="form-control" name="city_id" id="select_city">
                                        <option value="">{{ __('translations.select') }} {{ __('translations.city') }}</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" {{$city->id == $broker->city_id ? 'selected' : ''}}>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if(!$slug)
                        <div class="form-group row">
                            <div class="col-sm-2 mb-2 mb-sm-2">
                                <label class="col-form-label text-gray-900" for="inputAddress">{{ __('translations.select') }} {{ __('translations.company') }}</label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <select class="form-control" name="agency_id">
                                    <option value="">{{ __('translations.select') }}</option>
                                    @foreach($agencies as $agency)
                                        <option value="{{$agency->id}}" {{$agency->id == $broker->broker_id ? 'selected' : ''}}>
                                            @for($i = 0; $i < count($languages); $i++)
                                                @if($languages[$i] === app()->getLocale())
                                                    {{$agency->translations[$i]->name}}
                                                @endif
                                            @endfor
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <div class="col-sm-2 mb-2 mb-sm-2">
                                <label class="col-form-label text-gray-900" for="inputAddress">{{ __('translations.select') }} {{ __('translations.type') }}</label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <select class="form-control" name="type">
                                    <option value="sell/rent" {{ $broker->type === "sell/rent" ? 'selected' : ''}}>{{ __('translations.sell')}}/{{ __('translations.rent')}}</option>
                                    <option value="sell" {{ $broker->type === "sell" ? 'selected' : ''}}>{{ __('translations.sell') }}</option>
                                    <option value="rent" {{ $broker->type === "rent" ? 'selected' : ''}}>{{ __('translations.rent') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2 mb-2 mb-sm-2">
                                <label class="col-form-label text-gray-900" for="inputAddress">{{ __('translations.broker_licenses') }} </label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <input id="broker_licenses"  class="form-control" type="text" name="broker_licenses"  value="{{$broker->broker_licenses}}" placeholder="{{ __('translations.broker_licenses') }}">
                                @error('broker_licenses')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if($slug)
                            <div class="form-group row">
                                <div class="col-12 nav-tabs-boxed">
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach($languages as $language)
                                            <li class="nav-item">
                                                <a class='{{$language === app()->getLocale() ? "nav-link active":"nav-link"}}'
                                                   data-toggle="tab" href="#{{$language}}" role="tab" aria-controls="home">
                                                    {{$language}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach($languages as $language)
                                            <div class='{{$language === app()->getLocale()? "tab-pane active":"tab-pane"}}'
                                                 id="{{$language}}" role="tabpanel">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 mb-3 mb-sm-3">
                                                        <label class="col-form-label text-gray-900" for="description">
                                                            {{__('translations.description')}}
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-9 mb-9 mb-sm-9">
                                                        <div class="md-form">
                                                    <textarea id="description_{{$language}}"
                                                              class="md-textarea form-control"
                                                              placeholder="{{__('translations.description')}}"
                                                              rows="3"
                                                              name="description_{{$language}}">@if($broker->translate($language)){{$broker->translate($language)->description}}@endif</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="form-group row">
                                <div class="col-sm-2 mb-2 mb-sm-2">
                                    <label class="col-form-label text-gray-900" for="inputAddress">{{ __('translations.description') }}</label>
                                </div>
                                <div class="col-sm-10 mb-10 mb-sm-10 mb-2">
                                    <textarea id="description" class="md-textarea form-control @error('info') is-invalid @enderror" placeholder="{{__('translations.info')}}" rows="3" name="info">{{ $broker->info }}</textarea>
                                    @error('info')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <div class="col-sm-2 mb-2 mb-sm-2">
                                <label class="col-form-label text-gray-900" for="inputAddress">{{ __('translations.choose') }} {{ __('translations.avatar') }}</label>
                            </div>
                            <div class="col-sm-10 mb-10 mb-sm-10">
                                <input id="avatar" type="file" name="avatar" class="file @error('avatar') is-invalid @enderror">
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-sm btn-success" type="submit">{{ __('translations.submit') }}</button>
                            <a href="{{route('brokers')}}" class="btn btn-sm btn-danger">
                                {{ __('translations.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.6/js/star-rating.min.js" type="text/javascript"></script>
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

            let  avatar = '{{$broker->avatar}}';
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
                let id = '{{$broker->id}}'
                let link = '{{$broker->avatar}}'
                let type = 'image';
                let kv_file = $(this)
                $.ajax({
                    type: "post",
                    url: "/admin/brokers/remove-image",
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

            $("#rating").rating({min:1, max:5, step:2, size:'lg'});

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
