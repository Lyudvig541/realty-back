@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h4 m-0 font-weight-bold text-primary text-center">
                        {{ __('translations.edit') }}
                        {{ __('translations.banner') }}
                    </h1>
                </div>
                <div class="card-body">
                    <form class="banner" method="POST" action="{{ route('edit_banner', $banner->id)}}" enctype="multipart/form-data">
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
                                                                {{__('translations.title')}}
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-10 mb-10 mb-sm-10">
                                                            <input type="text" class="form-control @error('title_'.$language) is-invalid @enderror" name="title_{{$language}}" value="{{$banner->translate($language)->title}}" autocomplete="title_{{$language}}" placeholder="{{__('translations.title')}}" autofocus>
                                                            @error('title_'.$language)
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
                                                                {{ __('translations.description') }} ({{__('translations.max')}} 255)
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-10 mb-10 mb-sm-10">
                                                            <textarea type="text" class="form-control @error('description_'.$language) is-invalid @enderror" name="description_{{$language}}" autocomplete="description_"{{$language}} placeholder="{{ __('translations.description') }}" autofocus>{{$banner->translate($language)->description}}</textarea>
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
                                                    <label class="col-form-label text-gray-900" for="image">
                                                        {{ __('translations.main_image') }}
                                                    </label>
                                                </div>
                                                <div class="col-sm-4 mb-4 mb-sm-4">
                                                    <input id="form-control file-input @error('main_image') is-invalid @enderror" type="file" name="main_image">
                                                    <input type="hidden" name="old_image" value="{{$banner->main_image}}">
                                                    @error('main_image')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-6 mb-6 mb-sm-6">
                                                    <img src="{{$banner->main_image ? asset('/banner/'.$banner->main_image) : asset('/assets/img/default.png')}}" width="100px" height="100px" alt="image">
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
                            <a href="{{route('banners')}}" class="btn btn-sm btn-danger">
                                {{__('translations.cancel')}}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
