@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="c-icon cib-hackhands"></i>
                                {{ __('translations.constructors') }}
                                <div class="card-header-actions">
                                    <a href="{{route('create_constructor')}}" class="btn btn-sm btn-success">
                                        {{ __('translations.create') }} {{ __('translations.constructor') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{ __('translations.address') }}</th>
                                        <th>{{ __('translations.price_start') }}</th>
                                        <th>{{ __('translations.price_end') }}</th>
                                        <th>{{ __('translations.image') }}</th>
                                        <th>{{ __('translations.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($constructors as $constructor)
                                        <tr>
                                            <td>{{$constructor->address}}</td>
                                            <td>{{$constructor->price_start}}</td>
                                            <td>{{$constructor->price_end}}</td>
                                            <td>
                                                <img src="{{$constructor->main_image ? asset('storage/uploads/constructors/'.$constructor->main_image) : asset('/assets/img/default.png')}}" width="100px" height="100px" alt="image">
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <ul class="list-inline m-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{route('find_constructor', $constructor->id)}}" class="btn btn-warning btn-sm">
                                                                <i class="c-icon cil-pen"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a onclick="return confirm('Are you sure?')" href="{{route('delete_constructor', $constructor->id)}}" class="btn btn-danger btn-sm">
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
                                {{$constructors->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
