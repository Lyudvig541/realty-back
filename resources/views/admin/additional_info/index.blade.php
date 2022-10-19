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
                                {{ __('translations.additional_info') }}
                                <div class="card-header-actions">
                                    <a href="{{route('create_additional_info')}}" class="btn btn-sm btn-success">
                                        {{ __('translations.create') }}
                                        {{ __('translations.additional_info') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{ __('translations.title') }}</th>
                                        <th>{{ __('translations.value') }}</th>
                                        <th>{{ __('translations.image') }}</th>
                                        <th>{{ __('translations.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($additional_infos as $additional_info)
                                        <tr>
                                            <td>{{$additional_info->title}}</td>
                                            <td>{{$additional_info->value}}</td>
                                            <td>
                                                <img src="{{$additional_info->image ? asset('storage/uploads/additional_infos/'.$additional_info->image) : asset('/assets/img/default.png')}}" width="100px" height="100px" alt="image">
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <ul class="list-inline m-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{route('find_additional_info', $additional_info->id)}}" class="btn btn-warning btn-sm">
                                                                <i class="c-icon cil-pen"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a onclick="return confirm('Are you sure?')"  href="{{route('delete_additional_info', $additional_info->id)}}" class="btn btn-danger btn-sm">
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
                                {{$additional_infos->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
