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
</style>
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h4 m-0 font-weight-bold text-primary text-center">
                        {{ __('translations.edit') }} {{ __('translations.constructors') }} {{ __('translations.agency') }}
                    </h1>
                </div>
                <div class="card-body">
                    <form class="agency" method="POST" action="{{ route('edit_constructor_agency', $constructor_agency->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid">
                            <div class="fade-in">
                                <div class="row">
                                    <div class="col-12 nav-tabs-boxed">
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($languages as $language)
                                                <li class="nav-item">
                                                    <a class='{{$language === app()->getLocale() ? "nav-link active":"nav-link"}}' data-toggle="tab" href="#{{$language}}" role="tab" aria-controls="home">
                                                        {{$language}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($languages as $language)
                                                <div class='{{$language === app()->getLocale()? "tab-pane active":"tab-pane"}}' id="{{$language}}" role="tabpanel">
                                                    <div class="form-group row">
                                                        <div class="col-sm-2 mb-2 mb-sm-2">
                                                            <label class="col-form-label text-gray-900" for="name_{{$language}}">
                                                                {{__('translations.agency_name')}}
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-10 mb-10 mb-sm-10">
                                                            <input type="text" class="form-control @error('name_'.$language) is-invalid @enderror" name="name_{{$language}}" value="{{$constructor_agency->translate($language)->name}}" autocomplete="name_{{$language}}" placeholder="{{__('translations.agency_name')}}" autofocus>
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
                                                            <label class="col-form-label text-gray-900" for="description_{{$language}}">
                                                                {{ __('translations.description') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-10 mb-10 mb-sm-10">
                                                            <textarea type="text" rows="6" class="form-control @error('description_'.$language) is-invalid @enderror" name="description_{{$language}}" autocomplete="description_"{{$language}} placeholder="{{ __('translations.description') }}" autofocus>{{$constructor_agency->translate($language)->description}}</textarea>
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
                                                        <label class="col-form-label text-gray-900" for="phone">{{ __('translations.phone') }}</label>
                                                    </div>
                                                    <div class="col-sm-10 mb-10 mb-sm-10">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                   class="form-control @error('phone') is-invalid @enderror"
                                                                   name="phone"
                                                                   value="{{$constructor_agency->phone }}"
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
                                                        <label class="col-form-label text-gray-900" for="email">{{ __('translations.email') }}</label>
                                                    </div>
                                                    <div class="col-sm-10 mb-10 mb-sm-10">
                                                        <div class="input-group">
                                                            <input type="email"
                                                                   class="form-control @error('email') is-invalid @enderror"
                                                                   name="email" value="{{$constructor_agency->email }}"
                                                                   required autocomplete="email"
                                                                   id="email" placeholder="{{ __('translations.email') }}"
                                                                   autofocus>
                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
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
                                                                    <option value="{{$country->id}}" {{$country->id == $constructor_agency->country_id ? 'selected' : ''}}>{{$country->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-4 mb-4 mb-sm-4">
                                                            <select class="form-control" name="state_id" id="select_state">
                                                                <option value="">{{ __('translations.select') }} {{ __('translations.state') }}</option>
                                                                @foreach($states as $state)
                                                                    <option value="{{$state->id}}" {{$state->id == $constructor_agency->state_id ? 'selected' : ''}}>{{$state->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-4 mb-4 mb-sm-4">
                                                            <select class="form-control" name="city_id" id="select_city">
                                                                <option value="">{{ __('translations.select') }} {{ __('translations.city') }}</option>
                                                                @foreach($cities as $city)
                                                                    <option value="{{$city->id}}" {{$city->id == $constructor_agency->city_id ? 'selected' : ''}}>{{$city->name}}</option>
                                                                @endforeach
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
                                                    <input id="image" type="file" name="image" class="file @error('image') is-invalid @enderror">
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
                            <a href="{{route('constructor_agencies')}}" class="btn btn-sm btn-danger">
                                {{__('translations.cancel')}}
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

        let  image = '{{$constructor_agency->image}}';
        let initialPreview = [];
        let initialPreviewConfig = [];
        if (image){
            initialPreview = ['/storage/uploads/constructor_agencies/' + image];
            initialPreviewConfig = [
                {caption: image, key: 'image'}
            ];
        }
        $("#image").fileinput({
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
            let id = '{{$constructor_agency->id}}'
            let link = '{{$constructor_agency->image}}'
            let type = 'image';
            let kv_file = $(this)
            $.ajax({
                type: "post",
                url: "/admin/agencies/remove-image",
                data: {id:id, type:type, image:link},
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
                            if ('{{$constructor_agency->state_id}}' && '{{$constructor_agency->state_id}}' == city.id) {
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
