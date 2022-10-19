@extends('layouts.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all"
      rel="stylesheet" type="text/css"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all"
      rel="stylesheet" type="text/css"/>
<style>
    .file-preview {
        height: 320px;
    }

    .file-drop-zone {
        height: 280px;
    }

    .kv-file-upload, .file-upload-indicator {
        visibility: hidden !important;
    }
</style>
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="h4 m-0 font-weight-bold text-primary text-center">{{__('translations.create')}} {{__('translations.agency')}}  </h4>
                </div>
                <div class="card-body">
                    <form class="agency" method="POST" action="{{ route('store_agency')}}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid">
                            <div class="fade-in">
                                <div class="row">
                                    <div class="col-12 nav-tabs-boxed">
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($languages as $language)
                                                <li class="nav-item">
                                                    <a class='{{$language === app()->getLocale() ? "nav-link active":"nav-link"}}'
                                                       data-toggle="tab" href="#{{$language}}" role="tab"
                                                       aria-controls="home">
                                                        {{$language}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($languages as $language)
                                                <div
                                                    class='{{$language === app()->getLocale()? "tab-pane active":"tab-pane"}}'
                                                    id="{{$language}}" role="tabpanel">
                                                    <div class="form-group row">
                                                        <div class="col-sm-2 mb-2 mb-sm-2">
                                                            <label class="col-form-label text-gray-900"
                                                                   for="name_{{$language}}">
                                                                {{__('translations.agency_name')}}
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-10 mb-10 mb-sm-10">
                                                            <input type="text"
                                                                   class="form-control @error('name_'.$language) is-invalid @enderror"
                                                                   name="name_{{$language}}"
                                                                   value="{{ old('name_'.$language) }}"
                                                                   autocomplete="name_{{$language}}"
                                                                   placeholder="{{__('translations.agency_name')}}"
                                                                   autofocus>
                                                            @error('name_'.$language)
                                                            <span class="invalid-feedback" role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-2 mb-2 mb-sm-2">
                                                            <label class="col-form-label text-gray-900"
                                                                   for="description_{{$language}}">
                                                                {{ __('translations.description') }}
                                                                ({{__('translations.max')}} 255)
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-10 mb-10 mb-sm-10">
                                                            <textarea type="text"
                                                                      class="form-control @error('description_'.$language) is-invalid @enderror"
                                                                      name="description_{{$language}}"
                                                                      autocomplete="description_"
                                                                      {{$language}} placeholder="{{ __('translations.description') }}"
                                                                      autofocus>{{old('description_'.$language)}}</textarea>
                                                            @error('description_'.$language)
                                                            <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="form-group row">
                                                <div class="col-sm-2 mb-2 mb-sm-2">
                                                    <label class="col-form-label text-gray-900"
                                                           for="phone">{{ __('translations.phone') }}</label>
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
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-2 mb-2 mb-sm-2">
                                                    <label class="col-form-label text-gray-900"
                                                           for="inputAddress">{{ __('translations.select') }} {{ __('translations.address') }}</label>
                                                </div>
                                                <div class="col-sm-10 mb-10 mb-sm-10 row">
                                                    <div class="col-sm-4 mb-4 mb-sm-4">
                                                        <select class="form-control" name="country_id">
                                                            @foreach($countries as $country)
                                                                <option
                                                                    value="{{$country->id}}" {{$country->id == old('city_id') ? 'selected' : ''}}>{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4 mb-4 mb-sm-4">
                                                        <select class="form-control" name="state_id" id="select_state">
                                                            <option
                                                                value="">{{ __('translations.select') }} {{ __('translations.state') }}</option>
                                                            @foreach($states as $state)
                                                                <option
                                                                    value="{{$state->id}}" {{$state->id == old('state_id') ? 'selected' : ''}}>{{$state->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4 mb-4 mb-sm-4">
                                                        <select class="form-control" name="city_id" id="select_city">
                                                            <option
                                                                value="">{{ __('translations.select') }} {{ __('translations.city') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-2 mb-2 mb-sm-2">
                                                    <label class="col-form-label text-gray-900" for="image">
                                                        {{ __('translations.image') }}
                                                    </label>
                                                </div>
                                                <div class="col-sm-10 mb-10 mb-sm-10">
                                                    <input id="image"
                                                           class="form-control file-input @error('image') is-invalid @enderror"
                                                           type="file" name="image">
                                                    @error('image')
                                                    <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-sm btn-success" type="submit">
                                {{__('translations.submit')}}
                            </button>
                            <a href="{{route('agencies')}}" class="btn btn-sm btn-danger">
                                {{__('translations.cancel')}}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js"
            type="text/javascript"></script>
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

        $("#image").fileinput({
            theme: 'fa',
            showUpload: false,
            uploadUrl: false,
            allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
            overwriteInitial: false,
            maxFileSize: 2000,
            maxFilesNum: 1,
        });

        if ('{{old('state_id')}}') {
            getState('{{old('state_id')}}')
        }

        function getState(state_id) {
            $.ajax({
                type: "post",
                url: "/admin/settings/cities/city_by_state_id",
                data: {"_token": "{{ csrf_token() }}", state_id: state_id},
                dataType: 'json',
                success: function (data) {
                    $('#select_city').empty();
                    if (data && data.cities) {
                        $.each(data.cities, function (key, city) {
                            let selected;
                            if ('{{old('state_id')}}' && '{{old('state_id')}}' == city.id) {
                                selected = 'selected';
                            }
                            $('#select_city').append('<option value="' + city.id + '" selected="' + selected + '" >' + city.name + '</option>');
                        });
                    }
                },
                error: function (data) {

                }
            });
        }

        $('#select_state').on('change', function () {
            getState(this.value)
        });

    </script>
@endsection
