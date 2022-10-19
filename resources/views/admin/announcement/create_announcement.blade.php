@extends('layouts.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all"
      rel="stylesheet" type="text/css"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all"
      rel="stylesheet" type="text/css"/>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"
      integrity="sha512-vyxlyD6m54QfZ9PpnWfOHY8Lk3EcN1HuSYalLg3qqnqXLKTbRC/45lvy34WkngM1BUrYuJw1W1ZHlgEpdAn5Xg=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>

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
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="h4 m-0 font-weight-bold text-primary text-center">
                    {{ __('translations.create') }}
                    {{ __('translations.announcement') }}
                </h4>
            </div>
            <div class="card-body">
                <form class="announcements" method="POST" id="dropzoneForm" class="dropzone"
                      action="{{ route( $url, [$category,$type->id])}}" enctype="multipart/form-data">
                    @csrf
                    @if(auth()->user()->hasRole('admin'))
                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                {{__('translations.users')}}
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="user_id" class="form-control" id="user_id">
                                    <option value="">{{__('translations.users')}}</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}" @if(old('user_id') == $user->id) selected @endif>
                                            @if($user->hasRole('super_broker'))
                                                @for($i = 0; $i < count($languages); $i++)
                                                    @if($languages[$i] === app()->getLocale())
                                                        {{$user->translations[$i]->name}}
                                                    @endif
                                                @endfor
                                            @else
                                                {{$user->first_name}} {{$user->last_name}}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if($category === "1")
                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <label class="col-form-label text-gray-900" for="inputAddress">
                                    {{__('translations.price')}}
                                </label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <div class="row">
                                    <div class="col-sm-6 mb-6 mb-sm-6">
                                        <input type="number" min="0" class="form-control @error('price') is-invalid @enderror"
                                               name="price"
                                               value="{{ old('price') }}" autocomplete="price"
                                               placeholder="{{__('translations.price')}}" autofocus>
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 mb-6 mb-sm-6">
                                        <select name="currency" class="form-control @error('currency') is-invalid @enderror" id="currency" >
                                            <option value="">{{__('translations.currency')}}</option>
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}"  @if(old('currency')==$currency->id) selected @endif> {{$currency->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('currency')
                                            <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($category === "2")
                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <label class="col-form-label text-gray-900" for="condition">
                                    {{__('translations.rent_price')}}
                                </label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <div class="row">
                                    <div class="col-sm-4 col-lg-4 col-mg-4">
                                        <input type="number"
                                               class="form-control @error('price') is-invalid @enderror"
                                               name="price" id="rent_price"
                                               placeholder="{{__('translations.price')}}"
                                               value={{old('price')}}>
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4 col-lg-4 col-mg-4">
                                        <select name="currency" class="form-control @error('currency') is-invalid @enderror" id="currency">
                                            <option value="">{{__('translations.currency')}}</option>
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}" @if(old('currency')==$currency->id) selected @endif>
                                                    {{$currency->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('currency')
                                            <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4 col-lg-4 col-mg-4">
                                        <select name="rent_type" class="form-control" id="rent-type">
                                            <option @if(old('rent_type')=="daily_rent") selected @endif value="daily_rent">{{__('translations.daily_rent')}}</option>
                                            <option @if(old('rent_type')=="monthly_rent") selected @endif value="monthly_rent">{{__('translations.monthly_rent')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($type->slug === "apartment" )
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="condominium">
                                {{__('translations.condominium')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('condominium') is-invalid @enderror"
                                   name="condominium" value="{{ old('condominium') }}" autocomplete="condominium"
                                   placeholder="{{__('translations.condominium')}}" autofocus>
                            @error('condominium')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="inputAddress">
                                @if($type->slug !== "house" )
                                    {{__('translations.floor')}}
                                    /
                                @endif
                                @if($type->slug !== "land")
                                    {{__('translations.storeys')}}
                                    /
                                @endif
                                {{__('translations.area')}}
                                @if($type->slug === "house")
                                    /{{__('translations.land_area')}}
                                @endif
                            </label>
                        </div>
                        @if($type->slug !== "house")
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <select name="floor" class="form-control @error('floor') is-invalid @enderror" id="floor">
                                    <option value="">{{__('translations.floor')}}</option>
                                    @for ($i = 1; $i <= 24; $i++)
                                        <option value="{{ $i }}" @if(old('floor') == $i) selected @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('floor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <select name="storeys" class="form-control @error('storeys') is-invalid @enderror" id="storeys">
                                <option value="">{{__('translations.storeys')}}</option>
                                @for ($i = 1; $i <= 24; $i++)
                                    <option value="{{ $i }}" @if(old('storeys') == $i) selected @endif>{{ $i }}</option>
                                @endfor
                            </select>
                            @error('storeys')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <input type="text" class="form-control @error('area') is-invalid @enderror" name="area"
                                   value="{{old('area') }}" autocomplete="area"
                                   placeholder="{{__('translations.area')}}" autofocus>
                            @error('area')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @if($type->slug === "house")
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <input type="text" class="form-control @error('land_area') is-invalid @enderror"
                                       name="land_area" value="{{ old('land_area') }}" autocomplete="land_area"
                                       placeholder="{{__('translations.land_area')}}" autofocus>
                                @error('land_area')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                    </div>
                    @if($type->slug !== "commercial")
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="rooms">{{__('translations.bedrooms')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="rooms" class="form-control @error('rooms') is-invalid @enderror" id="rooms">
                                <option value="">{{__('translations.bedrooms')}}</option>
                                @for ($i = 1; $i <= 7; $i++)
                                    <option value="{{ $i }}" @if(old('rooms') == $i) selected @endif>{{ $i }}</option>
                                @endfor
                            </select>
                            @error('rooms')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="bathroom">{{__('translations.bathrooms')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="bathroom" class="form-control @error('bathroom') is-invalid @enderror" id="bathroom">
                                <option value="">{{__('translations.bathrooms')}}</option>
                                @for ($i = 2; $i <= 8; $i++)
                                    <option value="{{ $i/2 }}" @if(old('bathroom') == $i/2) selected @endif>{{ $i/2 }}</option>
                                @endfor
                            </select>
                            @error('bathrooms')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="building_type">{{__('translations.building_type')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="building_type" class="form-control @error('building_type') is-invalid @enderror" id="building_type">
                                <option value="">{{__('translations.building_type')}}</option>
                                <option @if(old('building_type') == "monolith") selected @endif  value="monolith">{{__('translations.monolith')}}</option>
                                <option @if(old('building_type') == "stone") selected @endif  value="stone">{{__('translations.stone')}}</option>
                                <option @if(old('building_type') == "panel") selected @endif  value="panel">{{__('translations.panel')}}</option>
                                <option @if(old('building_type') == "other") selected @endif  value="other">{{__('translations.other')}}</option>
                            </select>
                            @error('building_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="ceiling_height">{{__('translations.ceiling_height')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="ceiling_height" class="form-control @error('ceiling_height') is-invalid @enderror" id="ceiling_height">
                                <option value="">{{__('translations.ceiling_height')}}</option>
                                <option @if(old('ceiling_height') == "2.5") selected @endif value="2.5">2.5 {{__('translations.m')}}</option>
                                <option @if(old('ceiling_height') == "2.6") selected @endif value="2.6">2.6 {{__('translations.m')}}</option>
                                <option @if(old('ceiling_height') == "2.7") selected @endif value="2.7">2.7 {{__('translations.m')}}</option>
                                <option @if(old('ceiling_height') == "2.75")selected  @endif value="2.75">2.75 {{__('translations.m')}}</option>
                                <option @if(old('ceiling_height') == "2.8") selected @endif value="2.8">2.8 {{__('translations.m')}}</option>
                                <option @if(old('ceiling_height') == "3.0") selected @endif value="3.0">3.0 {{__('translations.m')}}</option>
                                <option @if(old('ceiling_height') == "3.2") selected @endif value="3.2">3.2 {{__('translations.m')}}</option>
                                <option @if(old('ceiling_height') == "3.4") selected @endif value="3.4">3.4 {{__('translations.m')}}</option>
                                <option @if(old('ceiling_height') == "3.5") selected @endif value="3.5">3.5 {{__('translations.m')}}</option>
                                <option @if(old('ceiling_height') == "4.0") selected @endif value="4.0">4.0 {{__('translations.m')}}</option>
                            </select>
                            @error('ceiling_height')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="condition">{{__('translations.condition')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="condition" class="form-control @error('condition') is-invalid @enderror" id="condition">
                                <option value="">{{__('translations.condition')}}</option>
                                <option @if(old('condition') == "zero_condition") selected @endif value="zero_condition">{{__('translations.zero_condition')}}</option>
                                <option @if(old('condition') == "bad") selected @endif value="bad">{{__('translations.bad')}}</option>
                                <option @if(old('condition') == "middle") selected @endif value="middle">{{__('translations.middle')}}</option>
                                <option @if(old('condition') == "good") selected @endif value="good">{{__('translations.good')}}</option>
                                <option @if(old('condition') == "excellent") selected @endif value="excellent">{{__('translations.excellent')}}</option>
                            </select>
                            @error('condition')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="sewer">
                                {{__('translations.sewer')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="sewer" class="form-control @error('sewer') is-invalid @enderror" id="sewer">
                                <option value="">{{__('translations.sewer')}}</option>
                                <option @if(old('sewer') == "individual") selected @endif value="individual">{{__('translations.individual')}}</option>
                                <option @if(old('sewer') == "centralised")selected  @endif value="centralised">{{__('translations.centralised')}}</option>
                                <option @if(old('sewer') == "no_sewer")selected  @endif value="no_sewer">{{__('translations.no_sewer')}}</option>
                            </select>
                            @error('sewer')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="distance_from_metro_station">
                                {{__('translations.distance_from_metro_station')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="distance_from_metro_station" class="form-control @error('distance_from_metro_station') is-invalid @enderror" id="distance_from_metro_station">
                                <option value="">{{__('translations.distance_from_metro_station')}}</option>
                                <option @if(old('distance_from_metro_station') == "0 - 100") selected @endif value="0 - 100">{{__('translations.before')}} 100</option>
                                <option @if(old('distance_from_metro_station') == "100 - 500") selected @endif value="100 - 500">100 - 500</option>
                                <option @if(old('distance_from_metro_station') == "no_metro") selected @endif value="no_metro">{{__('translations.no_metro')}}</option>
                            </select>
                            @error('distance_from_metro_station')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="distance_from_stations">
                                {{__('translations.distance_from_stations')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="distance_from_stations" class="form-control @error('distance_from_stations') is-invalid @enderror" id="distance_from_stations">
                                <option value="">{{__('translations.distance_from_stations')}}</option>
                                <option @if(old('distance_from_stations') == "0-100")selected @endif value="0-100">{{__('translations.before')}} 100</option>
                                <option @if(old('distance_from_stations') == "101-300") selected @endif value="101-300">101 - 300</option>
                                <option @if(old('distance_from_stations') == "301") selected @endif value="301">301 +</option>
                            </select>
                            @error('distance_from_stations')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @if($type->slug === "commercial")
                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <label class="col-form-label text-gray-900" for="land_type">
                                    {{__('translations.land_type')}}
                                </label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="land_type" class="form-control @error('land_type') is-invalid @enderror" id="land_type">
                                    <option value="">{{__('translations.land_type')}}</option>
                                    <option @if(old('land_type') == "shops") selected @endif value="shops">{{__('translations.shops')}}</option>
                                    <option @if(old('land_type') == "offices") selected @endif value="offices">{{__('translations.offices')}}</option>
                                    <option @if(old('land_type') == "services") selected @endif value="services">{{__('translations.services')}}</option>
                                    <option @if(old('land_type') == "other") selected @endif value="other">{{__('translations.other')}}</option>
                                </select>
                                @error('land_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <label class="col-form-label text-gray-900" for="property_place">
                                    {{__('translations.property_place')}}
                                </label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="property_place" class="form-control @error('property_place') is-invalid @enderror" id="property_place">
                                    <option value="">{{__('translations.property_place')}}</option>
                                    <option @if(old('property_place') == "into_building") selected @endif value="into_building">{{__('translations.into_building')}}</option>
                                    <option @if(old('property_place') == "out_of_building") selected @endif  value="out_of_building">{{__('translations.out_of_building')}}</option>
                                </select>
                                @error('property_place')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="distance_from_medical_center">
                                {{__('translations.distance_from_medical_center')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="distance_from_medical_center" class="form-control @error('distance_from_medical_center') is-invalid @enderror" id="distance_from_medical_center">
                                <option value="">{{__('translations.distance_from_medical_center')}}</option>
                                <option @if(old('distance_from_medical_center') == "0-1000") selected @endif value="0-1000">{{__('translations.before')}} 1000</option>
                                <option @if(old('distance_from_medical_center') == "1001") selected @endif value="1001">1001 +</option>
                            </select>
                            @error('distance_from_medical_center')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="furniture">
                                {{__('translations.furniture')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="furniture" class="form-control @error('furniture') is-invalid @enderror" id="furniture">
                                <option value="">{{__('translations.furniture')}}</option>
                                <option @if(old('furniture') == "true") selected @endif value="true">{{__('translations.yes')}}</option>
                                <option @if(old('furniture') == "false") selected @endif value="false">{{__('translations.no')}}</option>
                            </select>
                            @error('furniture')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="year">
                                {{__('translations.year')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="year" class="form-control @error('year') is-invalid @enderror" id="year">
                                <option value="">{{__('translations.year')}}</option>
                                <option @if(old('year') == "0.6")selected @endif value="0.6">{{__('translations.before')}} 6</option>
                                <option @if(old('year') == "7.9")selected @endif value="7.9">7 - 9</option>
                                <option @if(old('year') == "10.12") selected @endif value="10.12">10 - 12</option>
                                <option @if(old('year') == "13.15") selected @endif value="13.15">13 - 15</option>
                                <option @if(old('year') == "16.18") selected @endif value="16.18">16 - 18</option>
                                <option @if(old('year') == "19.21") selected @endif value="19.21">19 - 21</option>
                                <option @if(old('year') == "22.24") selected @endif value="22.24">22 - 24</option>
                                <option @if(old('year') == "25.27") selected @endif value="25.27">25 - 27</option>
                                <option @if(old('year') == "28.30") selected @endif value="28.30">28 - 30</option>
                                <option @if(old('year') == "31.40") selected @endif value="31.40">31 - 40</option>
                                <option @if(old('year') == "41") selected @endif value="41">41 +</option>
                            </select>
                            @error('year')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="cover">
                                {{__('translations.cover')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="cover" class="form-control @error('cover') is-invalid @enderror" id="cover">
                                <option value="">{{__('translations.cover')}}</option>
                                <option @if(old('cover') == "reinforced_concrete") selected @endif value="reinforced_concrete">{{__('translations.reinforced_concrete')}}</option>
                                <option @if(old('cover') == "panel") selected @endif value="panel">{{__('translations.panel')}}</option>
                                <option @if(old('cover') == "wood") selected @endif value="wood">{{__('translations.wood')}}</option>
                            </select>
                            @error('cover')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="degree">
                                {{__('translations.degree')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="degree" class="form-control @error('degree') is-invalid @enderror" id="degree">
                                <option value="">{{__('translations.degree')}}</option>
                                <option @if(old('degree') == "0") selected @endif value="0">0</option>
                                <option @if(old('degree') == "1") selected @endif value="1">1</option>
                                <option @if(old('degree') == "2") selected @endif value="2">2</option>
                                <option @if(old('degree') == "3") selected @endif value="3">3</option>
                                <option @if(old('degree') == "4") selected @endif value="4">4</option>
                            </select>
                            @error('degree')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @if($type->slug !== "commercial")
                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <label class="col-form-label text-gray-900"
                                       for="balcony">{{__('translations.balcony')}}
                                </label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="balcony" class="form-control @error('balcony') is-invalid @enderror" id="balcony">
                                    <option value="">{{__('translations.balcony')}}</option>
                                    <option @if(old('balcony') == "no_balcony") selected @endif value="no_balcony">{{__('translations.no_balcony')}}</option>
                                    <option @if(old('balcony') == "open_balcony") selected @endif value="open_balcony">{{__('translations.open_balcony')}}</option>
                                    <option @if(old('balcony') == "close_balcony") selected @endif value="close_balcony">{{__('translations.close_balcony')}}</option>
                                </select>
                                @error('balcony')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="inputAddress">{{__('translations.address')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                   name="address" id="address" value="{{ old('address') }}"
                                   placeholder="{{__('translations.address')}}" readonly>
                            @error('address')
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
                                            <option value="{{$state->id}}" @if(old('state_id') == $state->id) selected @endif>{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-6 mb-sm-6">
                                    <select name="city_id" class="form-control" id="select_city">
                                        <option value="">{{__('translations.city')}}</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if(old('city_id') == $city->id) selected @endif> {{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <input type="text" id="latitude" name="latitude" value="" hidden>
                            <input type="text" id="longitude" name="longitude" value="" hidden>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <div id="map" style="width: 100%; height: 400px"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="facilities">
                                {{__('translations.facilities')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <div class="row col-form-label ml-0 checkbox-group">
                                @foreach($facilities as $facility)
                                    <div class="col-sm-3 mb-3 mb-sm-3 form-check checkbox">
                                        <input class="form-check-input" id="{{$facility->value}}"
                                               name="facilities[{{$facility->id}}]"
                                               type="checkbox"  @if(old("facilities[".$facility->id."]")) checked="checked" @endif value=true>
                                        <label class="form-check-label" for="{{$facility->value}}">{{$facility->title}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="additional_info">
                                {{__('translations.additional_info')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <div class="row col-form-label ml-0 checkbox-group">
                                @foreach($additional_infos as $additional_info)
                                    <div class="col-sm-3 mb-3 mb-sm-3 form-check checkbox">
                                        <input class="form-check-input" id="{{$additional_info->value}}"
                                               name="additional_infos[{{$additional_info->id}}]"
                                               type="checkbox" value=true
                                               @if(old("additional_infos[".$additional_info->id."]") == true) checked @endif>
                                        <label class="form-check-label" for="{{$additional_info->value}}">
                                            {{$additional_info->title}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
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
                                                <label class="col-form-label text-gray-900" for="additional_text">
                                                    {{__('translations.additional_text')}}
                                                </label>
                                            </div>
                                            <div class="col-sm-9 mb-9 mb-sm-9">
                                                <div class="md-form">
                                                    <textarea id="additional_text_{{$language}}"
                                                              class="md-textarea form-control"
                                                              placeholder="{{__('translations.additional_text')}}"
                                                              rows="3"
                                                              name="additional_text_{{$language}}"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label class="col-form-label text-gray-900" for="certificate">
                                {{ __('translations.certificate') }}
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input id="certificate" type="file" name="certificate"
                                   class="file @error('certificate') is-invalid @enderror">
                            @error('certificate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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
                                <a href="{{route('announcements')}}" class="btn btn-sm btn-danger">
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
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcKtc18Xnw9SX8a2A3e1i_fikfDsBv4LA&libraries=places"></script>
        <script type="text/javascript">
            ymaps.ready(init);

            function init() {
                var myPlacemark,
                    myMap = new ymaps.Map('map', {
                        center: [40.1776121, 44.5125849],
                        zoom: 9
                    }, {
                        searchControlProvider: 'yandex#search'
                    });
                myMap.events.add('click', function (e) {
                    var coords = e.get('coords');
                    let latitude = document.getElementById('latitude');
                    let longitude = document.getElementById('longitude');
                    latitude.value = coords[0];
                    longitude.value = coords[1];
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
                        iconCaption: 'searching...'
                    }, {
                        preset: "islands#redCircleDotIcon",
                        hideIconOnBalloonOpen: false,
                        openEmptyBalloon: true,
                        open: true,
                        iconImageSize: [30, 42],
                        iconImageOffset: [-3, -42],
                    });
                }

                function getAddress(coords) {
                    myPlacemark.properties.set('iconCaption', 'searching...');
                    ymaps.geocode(coords).then(function (res) {
                        var firstGeoObject = res.geoObjects.get(0);
                        let address = document.getElementById('address');
                        address.value = firstGeoObject.getAddressLine();
                        console.log(city.value)
                        myPlacemark.properties
                            .set({
                                iconCaption: [
                                    firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                                    firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                                ].filter(Boolean).join(', '),
                                balloonContent: firstGeoObject.getAddressLine()
                            });
                    });
                }
            }

        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript">
            var geocoder = new google.maps.Geocoder();

            function geocodeAddress(geocoder, state, city = null) {
                const address = city ? state + ', ' + city : state;
                geocoder
                    .geocode({address: address})
                    .then(({results}) => {
                        const coordinates = results[0].geometry.location.lat() + '_' + results[0].geometry.location.lng()
                        if (city) {
                            document.getElementById('city').value = coordinates
                        } else {
                            document.getElementById('state').value = coordinates
                        }
                    })
                    .catch((e) =>
                        alert("Geocode was not successful for the following reason: " + e)
                    );

            }
            console.log(document.getElementById('images').value)
            $("#images").fileinput({
                theme: 'fa',
                uploadUrl: false,
                allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
                overwriteInitial: false,
                maxFileSize: 90000,
                maxFilesNum: 10,
            });

            $("#main_image").fileinput({
                theme: 'fa',
                showUpload: false,
                uploadUrl: false,
                allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
                overwriteInitial: false,
                maxFileSize: 90000,
                maxFilesNum: 1,
            });
            $("#certificate").fileinput({
                theme: 'fa',
                showUpload: false,
                uploadUrl: false,
                allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
                overwriteInitial: false,
                maxFileSize: 90000,
                maxFilesNum: 1,
            });
            $('#select_state').on('change', function (e) {
                $.ajax({
                    type: "post",
                    url: "/admin/settings/cities/city_by_state_id",
                    data: {"_token": "{{ csrf_token() }}", state_id: e.target.value},
                    dataType: 'json',
                    success: function (data) {
                        geocodeAddress(geocoder, data.state.name)
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
            $('#start_datepicker').datepicker({
                weekStart: 1,
                daysOfWeekHighlighted: "6,0",
                autoclose: true,
                todayHighlight: true,

            });
            $('#start_datepicker').datepicker("setDate", new Date());
            $('#end_datepicker').datepicker({
                weekStart: 1,
                daysOfWeekHighlighted: "6,0",
                autoclose: true,
                todayHighlight: true,
            });
            $('#end_datepicker').datepicker("setDate", new Date());
        </script>
@endsection

