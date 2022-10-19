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
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="h4 m-0 font-weight-bold text-primary text-center">
                    {{ __('translations.create') }}
                    {{ __('translations.announcement') }}
                </h4>
            </div>
            <div class="card-body">
                <form class="announcements" method="POST" id="dropzoneForm" class="dropzone" action="{{ route('store_land_announcement',[$category,$type->id])}}" enctype="multipart/form-data">
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
                                        <option value="{{$user->id}}" @if(old('user_id') == $user->id) selected @endif> {{$user->first_name}} {{$user->last_name}}</option>
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
                                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                                               name="price"
                                               min="0"
                                               value="{{ old('price') }}" autocomplete="price"
                                               placeholder="{{__('translations.price')}}" autofocus>
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 mb-6 mb-sm-6">
                                        <select name="currency" class="form-control @error('currency') is-invalid @enderror" id="currency">
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
                                                <option value="{{$currency->id}}"  @if(old('currency')==$currency->id) selected @endif> {{$currency->name}}</option>
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
                                            <option  @if(old('rent_type')=="daily_rent") selected @endif value="daily_rent">{{__('translations.daily_rent')}}</option>
                                            <option  @if(old('rent_type')=="monthly_rent") selected @endif value="monthly_rent">{{__('translations.monthly_rent')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="inputAddress">
                                {{__('translations.land_area')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" min="0" class="form-control @error('area') is-invalid @enderror" name="area"
                                   value="{{ old('area') }}" autocomplete="area"
                                   placeholder="{{__('translations.land_area')}}" autofocus>
                            @error('land_area')
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
                                <option @if(old('sewer')=="individual") selected @endif value="individual">{{__('translations.individual')}}</option>
                                <option @if(old('sewer')=="centralised") selected @endif value="centralised">{{__('translations.centralised')}}</option>
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
                                <option @if(old('distance_from_metro_station')=="0 - 100") selected @endif value="0 - 100">{{__('translations.before')}} 100</option>
                                <option @if(old('distance_from_metro_station')=="100 - 500") selected @endif value="100 - 500">100 - 500</option>
                                <option @if(old('distance_from_metro_station')=="no_metro") selected @endif value="no_metro">{{__('translations.no_metro')}}</option>
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
                            <label class="col-form-label text-gray-900" for="distance_from_metro_station">
                                {{__('translations.distance_from_stations')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="distance_from_stations" class="form-control @error('distance_from_stations') is-invalid @enderror" id="distance_from_stations">
                                <option value="">{{__('translations.distance_from_stations')}}</option>
                                <option @if(old('distance_from_stations')=="0-100") selected @endif value="0-100">{{__('translations.before')}} 100</option>
                                <option @if(old('distance_from_stations')=="101-300") selected @endif value="101-300">101 - 300</option>
                                <option @if(old('distance_from_stations')=="301") selected @endif value="301">301 +</option>
                            </select>
                            @error('distance_from_stations')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="distance_from_medical_center">
                                {{__('translations.distance_from_medical_center')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="distance_from_medical_center" class="form-control @error('distance_from_medical_center') is-invalid @enderror" id="distance_from_medical_center">
                                <option value="">{{__('translations.distance_from_medical_center')}}</option>
                                <option @if(old('distance_from_medical_center')=="0-1000") selected @endif value="0-1000">{{__('translations.before')}} 1000</option>
                                <option @if(old('distance_from_medical_center')=="1001") selected @endif value="1001">1001 +</option>
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
                            <label class="col-form-label text-gray-900" for="land_geometric">{{__('translations.land_geometric')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="land_geometric_appearance" class="form-control @error('land_geometric_appearance') is-invalid @enderror" id="land_geometric_appearance">
                                <option value="">{{__('translations.land_geometric')}}</option>
                                <option @if(old('land_geometric_appearance')=="0-2") selected @endif value="0-2">{{__('translations.smooth')}}</option>
                                <option @if(old('land_geometric_appearance')=="2-5") selected @endif value="2-5">2 - 5 {{__('translations.degrees')}}</option>
                                <option @if(old('land_geometric_appearance')=="5-10") selected @endif value="5-10">5 - 10 {{__('translations.stone')}}</option>
                            </select>
                        </div>
                        @error('land_geometric_appearance')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="front_position">{{__('translations.front_position')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="front_position" class="form-control @error('front_position') is-invalid @enderror" id="front_position">
                                <option value="">{{__('translations.front_position')}}</option>
                                <option @if(old('front_position')=="primary_secondary") selected @endif value="primary_secondary">{{__('translations.primary_and_secondary')}}</option>
                                <option @if(old('front_position')=="primary") selected @endif value="primary">{{__('translations.primary')}}</option>
                                <option @if(old('front_position')=="secondary") selected @endif value="secondary">{{__('translations.secondary')}}</option>
                            </select>
                            @error('front_position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="purpose">{{__('translations.front_position_length')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="number" class="form-control @error('front_position_length') is-invalid @enderror" name="front_position_length"
                                   value="{{ old('front_position_length') }}" autocomplete="area"
                                   placeholder="{{__('translations.front_position_length')}}" autofocus>
                            @error('front_position_length')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="road_type">{{__('translations.road_type')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="road_type" class="form-control @error('road_type') is-invalid @enderror" id="road_type">
                                <option value=''>{{__('translations.road_type')}}</option>
                                <option @if(old('road_type')=="asphalt") selected @endif value='asphalt'>{{__('translations.asphalt')}}</option>
                                <option @if(old('road_type')=="ground") selected @endif value='ground'>{{__('translations.ground')}}</option>
                            </select>
                            @error('road_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="infrastructure">{{__('translations.infrastructure')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="infrastructure" class="form-control @error('infrastructure') is-invalid @enderror" id="infrastructure">
                                <option value=''>{{__('translations.infrastructure')}}</option>
                                <option @if(old('infrastructure')=="all_available") selected @endif value='all_available'>{{__('translations.all_available')}}</option>
                                <option @if(old('infrastructure')=="no_communication") selected @endif value='no_communication'>{{__('translations.no_communication')}}</option>
                                <option @if(old('infrastructure')=="all_available_except_irrigation_water") selected @endif value='all_available_except_irrigation_water'>{{__('translations.all_available_except_irrigation_water')}}</option>
                            </select>
                            @error('infrastructure')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="fence_type">{{__('translations.fence_type')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="fence_type" class="form-control @error('fence_type') is-invalid @enderror" id="fence_type">
                                <option value=''>{{__('translations.fence_type')}}</option>
                                <option @if(old('fence_type')=="partly_fenced") selected @endif value='partly_fenced'>{{__('translations.partly_fenced')}}</option>
                                <option @if(old('fence_type')=="stone_fence") selected @endif value='stone_fence'>{{__('translations.stone_fence')}}</option>
                                <option @if(old('fence_type')=="no_fence") selected @endif value='no_fence'>{{__('translations.no_fence')}}</option>
                            </select>
                            @error('fence_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="purpose">{{__('translations.purpose')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="purpose" class="form-control @error('purpose') is-invalid @enderror" id="purpose">
                                <option value=''>{{__('translations.purpose')}}</option>
                                <option @if(old('purpose')=="public_construction_of_settlements") selected @endif value='public_construction_of_settlements'>{{__('translations.public_construction_of_settlements')}}</option>
                                <option @if(old('purpose')=="residential_construction_of_settlements") selected @endif value='residential_construction_of_settlements'>{{__('translations.residential_construction_of_settlements')}}</option>
                                <option @if(old('purpose')=="mixed_construction_of_settlements") selected @endif value='mixed_construction_of_settlements'>{{__('translations.mixed_construction_of_settlements')}}</option>
                            </select>
                            @error('purpose')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="building">{{__('translations.building')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="building" class="form-control @error('building') is-invalid @enderror" id="building">
                                <option value=''>{{__('translations.building')}}</option>
                                <option @if(old('building')=="all_available") selected @endif value='all_available'>{{__('translations.there_is_building')}}</option>
                                <option @if(old('building')=="no_communication") selected @endif value='no_communication'>{{__('translations.there_is_not_building')}}</option>
                            </select>
                            @error('building')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="inputAddress">{{__('translations.address')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                   name="address" id="address" value="{{old("address")}}" placeholder="{{__('translations.address')}}"
                                   readonly>
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
                                            <option value="{{$state->id}}" @if(old('state_id')==$state->id) selected @endif> {{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-6 mb-sm-6">
                                    <select name="city_id" class="form-control" id="select_city">
                                        @foreach($cities as $city)
                                            <option @if(old('city_id')==$city->id) selected @endif value="{{$city->id}}"> {{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <input type="text" id="latitude" name="latitude" hidden>
                            <input type="text" id="longitude" name="longitude" hidden>
                            <input type="text" id="region" name="region" hidden>
                            <input type="text" id="city" name="city" hidden>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <div id="map" style="width: 100%; height: 400px"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="additional_text">
                                {{__('translations.description')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <div class="md-form">
                                <textarea id="description" class="md-textarea form-control" placeholder="{{__('translations.description')}}" rows="3" name="description">{{old("description")}}</textarea>
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
                        let region = document.getElementById('region');
                        let city = document.getElementById('city');
                        address.value = firstGeoObject.getAddressLine();
                        region.value = firstGeoObject.getAdministrativeAreas();
                        city.value = firstGeoObject.getLocalities();
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
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcKtc18Xnw9SX8a2A3e1i_fikfDsBv4LA&libraries=places"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript">

            var geocoder = new google.maps.Geocoder();
            function geocodeAddress(geocoder,state,city =null) {
                const address = city? state + ', ' + city: state;
                geocoder
                    .geocode({ address: address })
                    .then(({ results }) => {
                        const coordinates = results[0].geometry.location.lat() + '_' + results[0].geometry.location.lng()
                        if(city){
                            document.getElementById('city').value = coordinates
                        }else {
                            document.getElementById('state').value = coordinates
                        }
                    })
                    .catch((e) =>
                        alert("Geocode was not successful for the following reason: " + e)
                    );

            }
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
                console.log(e.target.value)
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

