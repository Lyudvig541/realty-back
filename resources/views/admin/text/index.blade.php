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
                                {{ __('translations.texts') }}
                                <div class="card-header-actions">
                                    <a href="{{route('create_text')}}" class="btn btn-sm btn-success">
                                        {{ __('translations.create') }} {{ __('translations.text') }}
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{ __('translations.title') }}</th>
                                        <th>{{ __('translations.sub_title') }}</th>
                                        <th>{{ __('translations.slug') }}</th>
                                        <th>{{ __('translations.text') }}</th>
                                        <th>{{ __('translations.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($texts as $text)
                                            <tr>
                                                <td>{{$text->title}}</td>
                                                <td>{{$text->sub_title}}</td>
                                                <td>{{$text->slug}}</td>
                                                <td>{{$text->text}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <ul class="list-inline m-0">
                                                            <li class="list-inline-item">
                                                                <a href="{{route('find_text', $text->id)}}" class="btn btn-warning btn-sm">
                                                                    <i class="c-icon cil-pen"></i>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a onclick="return confirm('Are you sure?')" href="{{route('delete_text', $text->id)}}" class="btn btn-danger btn-sm">
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
                                {{$texts->links()}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
@endsection
