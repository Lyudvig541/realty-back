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
                                {{ __('translations.comments') }}
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{__('translations.user')}} {{__('translations.first_name')}} {{__('translations.last_name')}}</th>
                                        <th>{{__('translations.broker')}} {{__('translations.first_name')}} {{__('translations.last_name')}}</th>
                                        <th>{{ __('translations.comment_text') }}</th>
                                        <th>{{__('translations.action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($comments as $comment)
                                        <tr>
                                            <td>{{$comment->user->first_name}} {{$comment->user->last_name}}</td>
                                            <td>{{$comment->broker->first_name}} {{$comment->broker->last_name}}</td>
                                            <td>{{$comment->text}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <ul class="list-inline m-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{route('find_comment',$comment->id)}}" class="btn btn-warning btn-sm">
                                                                <i class="c-icon cil-pen"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="{{route('delete_comment',$comment->id)}}"
                                                               class="btn btn-danger btn-sm">
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
                                {{$comments->links()}}
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
