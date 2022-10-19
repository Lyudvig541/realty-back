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
                                {{ __('translations.types') }}
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{ __('translations.name') }}</th>
                                        <th>{{ __('translations.image') }}</th>
                                        <th>{{ __('translations.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($types as $type)
                                            <tr>
                                                <td>{{$type->name}}</td>
                                                <td>
                                                    <img src="{{$type->image ? asset('storage/uploads/announcement_types/'.$type->image) : asset('/assets/img/default.png')}}" width="100px" height="100px" alt="image">
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <ul class="list-inline m-0">
                                                            <li class="list-inline-item">
                                                                <a href="{{route('find_type', $type->id)}}" class="btn btn-warning btn-sm">
                                                                    <i class="c-icon cil-pen"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$types->links()}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
@endsection
