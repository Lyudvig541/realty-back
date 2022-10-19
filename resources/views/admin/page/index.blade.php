@extends('layouts.app')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.6/css/star-rating.min.css"/>
<style>
    .rating-container {
        padding: 5px;
    }

    .clear-rating {
        display: none !important;
    }
</style>
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="c-icon cib-superuser"></i>
                                {{ __('translations.pages') }}
                                <div class="card-header-actions">
                                    <a href="{{route('create_page')}}" class="btn btn-sm btn-success">
                                        {{ __('translations.create') }} {{ __('translations.page') }}
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
                                        <th>{{ __('translations.image') }}</th>
                                        <th>{{ __('translations.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pages as $page)
                                        <tr>
                                            <td>{{$page->title}}</td>
                                            <td>{{$page->sub_title}}</td>
                                            <td>{{$page->slug}}</td>
                                            <td>
                                                <img src="{{$page->image ? asset('storage/uploads/pages/'.$page->image) : asset('/assets/img/default.png')}}" width="100px" height="100px" alt="image">
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <ul class="list-inline m-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{route('find_page',$page->id)}}" class="btn btn-warning btn-sm">
                                                                <i class="c-icon cil-pen"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="{{route('delete_page', $page->id)}}" class="btn btn-danger btn-sm">
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
                                {{$pages->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.6/js/star-rating.min.js"
            type="text/javascript"></script>

@endsection
