@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="h4 m-0 font-weight-bold text-primary text-center">{{__('translations.create')}} {{__('translations.currency')}}  </h4>
                </div>
                <div class="card-body">
                    <form class="type" method="POST" action="{{ route('edit_currency', $currency->id) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid">
                            <div class="fade-in">
                                <div class="row">
                                    <div class="col-12 nav-tabs-boxed">
                                        <div class="tab-content">
                                            <div class="form-group row">
                                                <div class="col-sm-2 mb-2 mb-sm-2">
                                                    <label class="col-form-label text-gray-900"
                                                           for="name">
                                                        {{__('translations.name')}}
                                                    </label>
                                                </div>
                                                <div class="col-sm-10 mb-10 mb-sm-10">
                                                    <input type="text"
                                                           class="form-control @error('name') is-invalid @enderror"
                                                           name="name"
                                                           value="{{$currency->name}}"
                                                           autocomplete="name"
                                                           placeholder={{__('translations.name')}} autofocus>
                                                    @error('name')
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
                                                    <label class="col-form-label text-gray-900" for="value">
                                                        {{__('translations.value')}}
                                                    </label>
                                                </div>
                                                <div class="col-sm-10 mb-10 mb-sm-10">
                                                    <input type="number" step="0.01"
                                                           class="form-control @error('value') is-invalid @enderror"
                                                           name="value" value="{{ $currency->value }}"
                                                           autocomplete="value"
                                                           placeholder={{__('translations.value')}} autofocus>
                                                    @error('value')
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
                                                    <label class="col-form-label text-gray-900" for="value">
                                                        Local
                                                    </label>
                                                </div>
                                                <div class="col-sm-10 mb-10 mb-sm-10">
                                                    <select class="form-select form-control" name="local">
                                                        <option value="am" @if ($currency->local == 'am') selected="selected" @endif>AM</option>
                                                        <option value="en" @if ($currency->local == 'en') selected="selected" @endif>EN</option>
                                                        <option value="ru" @if ($currency->local == 'ru') selected="selected" @endif>RU</option>
                                                    </select>
                                                    @error('locale')
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
                                <a href="{{route('currencies')}}" class="btn btn-sm btn-danger">
                                    {{__('translations.cancel')}}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
