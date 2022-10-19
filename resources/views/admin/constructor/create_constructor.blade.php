@extends('layouts.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all"
      rel="stylesheet" type="text/css"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all"
      rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" integrity="sha512-vyxlyD6m54QfZ9PpnWfOHY8Lk3EcN1HuSYalLg3qqnqXLKTbRC/45lvy34WkngM1BUrYuJw1W1ZHlgEpdAn5Xg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="h4 m-0 font-weight-bold text-primary text-center">
                    {{ __('translations.create') }}
                    {{ __('translations.constructor') }}
                </h4>
            </div>
            <div class="card-body">
                <form class="announcements" method="POST" id="dropzoneForm" class="dropzone"
                      action="{{ route('store_constructor')}}" enctype="multipart/form-data">
                    @csrf

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
                                    <div class='{{$language === app()->getLocale()? "tab-pane active":"tab-pane"}}' id="{{$language}}" role="tabpanel">
                                        <div class="form-group row">
                                            <div class="col-sm-3 mb-3 mb-sm-3">
                                                <label class="col-form-label text-gray-900" for="property_name_{{$language}}">{{__('translations.property_name')}}</label>
                                            </div>
                                            <div class="col-sm-9 mb-9 mb-sm-9">
                                                <input type="text"
                                                       class="form-control @error('property_name_'.$language) is-invalid @enderror"
                                                       name="property_name_{{$language}}"
                                                       value="{{ old('property_name_'.$language) }}"
                                                       autocomplete="property_name_{{$language}}"
                                                       placeholder="{{__('translations.property_name')}}" autofocus>
                                                @error('property_name_'.$language)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3 mb-3 mb-sm-3">
                                                <label class="col-form-label text-gray-900" for="sub_title_{{$language}}">{{__('translations.sub_title')}}</label>
                                            </div>
                                            <div class="col-sm-9 mb-9 mb-sm-9">
                                                <input type="text"
                                                       class="form-control @error('sub_title_'.$language) is-invalid @enderror"
                                                       name="sub_title_{{$language}}"
                                                       value="{{ old('sub_title_'.$language) }}"
                                                       autocomplete="sub_title_{{$language}}"
                                                       placeholder="{{__('translations.sub_title')}}" autofocus>
                                                @error('sub_title_'.$language)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3 mb-3 mb-sm-3">
                                                <label class="col-form-label text-gray-900" for="property_description_{{$language}}">{{__('translations.description')}}</label>
                                            </div>
                                            <div class="col-sm-9 mb-9 mb-sm-9">
                                                <div class="md-form">
                                                    <textarea id="property_description_{{$language}}"
                                                              class="editor md-textarea form-control @error('property_description_'.$language) is-invalid @enderror"
                                                              placeholder="{{__('translations.description')}}" rows="3"
                                                              name="property_description_{{$language}}">{{old('property_description_'.$language)}}</textarea>
                                                    @error('property_description_'.$language)
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3 mb-3 mb-sm-3">
                                                <label class="col-form-label text-gray-900"
                                                       for="features_{{$language}}">
                                                    {{__('translations.features')}}
                                                </label>
                                            </div>
                                            <div class="col-sm-9 mb-9 mb-sm-9">
                                                <div class="md-form">
                                                    <textarea id="features_{{$language}}"
                                                              class="editor md-textarea form-control @error('features_'.$language) is-invalid @enderror"
                                                              placeholder="{{__('translations.features')}}" rows="3"
                                                              name="features_{{$language}}">{{old('features_'.$language)}}</textarea>
                                                    @error('features_'.$language)
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3 mb-3 mb-sm-3">
                                                <label class="col-form-label text-gray-900" for="renovation_{{$language}}">
                                                    {{__('translations.renovation')}}
                                                </label>
                                            </div>
                                            <div class="col-sm-9 mb-9 mb-sm-9">
                                                <div class="md-form">
                                                    <textarea id="renovation_{{$language}}"
                                                              class="editor md-textarea form-control @error('renovation_'.$language) is-invalid @enderror"
                                                              placeholder="{{__('translations.renovation')}}" rows="3"
                                                              name="renovation_{{$language}}">{{old('renovation_'.$language)}}</textarea>
                                                    @error('renovation_'.$language)
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="price">{{__('translations.price')}}</label>
                        </div>
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <input type="number" class="form-control @error('price_start') is-invalid @enderror"
                                   name="price_start" value="{{ old('price_start') }}" autocomplete="price_start"
                                   placeholder="{{__('translations.price_start')}}" autofocus>
                            @error('price_start')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div>-</div>
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <input type="number" class="form-control @error('price_end') is-invalid @enderror"
                                   name="price_end" value="{{ old('price_end') }}" autocomplete="price_end"
                                   placeholder="{{__('translations.price_end')}}" autofocus>
                            @error('price_end')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-sm-2 mb-2 mb-sm-2">
                            <select name="currency" class="form-control" id="currency">
                                <option value="">{{__('translations.currency')}}</option>
                                @foreach($currencies as $currency)
                                    <option value="{{$currency->id}}" @if(old('currency')==$currency->id) selected @endif > {{$currency->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="lot">{{__('translations.lot')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('lot') is-invalid @enderror" name="lot"
                                   value="{{ old('lot') }}" autocomplete="lot" placeholder="{{__('translations.lot')}}"
                                   autofocus>
                            @error('lot')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="area">{{__('translations.area')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" step="0.01" class="form-control @error('area') is-invalid @enderror" name="area" value="{{ old('area') }}" autocomplete="area" placeholder="{{__('translations.area')}}" autofocus>
                            @error('area')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="rooms">{{__('translations.rooms')}}</label>
                        </div>
                        <div class="col-sm-4 mb-4 mb-sm-4">
                            <input type="number" class="form-control @error('min_room') is-invalid @enderror" name="min_room" value="{{ old('min_room') }}" autocomplete="min_room" placeholder="{{__('translations.min_room')}}" autofocus step="0.01">
                            @error('min_room')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div>-</div>
                        <div class="col-sm-4 mb-4 mb-sm-4">
                            <input type="number" class="form-control @error('max_room') is-invalid @enderror" name="max_room" value="{{ old('max_room') }}" autocomplete="max_room" placeholder="{{__('translations.max_room')}}" autofocus step="0.01">
                            @error('max_room')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="apartment_counts">{{__('translations.apartment_counts')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('apartment_counts') is-invalid @enderror"
                                   name="apartment_counts" value="{{ old('apartment_counts') }}" autocomplete="apartment_counts"
                                   placeholder="{{__('translations.apartment_counts')}}" autofocus>
                            @error('apartment_counts')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="sold_apartments">{{__('translations.sold_apartments')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('sold_apartments') is-invalid @enderror"
                                   name="sold_apartments" value="{{ old('sold_apartments') }}" autocomplete="sold_apartments"
                                   placeholder="{{__('translations.sold_apartments')}}" autofocus>
                            @error('sold_apartments')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="reserved_apartments">{{__('translations.reserved_apartments')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('reserved_apartments') is-invalid @enderror"
                                   name="reserved_apartments" value="{{ old('reserved_apartments') }}" autocomplete="reserved_apartments"
                                   placeholder="{{__('translations.reserved_apartments')}}" autofocus>
                            @error('reserved_apartments')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="available_apartments">{{__('translations.available_apartments')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('available_apartments') is-invalid @enderror"
                                   name="available_apartments" value="{{ old('available_apartments') }}" autocomplete="available_apartments"
                                   placeholder="{{__('translations.available_apartments')}}" autofocus>
                            @error('available_apartments')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="parking">{{__('translations.parking')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('parking') is-invalid @enderror" name="parking"
                                   value="{{ old('parking') }}" autocomplete="parking" placeholder="{{__('translations.parking')}}"
                                   autofocus>
                            @error('parking')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="available_parking">{{__('translations.available_parking')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('available_parking') is-invalid @enderror"
                                   name="available_parking" value="{{ old('available_parking') }}"
                                   autocomplete="available_parking" placeholder="{{__('translations.available_parking')}}"
                                   autofocus>
                            @error('available_parking')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="underground_parking">{{__('translations.underground_parking')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('underground_parking') is-invalid @enderror"
                                   name="underground_parking" value="{{ old('underground_parking') }}"
                                   autocomplete="underground_parking" placeholder="{{__('translations.underground_parking')}}"
                                   autofocus>
                            @error('underground_parking')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="available_underground_parking">{{__('translations.available_underground_parking')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('available_underground_parking') is-invalid @enderror"
                                   name="available_underground_parking" value="{{ old('available_underground_parking') }}"
                                   autocomplete="available_underground_parking" placeholder="{{__('translations.available_underground_parking')}}"
                                   autofocus>
                            @error('available_underground_parking')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="office_space">{{__('translations.office_space')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('office_space') is-invalid @enderror"
                                   name="office_space" value="{{ old('office_space') }}"
                                   autocomplete="office_space" placeholder="{{__('translations.office_space')}}"
                                   autofocus>
                            @error('office_space')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="available_office_space">{{__('translations.available_office_space')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('available_office_space') is-invalid @enderror"
                                   name="available_office_space" value="{{ old('available_office_space') }}"
                                   autocomplete="available_office_space" placeholder="{{__('translations.available_office_space')}}"
                                   autofocus>
                            @error('available_office_space')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="construction_deadline">{{__('translations.construction_deadline')}}</label>
                        </div>
                        <div class="col-sm-4 mb-4 mb-sm-4">
                            <input data-date-format="dd-mm-yyyy" id="start_datepicker"
                                   class="form-control @error('start_date') is-invalid @enderror" name="start_date"
                                   value="{{ old('start_date') }}" autocomplete="start_date"
                                   placeholder="{{__('translations.start_date')}}" autofocus>
                            @error('start_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div>-</div>
                        <div class="col-sm-4 mb-4 mb-sm-4">
                            <input data-date-format="dd-mm-yyyy" id="end_datepicker"
                                   class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                                   value="{{ old('end_date') }}" autocomplete="end_date"
                                   placeholder="{{__('translations.end_date')}}" autofocus>
                            @error('end_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="constructor_agency">{{__('translations.brokers_company')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="constructor_agency" class="form-control  @error('constructor_agency') is-invalid @enderror" id="constructor_agency">
                                <option>{{__('translations.brokers_company')}}</option>
                                @foreach($constructor_agencies as $constructor_agency)
                                    <option value="{{$constructor_agency->id}}" @if(old('constructor_agency')==$constructor_agency->id) selected @endif >
                                        @for($i = 0; $i < count($languages); $i++)
                                                @if($languages[$i] === app()->getLocale())
                                                    {{$constructor_agency->translations[$i]->name}}
                                                @endif
                                        @endfor
                                    </option>
                                @endforeach
                            </select>
                            @error('constructor_agency')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="property_type">{{__('translations.property_type')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="property_type" class="form-control  @error('property_type') is-invalid @enderror" id="property_type">
                                <option></option>
                                <option value="house" @if(old('property_type')=='house') selected @endif>{{__('translations.house')}}</option>
                                <option value="building"  @if(old('property_type')=='building') selected @endif>{{__('translations.building')}}</option>
                            </select>
                            @error('property_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="floor_height">{{__('translations.floor_height')}} ( {{__('translations.m')}} )</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('floor_height') is-invalid @enderror"
                                   name="floor_height" value="{{ old('floor_height') }}"
                                   autocomplete="floor_height" placeholder="{{__('translations.floor_height')}}"
                                   autofocus step="0.01">
                            @error('floor_height')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="storeys">{{__('translations.storeys')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="storeys" class="form-control @error('storeys') is-invalid @enderror" id="storeys">
                                <option>{{__('translations.storeys')}}</option>
                                @for ($i = 1; $i <= 25; $i++)
                                    <option @if(old('storeys')==$i) selected @endif
                                        value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('storeys')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="live_video_url">
                                {{__('translations.live_video_url')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="text" class="form-control @error('live_video_url') is-invalid @enderror"
                                   name="live_video_url" value="{{ old('live_video_url') }}" autocomplete="live_video_url"
                                   placeholder="{{__('translations.live_video_url')}}" autofocus>
                            @error('live_video_url')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="distance_from_school">
                                {{__('translations.distance_from_school')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="distance_from_school" class="form-control @error('distance_from_school') is-invalid @enderror"
                                    id="distance_from_school">
                                <option value="">{{__('translations.distance_from_school')}}</option>
                                <option value="0-300" @if(old('distance_from_school')=='0-300') selected @endif>
                                    {{__('translations.before')}} 300
                                </option>
                                <option value="301-900" @if(old('distance_from_school')=='301-900') selected @endif>
                                    300 - 900
                                </option>
                                <option value="901" @if(old('distance_from_school')=='901') selected @endif>
                                    900 +
                                </option>
                            </select>
                            @error('distance_from_school')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="distance_from_kindergarten">
                                {{__('translations.distance_from_kindergarten')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="distance_from_kindergarten" class="form-control   @error('distance_from_kindergarten') is-invalid @enderror"
                                    id="distance_from_kindergarten">
                                <option value="">{{__('translations.distance_from_kindergarten')}}</option>
                                <option value="0-300" @if(old('distance_from_kindergarten')=='0-300') selected @endif>
                                    {{__('translations.before')}} 300
                                </option>
                                <option value="301-900" @if(old('distance_from_kindergarten')=='301-900') selected @endif>
                                    300 - 900
                                </option>
                                <option value="901" @if(old('distance_from_kindergarten')=='901') selected @endif>
                                    900 +
                                </option>
                            </select>
                            @error('distance_from_kindergarten')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="distance_from_supermarket">
                                {{__('translations.distance_from_supermarket')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="distance_from_supermarket" class="form-control   @error('distance_from_supermarket') is-invalid @enderror"
                                    id="distance_from_supermarket">
                                <option value="">{{__('translations.distance_from_supermarket')}}</option>
                                <option value="0-300" @if(old('distance_from_supermarket')=='0-300') selected @endif>
                                    {{__('translations.before')}} 300
                                </option>
                                <option value="301-900" @if(old('distance_from_supermarket')=='301-900') selected @endif>
                                    300 - 900
                                </option>
                                <option value="901" @if(old('distance_from_supermarket')=='901') selected @endif>
                                    900 +
                                </option>
                            </select>
                            @error('distance_from_supermarket')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="distance_from_pharmacy">
                                {{__('translations.distance_from_pharmacy')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="distance_from_pharmacy" class="form-control  @error('distance_from_pharmacy') is-invalid @enderror"
                                    id="distance_from_pharmacy">
                                <option value="">{{__('translations.distance_from_pharmacy')}}</option>
                                <option value="0-300" @if(old('distance_from_pharmacy')=='0-300') selected @endif>
                                    {{__('translations.before')}} 300
                                </option>
                                <option value="301-900" @if(old('distance_from_pharmacy')=='301-900') selected @endif>
                                    300 - 900
                                </option>
                                <option value="901" @if(old('distance_from_pharmacy')=='901') selected @endif>
                                    900 +
                                </option>
                            </select>
                            @error('distance_from_pharmacy')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            {{__('translations.region')}} / {{__('translations.city')}}
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <div class="row">
                                <input name="state" id="state" type="text" value="40.1872023_44.515209" hidden>
                                <input name="city" id="city" type="text" value="" hidden>
                                <div class="col-sm-6 mb-6 mb-sm-6">
                                    <select name="state_id" class="form-control" id="select_state">
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" >{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-6 mb-sm-6">
                                    <select name="city_id" class="form-control" id="select_city" >
                                        <option value="">{{__('translations.city')}}</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if(old('city_id')==$city->id) selected @endif > {{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="address">{{__('translations.address')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="text" class="form-control @error('address_en') is-invalid @enderror" value="{{ old('address_en') }}"
                                   name="address_en" id="address_en" placeholder="{{__('translations.address')}}" readonly>
                            <input type="text" class="form-control" name="address_ru" id="address_ru" value="{{ old('address_ru') }}" readonly hidden>
                            <input type="text" class="form-control" name="address_am" id="address_am" value="{{ old('address_am') }}" readonly hidden>
                            @error('address_en')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" hidden>
                            <input type="text" id="longitude" name="longitude"  value="{{ old('longitude') }}" hidden>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <div id="map" style="width: 100%; height: 400px"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label class="col-form-label text-gray-900" for="main_image">
                                {{ __('translations.main_image') }}
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input id="main_image" type="file" name="main_image"
                                   class="file @error('main_image') is-invalid @enderror">
                            @error('main_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="images">
                                {{ __('translations.images') }}
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input id="images" type="file" name="images[]" multiple class="file">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <div class="card-footer text-center">
                                <button class="btn btn-sm btn-success" type="submit">
                                    {{ __('translations.submit_person') }}
                                </button>
                                <a href="{{route('constructors')}}" class="btn btn-sm btn-danger">
                                    {{ __('translations.cancel') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js"
                type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js"
                type="text/javascript"></script>
        <script src="https://api-maps.yandex.ru/2.1/?apikey=26d57744-0383-4385-b157-eb26b080da07&lang=en_RU"
                type="text/javascript"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript">
            ymaps.ready(init);

            function init() {
                let latitude = document.getElementById('latitude');
                let longitude = document.getElementById('longitude');
                myMap = new ymaps.Map('map', {
                        center:[40.1776121, 44.5125849],
                        zoom: 9
                    },{
                        searchControlProvider: 'yandex#search'
                    },
                );
                var myPlacemark = createPlacemark([latitude.value, longitude.value]);
                myMap.geoObjects.add(myPlacemark);
                myPlacemark.events.add('dragend', function () {
                    getAddress(myPlacemark.geometry.getCoordinates());
                });
                myMap.events.add('click', function (e) {
                    var coords = e.get('coords');
                    document.getElementById('latitude').value = coords[0];
                    document.getElementById('longitude').value = coords[1];
                    if (myPlacemark) {
                        myPlacemark.geometry.setCoordinates(coords);
                    } else {
                        myPlacemark = createPlacemark(coords);
                        myMap.geoObjects.add(myPlacemark);
                        myPlacemark.events.add('dragend', function () {
                            getAddress(myPlacemark.geometry.getCoordinates());
                        });
                    }
                    getAddress(coords);
                });

                function createPlacemark(coords) {
                    return new ymaps.Placemark(coords, {
                        iconCaption: document.getElementById('address_en').value
                    }, {
                        preset: "islands#redCircleDotIcon",
                        hideIconOnBalloonOpen: false,
                        openEmptyBalloon: false,
                        open: true,
                        iconImageSize: [30, 42],
                        iconImageOffset: [-3, -42],
                    });
                }
                function getAddress(coords) {
                    myPlacemark.properties.set('iconCaption', 'searching...');
                    ymaps.geocode(coords).then(function (res) {
                        var firstGeoObject = res.geoObjects.get(0);
                        let address_en = document.getElementById('address_en');
                        let address_ru = document.getElementById('address_ru');
                        let address_am = document.getElementById('address_am');
                        address_en.value = firstGeoObject.getAddressLine();
                        address_ru.value = firstGeoObject.getAddressLine();
                        address_am.value = firstGeoObject.getAddressLine();
                        myPlacemark.properties
                            .set({
                                iconCaption: [
                                    firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                                    firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                                ].filter(Boolean).join(', '),
                                balloonContent: firstGeoObject.getAddressLine(),
                            });
                    });
                }
            }

        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.editor').summernote();
            });
            $('#select_state').on('change', function (e) {
                $.ajax({
                    type: "post",
                    url: "/admin/settings/cities/city_by_state_id",
                    data: {"_token": "{{ csrf_token() }}", state_id: e.target.value},
                    dataType: 'json',
                    success: function (data) {
                        $('#select_city').empty();
                        $('#select_city').append('<option value="">{{__("translations.city")}}</option>');
                        if (data && data.cities) {
                            $.each(data.cities, function (key, city) {
                                $('#select_city').append('<option value="' + city.id + '">' + city.name + '</option>');
                            });
                        }
                    },
                    error: function (data) {

                    }
                });
            });
            $('#select_city').on('change', function (e) {
                const state_id = document.getElementById('select_state').value;
                $.ajax({
                    type: "post",
                    url: "/admin/settings/cities/city_and_state_by_id",
                    data: {"_token": "{{ csrf_token() }}", city_id: e.target.value, state_id: state_id},
                    dataType: 'json',
                    success: function (data) {
                        geocodeAddress(geocoder, data.state.name, data.city.name)
                    },
                    error: function (data) {

                    }
                });
            });

            $("#images").fileinput({
                theme: 'fa',
                uploadUrl: false,
                allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
                overwriteInitial: false,
                maxFileSize: 400000,
                maxFilesNum: 10,
            });

            $("#main_image").fileinput({
                theme: 'fa',
                showUpload: false,
                uploadUrl: false,
                allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
                overwriteInitial: false,
                maxFileSize: 400000,
                maxFilesNum: 1,
            });
            $('#start_datepicker').css('cursor','pointer');
            $('#end_datepicker').css('cursor','pointer');
            $('#start_datepicker').datepicker({
                weekStart: 1,
                daysOfWeekHighlighted: "6,0",
                autoClose: true,
                todayHighlight: true,

            });
            $('#start_datepicker').datepicker("setDate");
            $('#end_datepicker').datepicker({
                weekStart: 1,
                daysOfWeekHighlighted: "6,0",
                autoClose: true,
                todayHighlight: true,
            });
            $('#end_datepicker').datepicker("setDate");


        </script>

@endsection

