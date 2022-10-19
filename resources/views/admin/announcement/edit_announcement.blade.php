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

    .kv-file-upload, .file-upload-indicator, .kv-file-download, .file-drag-handle {
        visibility: hidden !important;
    }
</style>
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="h4 m-0 font-weight-bold text-primary text-center">
                    {{ __('translations.edit') }}
                    {{ __('translations.announcement') }}
                </h4>
            </div>
            <div class="card-body">
                <form class="announcements" method="POST" id="dropzoneForm" class="dropzone" action="{{ route( $url, $announcement->id)}}" enctype="multipart/form-data">
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
                                        <option value="{{$user->id}}" @if($announcement->user_id == $user->id) selected @endif>
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
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="inputAddress">
                                {{__('translations.user')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <div class="row">
                                <div class="col-sm-6 mb-6 mb-sm-6">
                                    <b>
                                        <i>
                                            {{$announcement->user->first_name}} {{$announcement->user->last_name}}
                                        </i>
                                    </b>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($announcement->category_id == 1)
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
                                               value="{{ $announcement->price }}" autocomplete="price"
                                               placeholder="{{__('translations.price')}}" autofocus>
                                        @error('price')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 mb-6 mb-sm-6">
                                        <select name="currency" class="form-control @error('currency') is-invalid @enderror" id="currency">
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}" {{$currency->id == $announcement->currency_id ? "selected" : ""}}> {{$currency->name}}</option>
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
                    @if($announcement->category_id === 2)
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
                                               value={{$announcement->price}}>
                                        @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                         </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4 col-lg-4 col-mg-4">
                                        <select name="currency" class="form-control" id="currency" @error('currency') is-invalid @enderror>
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}" {{$currency->id == $announcement->currency_id ? "selected" : ""}}> {{$currency->name}}</option>
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
                                            <option {{$announcement->rent_type == "daily_rent" ? "selected" : ""}} value="daily_rent">{{__('translations.daily_rent')}}</option>
                                            <option {{$announcement->rent_type == "monthly_rent" ? "selected" : ""}} value="monthly_rent">{{__('translations.monthly_rent')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($announcement->type_id === 2)
                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <label class="col-form-label text-gray-900" for="condominium">
                                    {{__('translations.condominium')}}
                                </label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <input type="number" class="form-control @error('condominium') is-invalid @enderror"
                                       name="condominium" value="{{ $announcement->condominium }}" autocomplete="condominium"
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
                                @if($announcement->type->slug === "apartment" || $announcement->type->slug === "commercial")
                                    {{__('translations.floor')}}
                                    /
                                @endif
                                @if($announcement->type->slug !== "land")
                                    {{__('translations.storeys')}}
                                    /
                                @endif
                                {{__('translations.area')}}
                                @if($announcement->type->slug === "house")
                                    /{{__('translations.land_area')}}
                                @endif
                            </label>
                        </div>
                        @if($announcement->type->slug === "apartment" || $announcement->type->slug === "commercial")
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <select name="floor" class="form-control  @error('floor') is-invalid @enderror" id="floor">
                                    <option value="">{{__('translations.floor')}}</option>
                                    <option {{$announcement->floor == "basement" ? "selected" : ""}} value="basement">{{__('translations.basement')}}</option>
                                    @for ($i = 1; $i <= 24; $i++)
                                        <option value="{{ $i }}" {{$announcement->floor == $i ? "selected" : ""}}>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('floor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                        @if($announcement->type->slug !== "land")
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <select name="storeys" class="form-control @error('storeys') is-invalid @enderror" id="floor" id="storeys">
                                    <option value="">{{__('translations.storeys')}}</option>
                                    @for ($i = 1; $i <= 24; $i++)
                                        <option value="{{ $i }}" {{$announcement->storeys == $i ? "selected" : ""}}>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('storeys')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <input type="number" min="0" class="form-control @error('area') is-invalid @enderror" name="area"
                                   value="{{ $announcement->area }}" autocomplete="area"
                                   placeholder="{{__('translations.area')}}" autofocus>
                            @error('area')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @if($announcement->type->slug === "house")
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <input type="number" min="0" class="form-control @error('land_area') is-invalid @enderror"
                                       name="land_area" value="{{ $announcement->land_area }}" autocomplete="land_area"
                                       placeholder="{{__('translations.land_area')}}" autofocus>
                                @error('land_area')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                    </div>
                    @if($announcement->type->slug !== "land")
                        @if($announcement->type->slug !== "commercial")
                            <div class="form-group row">
                                <div class="col-sm-3 mb-3 mb-sm-3">
                                    <label class="col-form-label text-gray-900"
                                           for="rooms">{{__('translations.bedrooms')}}</label>
                                </div>
                                <div class="col-sm-9 mb-9 mb-sm-9">
                                    <select name="rooms" class="form-control @error('rooms') is-invalid @enderror" id="rooms">
                                        <option value="">{{__('translations.bedrooms')}}</option>
                                        @for ($i = 0; $i <= 7; $i++)
                                            <option value="{{ $i }}" {{$announcement->rooms == $i ? "selected" : ""}}>{{ $i }}</option>
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
                                <label class="col-form-label text-gray-900"
                                       for="bathroom">{{__('translations.bathrooms')}}</label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="bathroom" class="form-control @error('bathroom') is-invalid @enderror" id="bathroom">
                                    <option value="">{{__('translations.bathrooms')}}</option>
                                    @for ($i = 2; $i <= 8; $i++)
                                        <option value="{{ $i/2 }}" {{$announcement->bathroom == $i/2 ? "selected" : ""}}>{{ $i/2 }}</option>
                                    @endfor
                                </select>
                                @error('bathroom')
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
                                    <option {{$announcement->building_type == "monolith" ? "selected" : ""}} value="monolith">{{__('translations.monolith')}}</option>
                                    <option {{$announcement->building_type == "stone" ? "selected" : ""}} value="stone">{{__('translations.stone')}}</option>
                                    <option {{$announcement->building_type == "panel" ? "selected" : ""}} value="panel">{{__('translations.panel')}}</option>
                                    <option {{$announcement->building_type == "other" ? "selected" : ""}} value="other">{{__('translations.other')}}</option>
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
                                    <option {{$announcement->ceiling_height == "2.5" ? "selected" : ""}} value="2.5">2.5 {{__('translations.m')}}</option>
                                    <option {{$announcement->ceiling_height == "2.6" ? "selected" : ""}} value="2.6">2.6 {{__('translations.m')}}</option>
                                    <option {{$announcement->ceiling_height == "2.7" ? "selected" : ""}} value="2.7">2.7 {{__('translations.m')}}</option>
                                    <option {{$announcement->ceiling_height == "2.75" ? "selected" : ""}} value="2.75">2.75 {{__('translations.m')}}</option>
                                    <option {{$announcement->ceiling_height == "2.8" ? "selected" : ""}} value="2.8">2.8 {{__('translations.m')}}</option>
                                    <option {{$announcement->ceiling_height == "3.0" ? "selected" : ""}} value="3.0">3.0 {{__('translations.m')}}</option>
                                    <option {{$announcement->ceiling_height == "3.2" ? "selected" : ""}} value="3.2">3.2 {{__('translations.m')}}</option>
                                    <option {{$announcement->ceiling_height == "3.4" ? "selected" : ""}} value="3.4">3.4 {{__('translations.m')}}</option>
                                    <option {{$announcement->ceiling_height == "3.5" ? "selected" : ""}} value="3.5">3.5 {{__('translations.m')}}</option>
                                    <option {{$announcement->ceiling_height == "4.0" ? "selected" : ""}} value="4.0">4.0 {{__('translations.m')}}</option>
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
                                <label class="col-form-label text-gray-900" for="condominium">
                                    {{__('translations.cover')}}
                                </label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="cover" class="form-control @error('cover') is-invalid @enderror" id="cover">
                                    <option value="">{{__('translations.cover')}}</option>
                                    <option {{$announcement->cover == "reinforced_concrete" ? "selected" : ""}} value="reinforced_concrete">{{__('translations.reinforced_concrete')}}</option>
                                    <option {{$announcement->cover == "panel" ? "selected" : ""}} value="panel">{{__('translations.panel')}}</option>
                                    <option {{$announcement->cover == "wood" ? "selected" : ""}} value="wood">{{__('translations.wood')}}</option>
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
                                <label class="col-form-label text-gray-900"
                                       for="condition">{{__('translations.condition')}}</label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="condition" class="form-control @error('condition') is-invalid @enderror" id="condition">
                                    <option value="">{{__('translations.condition')}}</option>
                                    <option {{$announcement->condition == "zero_condition" ? "selected" : ""}} value="zero_condition">{{__('translations.zero_condition')}}</option>
                                    <option {{$announcement->condition == "bad" ? "selected" : ""}} value="bad">{{__('translations.bad')}}</option>
                                    <option {{$announcement->condition == "middle" ? "selected" : ""}} value="middle">{{__('translations.middle')}}</option>
                                    <option {{$announcement->condition == "good" ? "selected" : ""}} value="good">{{__('translations.good')}}</option>
                                    <option {{$announcement->condition == "excellent" ? "selected" : ""}} value="excellent">{{__('translations.excellent')}}</option>
                                </select>
                                @error('condition')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if($announcement->type->slug === "commercial")
                            <div class="form-group row">
                                <div class="col-sm-3 mb-3 mb-sm-3">
                                    <label class="col-form-label text-gray-900" for="land_type">
                                        {{__('translations.land_type')}}
                                    </label>
                                </div>
                                <div class="col-sm-9 mb-9 mb-sm-9">
                                    <select name="land_type" class="form-control @error('land_type') is-invalid @enderror" id="land_type">
                                        <option value="">{{__('translations.land_type')}}</option>
                                        <option {{$announcement->land_type == "shops" ? "selected" : ""}} value="shops">{{__('translations.shops')}}</option>
                                        <option {{$announcement->land_type == "offices" ? "selected" : ""}} value="offices">{{__('translations.offices')}}</option>
                                        <option {{$announcement->land_type == "services" ? "selected" : ""}} value="services">{{__('translations.services')}}</option>
                                        <option {{$announcement->land_type == "other" ? "selected" : ""}} value="other">{{__('translations.other')}}</option>
                                    </select>
                                    @error('land_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        @if($announcement->type_id !== 4)
                            <div class="form-group row">
                                <div class="col-sm-3 mb-3 mb-sm-3">
                                    <label class="col-form-label text-gray-900" for="furniture">
                                        {{__('translations.furniture')}}
                                    </label>
                                </div>
                                <div class="col-sm-9 mb-9 mb-sm-9">
                                    <select name="furniture" class="form-control @error('furniture') is-invalid @enderror" id="furniture">
                                        <option value="">{{__('translations.furniture')}}</option>
                                        <option {{$announcement->furniture == "true" ? "selected" : ""}} value="true">{{__('translations.yes')}}</option>
                                        <option {{$announcement->furniture == "false" ? "selected" : ""}} value="false">{{__('translations.no')}}</option>
                                    </select>
                                    @error('furniture')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        @if($announcement->type_id !== 3)
                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <label class="col-form-label text-gray-900"
                                       for="balcony">{{__('translations.balcony')}}
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="balcony" class="form-control @error('balcony') is-invalid @enderror" id="balcony">
                                    <option value="">{{__('translations.balcony')}}</option>
                                    <option {{$announcement->balcony == "no_balcony" ? "selected" : ""}} value="no_balcony">{{__('translations.no_balcony')}}</option>
                                    <option {{$announcement->balcony == "open_balcony" ? "selected" : ""}} value="open_balcony">{{__('translations.open_balcony')}}</option>
                                    <option {{$announcement->balcony == "close_balcony" ? "selected" : ""}}  value="open_balcony">{{__('translations.close_balcony')}}</option>
                                </select>
                                @error('balcony')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif
                    @endif
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900" for="sewer">
                                {{__('translations.sewer')}}
                            </label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <select name="sewer" class="form-control @error('sewer') is-invalid @enderror" id="sewer">
                                <option value="">{{__('translations.sewer')}}</option>
                                <option {{$announcement->sewer == "individual" ? "selected" : ""}} value="individual">{{__('translations.individual')}}</option>
                                <option {{$announcement->sewer == "centralised" ? "selected" : ""}} value="centralised">{{__('translations.centralised')}}</option>
                                <option {{$announcement->sewer == "no_sewer" ? "selected" : ""}} value="no_sewer">{{__('translations.no_sewer')}}</option>
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
                                <option {{$announcement->distance_from_metro_station == "0 - 100" ? "selected" : ""}} value="0 - 100">{{__('translations.before')}} 100</option>
                                <option {{$announcement->distance_from_metro_station == "100 - 500" ? "selected" : ""}} value="100 - 500">100 - 500</option>
                                <option {{$announcement->distance_from_metro_station == "no_metro" ? "selected" : ""}} value="no_metro">{{__('translations.no_metro')}}</option>
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
                                <option {{$announcement->distance_from_stations == "0-100" ? "selected" : ""}} value="0-100">{{__('translations.before')}} 100</option>
                                <option {{$announcement->distance_from_stations == "101-300" ? "selected" : ""}} value="101-300">101 - 300</option>
                                <option {{$announcement->distance_from_stations == "301" ? "selected" : ""}} value="301">301 +</option>
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
                                <option {{$announcement->distance_from_medical_center == "0-1000" ? "selected" : ""}} value="0-1000">{{__('translations.before')}} 1000</option>
                                <option {{$announcement->distance_from_medical_center == "1001" ? "selected" : ""}} value="1001">1001 +</option>
                            </select>
                            @error('distance_from_medical_center')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @if($announcement->type->slug === "land")
                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <label class="col-form-label text-gray-900"
                                       for="land_geometric_appearance">{{__('translations.land_geometric')}}</label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="land_geometric_appearance" class="form-control @error('land_geometric_appearance') is-invalid @enderror" id="land_geometric_appearance">
                                    <option {{$announcement->land_geometric_appearance == "0-2" ? "selected" : ""}} value="0-2">{{__('translations.smooth')}}</option>
                                    <option {{$announcement->land_geometric_appearance == "2-5" ? "selected" : ""}} value="2-5">2 - 5 {{__('translations.degrees')}}</option>
                                    <option {{$announcement->land_geometric_appearance == "5-10" ? "selected" : ""}} value="5-10">5 - 10 {{__('translations.stone')}}</option>
                                </select>
                                @error('land_geometric_appearance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <label class="col-form-label text-gray-900" for="front_position">{{__('translations.front_position')}}</label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="front_position" class="form-control @error('front_position') is-invalid @enderror" id="front_position">
                                    <option value="">{{__('translations.front_position')}}</option>
                                    <option {{$announcement->front_position == "primary_and_secondary" ? "selected" : ""}} value="primary_and_secondary">{{__('translations.primary_and_secondary')}}</option>
                                    <option {{$announcement->front_position == "primary" ? "selected" : ""}} value="primary">{{__('translations.primary')}}</option>
                                    <option {{$announcement->front_position == "secondary" ? "selected" : ""}} value="secondary">{{__('translations.secondary')}}</option>
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
                                <label class="col-form-label text-gray-900"
                                       for="front_position_length">{{__('translations.front_position_length')}}</label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <input type="number" class="form-control @error('front_position_length') is-invalid @enderror" name="front_position_length"
                                       value={{$announcement->front_position_length}} autocomplete="area"
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
                                <label class="col-form-label text-gray-900"
                                       for="road_type">{{__('translations.road_type')}}</label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="road_type" class="form-control @error('road_type') is-invalid @enderror" id="road_type">
                                    <option {{$announcement->road_type == "asphalt" ? "selected" : ""}} value='asphalt'>{{__('translations.asphalt')}}</option>
                                    <option {{$announcement->road_type == "ground" ? "selected" : ""}} value='ground'>{{__('translations.ground')}}</option>
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
                                    <option {{$announcement->infrastructure == "all_available" ? "selected" : ""}} value='all_available'>{{__('translations.all_available')}}</option>
                                    <option {{$announcement->infrastructure == "no_communication" ? "selected" : ""}} value='no_communication'>{{__('translations.no_communication')}}</option>
                                    <option {{$announcement->infrastructure == "all_available_except_irrigation_water" ? "selected" : ""}} value='all_available_except_irrigation_water'>{{__('translations.all_available_except_irrigation_water')}}</option>
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
                                <label class="col-form-label text-gray-900"
                                       for="fence_type">{{__('translations.fence_type')}}</label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="fence_type" class="form-control @error('fence_type') is-invalid @enderror" id="fence_type">
                                    <option {{$announcement->fence_type == "partly_fenced" ? "selected" : ""}} value='partly_fenced'>{{__('translations.partly_fenced')}}</option>
                                    <option {{$announcement->fence_type == "stone_fence" ? "selected" : ""}} value='stone_fence'>{{__('translations.stone_fence')}}</option>
                                    <option {{$announcement->fence_type == "no_fence" ? "selected" : ""}} value='no_fence'>{{__('translations.no_fence')}}</option>
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
                                    <option {{$announcement->purpose == "public_construction_of_settlements" ? "selected" : ""}} value='public_construction_of_settlements'>{{__('translations.public_construction_of_settlements')}}</option>
                                    <option {{$announcement->purpose == "residential_construction_of_settlements" ? "selected" : ""}} value='residential_construction_of_settlements'>{{__('translations.residential_construction_of_settlements')}}</option>
                                    <option {{$announcement->purpose == "mixed_construction_of_settlements" ? "selected" : ""}} value='mixed_construction_of_settlements'>{{__('translations.mixed_construction_of_settlements')}}</option>
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
                                    <option {{$announcement->building == "there_is_building" ? "selected" : ""}} value='there_is_building'>{{__('translations.there_is_building')}}</option>
                                    <option {{$announcement->building == "there_is_not_building" ? "selected" : ""}} value='there_is_not_building'>{{__('translations.there_is_not_building')}}</option>
                                </select>
                                @error('building')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endif
                    @if($announcement->type->slug !== "land")
                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <label class="col-form-label text-gray-900" for="year">
                                    {{__('translations.year')}}
                                </label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="year" class="form-control @error('year') is-invalid @enderror" id="year">
                                    <option value="">{{__('translations.year')}}</option>
                                    <option {{$announcement->year == "0.6" ? "selected" : ""}} value="0.6">{{__('translations.before')}} 6</option>
                                    <option {{$announcement->year == "7.9" ? "selected" : ""}} value="7.9">7 - 9</option>
                                    <option {{$announcement->year == "10.12" ? "selected" : ""}} value="10.12">10 - 12</option>
                                    <option {{$announcement->year == "13.15" ? "selected" : ""}} value="13.15">13 - 15</option>
                                    <option {{$announcement->year == "16.18" ? "selected" : ""}} value="16.18">16 - 18</option>
                                    <option {{$announcement->year == "19.21" ? "selected" : ""}} value="19.21">19 - 21</option>
                                    <option {{$announcement->year == "22.24" ? "selected" : ""}} value="22.24">22 - 24</option>
                                    <option {{$announcement->year == "25.27" ? "selected" : ""}} value="25.27">25 - 27</option>
                                    <option {{$announcement->year == "28.30" ? "selected" : ""}} value="28.30">28 - 30</option>
                                    <option {{$announcement->year == "31.40" ? "selected" : ""}} value="31.40">31 - 40</option>
                                    <option {{$announcement->year == "41" ? "selected" : ""}} value="41">41 +</option>
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
                                <label class="col-form-label text-gray-900" for="degree">
                                    {{__('translations.degree')}}
                                </label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <select name="degree" class="form-control @error('degree') is-invalid @enderror" id="degree">
                                    <option value="">{{__('translations.degree')}}</option>
                                    <option {{$announcement->degree == "0" ? "selected" : ""}} value="0">0</option>
                                    <option {{$announcement->degree == "1" ? "selected" : ""}} value="1">1</option>
                                    <option {{$announcement->degree == "2" ? "selected" : ""}} value="2">2</option>
                                    <option {{$announcement->degree == "3" ? "selected" : ""}} value="3">3</option>
                                    <option {{$announcement->degree == "4" ? "selected" : ""}} value="4">4</option>
                                </select>
                                @error('degree')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if($announcement->type->slug === "commercial")
                            <div class="form-group row">
                                <div class="col-sm-3 mb-3 mb-sm-3">
                                    <label class="col-form-label text-gray-900" for="property_place">
                                        {{__('translations.property_place')}}
                                    </label>
                                </div>
                                <div class="col-sm-9 mb-9 mb-sm-9">
                                    <select name="property_place" class="form-control @error('property_place') is-invalid @enderror" id="property_place">
                                        <option value="">{{__('translations.property_place')}}</option>
                                        <option {{$announcement->property_place == "into_building" ? "selected" : ""}} value="into_building">{{__('translations.into_building')}}</option>
                                        <option {{$announcement->property_place == "out_of_building" ? "selected" : ""}} value="out_of_building">{{__('translations.out_of_building')}}</option>
                                    </select>
                                    @error('property_place')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <label class="col-form-label text-gray-900"
                                   for="inputAddress">{{__('translations.address')}}</label>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                   name="address" id="address" value="{{ $announcement->address }}"
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
                                <input name="state" id="state" type="text" value="{{$announcement->state}}" hidden>
                                <input name="city" id="city" type="text" value="{{$announcement->city}}" hidden>
                                <div class="col-sm-6 mb-6 mb-sm-6">
                                    <select name="state_id" class="form-control" id="select_state">
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" {{$state->id == $announcement->state_id ? "selected" : ""}}> {{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-6 mb-sm-6">
                                    <select name="city_id" class="form-control" id="select_city">
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" {{$city->id == $announcement->city_id ? "selected" : ""}}> {{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-3">
                            <input type="text" id="latitude" name="latitude" value="{{$announcement->latitude}}"
                                   hidden>
                            <input type="text" id="longitude" name="longitude" value="{{$announcement->longitude}}"
                                   hidden>
                            <input type="text" id="region" name="region" value="{{$announcement->region}}" hidden>
                        </div>
                        <div class="col-sm-9 mb-9 mb-sm-9">
                            <div id="map" style="width: 100%; height: 400px"></div>
                        </div>
                    </div>
                    @if($announcement->type->slug !== "land")
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
                                                       @if(array_key_exists($facility->id, json_decode($announcement->facilities, true)))
                                                       checked="checked"
                                                       @endif
                                                   type="checkbox" value=true>
                                            <label class="form-check-label"
                                                   for="{{$facility->value}}">{{$facility->title}}</label>
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
                                                   @if(array_key_exists($additional_info->id, json_decode($announcement->additional_infos, true)))
                                                   checked="checked"
                                                   @endif
                                                   type="checkbox" value=true>
                                            <label class="form-check-label" for="{{$additional_info->value}}">
                                                {{$additional_info->title}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
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
                                                              name="additional_text_{{$language}}">@if($announcement->translate($language)){{ $announcement->translate($language)->additional_text}}@endif
                                                    </textarea>
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
                                    {{ __('translations.edit') }}
                                </button>
                                <a href="{{route('announcements')}}" class="btn btn-sm btn-danger">
                                    {{ __('translations.cancel') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <form class="announcements" method="POST" action="{{ route( "reject_announcements", $announcement->id)}}" enctype="multipart/form-data" id ="reason-form" hidden>
                    @csrf
                    <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-3">
                                <label class="col-form-label text-gray-900" for="additional_text">
                                    {{__('translations.reason')}}
                                </label>
                            </div>
                            <div class="col-sm-9 mb-9 mb-sm-9">
                                <div class="md-form">
                                    <textarea id="reason" class="md-textarea form-control" placeholder="{{__('translations.reason')}}" rows="3" name="reason">{{$announcement->reason}}</textarea>
                                </div>
                            </div>
                        </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <div class="card-footer text-center">
                                <button class="btn btn-sm btn-success" type="submit">
                                    {{ __('translations.send') }}
                                </button>
                                <a id="close-form" class="btn btn-sm btn-danger">
                                    {{ __('translations.close') }}
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
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcKtc18Xnw9SX8a2A3e1i_fikfDsBv4LA&libraries=places"></script>
        <script type="text/javascript">
            ymaps.ready(init);
            function init() {
                let latitude = document.getElementById('latitude');
                let longitude = document.getElementById('longitude');
                var myMap = new ymaps.Map('map', {
                        center: [latitude.value, longitude.value],
                        zoom: 9
                    }, {
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript">
            var geocoder = new google.maps.Geocoder();
            function geocodeAddress(geocoder,state,city =null) {
                const address = city? state + ', ' + city: state;
                geocoder
                    .geocode({ address: address })
                    .then(({ results }) => {
                        const coordinates = results[0].geometry.location.lat() + '_' + results[0].geometry.location.lng()
                        console.log(coordinates)
                        if(city){
                            document.getElementById('city').value = coordinates
                            console.log(document.getElementById('city').value,coordinates)
                        }else {
                            document.getElementById('state').value = coordinates
                        }
                    })
                    .catch((e) =>
                        alert("Geocode was not successful for the following reason: " + e)
                    );

            }
            let images = {!! $announcement->announcementImages->toJson() !!};
            let initialPreviews = [];
            let initialPreviewConfigs = [];
            images.forEach(function (image) {
                initialPreviews.push('/storage/uploads/announcements/' + image.name)
                initialPreviewConfigs.push({caption: image.name, key: image.id})
            });
            $("#images").fileinput({
                initialPreview: initialPreviews,
                initialPreviewAsData: true,
                initialPreviewConfig: initialPreviewConfigs,
                theme: 'fa',
                uploadUrl: false,
                allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
                overwriteInitial: false,
                maxFileSize: 90000,
                maxFilesCount: 10,
            });
            $('#select_city').on('change', function(e) {
                const state_id = document.getElementById('select_state').value;
                $.ajax({
                    type: "post",
                    url: "/admin/settings/cities/city_and_state_by_id",
                    data: {"_token": "{{ csrf_token() }}", city_id:e.target.value,state_id:state_id},
                    dataType:'json',
                    success: function (data) {
                        geocodeAddress(geocoder,data.state.name,data.city.name)
                    },
                    error: function (data) {

                    }
                });
            });
            $('#reasons').on('click', function() {
                document.getElementById('reason-form').hidden = false;
            });
            $('#close-form').on('click', function() {
                document.getElementById('reason-form').hidden = true;
            });
            $('#select_state').on('change', function(e) {
                $.ajax({
                    type: "post",
                    url: "/admin/settings/cities/city_by_state_id",
                    data: {"_token": "{{ csrf_token() }}", state_id:e.target.value},
                    dataType:'json',
                    success: function (data) {
                        geocodeAddress(geocoder,data.state.name)
                        $('#select_city').empty();
                        $('#select_city').append('<option value="">{{__("translations.city")}}</option>');
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
            let main_image = '{{$announcement->main_image}}';
            let main_initialPreview = [];
            let main_initialPreviewConfig = [];
            if (main_image) {
                main_initialPreview = ['/storage/uploads/announcements/' + main_image];
                main_initialPreviewConfig = [
                    {caption: main_image, key: 'main_image'}
                ];
            }
            $("#main_image").fileinput({
                initialPreview: main_initialPreview,
                initialPreviewAsData: true,
                initialPreviewConfig: main_initialPreviewConfig,
                theme: 'fa',
                showUpload: false,
                uploadUrl: false,
                allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
                overwriteInitial: false,
                maxFileSize: 90000,
                maxFilesNum: 1,
            });
            let certificate = '{{$announcement->certificate}}';
            let main_certificate_initialPreview = [];
            let main_certificate_initialPreviewConfig = [];
            if (certificate) {
                main_certificate_initialPreview = ['/storage/uploads/announcements/' + certificate];
                main_certificate_initialPreviewConfig = [
                    {caption: certificate, key: 'certificate'}
                ];
            }
            $("#certificate").fileinput({
                initialPreview:main_certificate_initialPreview,
                initialPreviewAsData:true,
                initialPreviewConfig:main_certificate_initialPreviewConfig,
                theme: 'fa',
                showUpload: false,
                uploadUrl: false,
                allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
                overwriteInitial: false,
                maxFileSize: 90000,
                maxFilesNum: 1,
            });

            $(".kv-file-remove").click(function (e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                let key = $(this).data("key");
                let id;
                let type;
                if (key === 'main_image') {
                    id = '{{$announcement->id}}'
                    type = 'main_image'
                } else {
                    id = key
                    type = 'images'
                }
                let kv_file = $(this)
                $.ajax({
                    type: "post",
                    url: "/admin/announcements/remove-image",
                    data: {id: id, type: type},
                    dataType: 'json',
                    success: function (data) {
                        if (data.alert === 'success') {
                            kv_file.parent().parent().parent().parent().remove()
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    error: function (data) {
                        toastr.error(data.message);
                    }
                });
            });
            $('#start_datepicker').datepicker({
                weekStart: 1,
                daysOfWeekHighlighted: "6,0",
                autoclose: true,
                todayHighlight: true,

            });
            $('#end_datepicker').datepicker({
                weekStart: 1,
                daysOfWeekHighlighted: "6,0",
                autoclose: true,
                todayHighlight: true,
            });

        </script>
@endsection

