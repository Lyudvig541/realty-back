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
                                {{ __('translations.currencies') }}
                                <div class="card-header-actions">
                                    <a href="{{route('create_currency')}}" class="btn btn-sm btn-success">
                                        {{ __('translations.create') }} {{ __('translations.currency') }}
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{ __('translations.name') }}</th>
                                        <th>{{ __('translations.value') }}</th>
                                        <th>{{ __('translations.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($currencies as $currency)
                                            <tr>
                                                <td>{{$currency->name}}</td>
                                                <td>{{$currency->value}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <ul class="list-inline m-0">
                                                            <li class="list-inline-item">
                                                                <a href="{{route('find_currency', $currency->id)}}" class="btn btn-warning btn-sm">
                                                                    <i class="c-icon cil-pen"></i>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a onclick="return confirm('Are you sure?')" href="{{route('delete_currency', $currency->id)}}" class="btn btn-danger btn-sm">
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
                                {{$currencies->links()}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
@endsection
