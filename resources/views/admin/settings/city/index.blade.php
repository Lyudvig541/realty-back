@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="c-icon cil-playlist-add"></i>
                                {{ __('translations.city') }}
                                <div class="card-header-actions">
                                    <a href="{{route('create_city')}}" class="btn btn-sm btn-success">
                                        {{ __('translations.create') }} {{ __('translations.city') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{ __('translations.city') }}</th>
                                        <th>{{ __('translations.map_zoom') }}</th>
                                        <th>{{ __('translations.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cities as $city)
                                            <tr>
                                                <td>{{$city->name}}</td>
                                                <td>{{$city->map_zoom}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <ul class="list-inline m-0">
                                                            <li class="list-inline-item">
                                                                <a href="{{route('find_city', $city->id)}}" class="btn btn-warning btn-sm">
                                                                    <i class="c-icon cil-pen"></i>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a onclick="return confirm('Are you sure?')" href="{{route('delete_city', $city->id)}}" class="btn btn-danger btn-sm">
                                                                    <i class="c-icon cil-trash"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$cities->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
