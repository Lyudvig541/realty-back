@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="c-icon cil-briefcase"></i>
                                {{ __('translations.constructors') }} {{ __('translations.agencies') }}
                            <div class="card-header-actions">
                                <a href="{{route('create_constructor_agency')}}" class="btn btn-sm btn-success">
                                    {{ __('translations.create') }} {{ __('translations.constructors') }} {{ __('translations.agency') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                <thead>
                                <tr>
                                    <th>{{ __('translations.name') }}</th>
                                    <th>{{ __('translations.image') }}</th>
                                    <th>{{ __('translations.description') }}</th>
                                    <th>{{ __('translations.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($constructor_agencies as $constructor_agency)
                                    <tr>
                                        <td>{{$constructor_agency->name}}</td>
                                        <td>
                                            <img src="{{$constructor_agency->image ? asset('storage/uploads/constructor_agencies/'.$constructor_agency->image) : asset('/assets/img/default.png')}}" width="100px" height="100px" alt="image">
                                        </td>
                                        <td>{{$constructor_agency->description}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <ul class="list-inline m-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{route('find_constructor_agency', $constructor_agency->id)}}" class="btn btn-warning btn-sm">
                                                            <i class="c-icon cil-pen"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a onclick="return confirm('Are you sure?')" href="{{route('delete_constructor_agency', $constructor_agency->id)}}" class="btn btn-danger btn-sm">
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
                            {{$constructor_agencies->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
