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
                                {{ __('translations.categories') }}
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
                                        @foreach($categories as $category)
                                            <tr>
                                                <td>{{$category->name}}</td>
                                                <td>
                                                    <img src="{{$category->image ? asset('storage/uploads/categories/'.$category->image) : asset('/assets/img/default.png')}}" width="100px" height="100px" alt="image">
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <ul class="list-inline m-0">
                                                            <li class="list-inline-item">
                                                                <a href="{{route('find_category', $category->id)}}" class="btn btn-warning btn-sm">
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
                                {{$categories->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
