@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="h4 m-0 font-weight-bold text-primary text-center">{{__('translations.edit')}} {{__('translations.city')}}  </h4>
                </div>
                <div class="card-body">
                    <form class="city" method="POST" action="{{ route('edit_city', $city->id) }}">
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
                                                                {{__('translations.city')}}
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-10 mb-10 mb-sm-10">
                                                            <input type="text" class="form-control @error('name_'.$language) is-invalid @enderror" name="name_{{$language}}" value="{{ $city->translate($language)->name }}" autocomplete="name_{{$language}}" placeholder={{__('translations.city')}} autofocus>
                                                            @error('name_'.$language)
                                                            <span class="invalid-feedback" role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="form-group row">
                                                <div class="col-sm-2 mb-2 mb-sm-2">
                                                    <label class="col-form-label text-gray-900" for="state_id">
                                                        {{__('translations.state')}}
                                                    </label>
                                                </div>
                                                <div class="col-sm-10 mb-10 mb-sm-10">
                                                    <select class="form-select form-control" name="state">
                                                        <option value="">Select State</option>
                                                        @foreach($states as $state)
                                                            <option value="{{$state->id}}"{{ $state->id == $city->state_id ? 'selected' : '' }} >{{$state->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-2 mb-2 mb-sm-2">
                                                        <label class="col-form-label text-gray-900" for="country_id">
                                                            {{__('translations.coordinates')}}

                                                        </label>
                                                    </div>
                                                    <div class="col-sm-10 mb-10 mb-sm-10">
                                                        <input type="text" class="form-control @error('coordinates') is-invalid @enderror" name="coordinates" value="{{ $city->coordinates }}" autocomplete="coordinates" placeholder='Coordinates' autofocus>
                                                        @error('coordinates')
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
                                                        <label class="col-form-label text-gray-900" for="country_id">
                                                            {{__('translations.map_zoom')}}
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-10 mb-10 mb-sm-10">
                                                        <input type="number"
                                                               class="form-control @error('map_zoom') is-invalid @enderror"
                                                               name="map_zoom" value="{{$city->map_zoom}}"
                                                               autocomplete="map_zoom"
                                                               placeholder={{__('translations.map_zoom')}} autofocus>
                                                        @error('map_zoom')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>
                                                                    {{ $message }}
                                                                </strong>
                                                            </span>
                                                        @enderror
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
                                <a href="{{route('cities')}}" class="btn btn-sm btn-danger">
                                    {{__('translations.cancel')}}
                                </a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
