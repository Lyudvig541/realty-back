@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="h4 m-0 font-weight-bold text-primary text-center">{{__('translations.create')}} {{__('translations.country')}}  </h4>
                </div>
                <div class="card-body">
                    <form class="country" method="POST" action="{{ route('store_country')}}">
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
                                                                {{__('translations.country')}}
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-10 mb-10 mb-sm-10">
                                                            <input type="text" class="form-control @error('name_'.$language) is-invalid @enderror" name="name_{{$language}}" value="{{ old('name_'.$language) }}" autocomplete="name_{{$language}}" placeholder={{__('translations.country')}} autofocus>
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
                                                    <label class="col-form-label text-gray-900" for="country_id">
                                                        Coordinates
                                                    </label>
                                                </div>
                                                <div class="col-sm-10 mb-10 mb-sm-10">
                                                    <input type="text" class="form-control @error('coordinates') is-invalid @enderror" name="coordinates" value="{{ old('coordinates') }}" autocomplete="coordinates" placeholder='Coordinates' autofocus>
                                                    @error('coordinates')
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
                                <a href="{{route('countries')}}" class="btn btn-sm btn-danger">
                                    {{__('translations.cancel')}}
                                </a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
