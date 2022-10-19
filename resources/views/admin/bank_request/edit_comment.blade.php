@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.6/css/star-rating.min.css"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"/>
<style>
    .file-preview {
        height: 320px;
    }

    .file-drop-zone {
        height: 280px;
    }

    .kv-file-upload, .file-upload-indicator, .kv-file-download, .file-drag-handle {
        visibility: hidden !important;
    }
    .rating-container{
        padding: 5px;
    }
</style>

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="h4 m-0 font-weight-bold text-primary text-center">{{ __('translations.edit') }} {{ __('translations.comment') }}</h4>
                </div>
                <div class="card-body">
                    <form class="user" method="POST" action="{{ route('edit_comment', $comment->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid">
                            <div class="fade-in">
                                <div class="row">
                                    <div class="col-12 nav-tabs-boxed">
                                        <div class="form-group row">
                                            <div class="col-sm-2 mb-2 mb-sm-2">
                                                <label class="col-form-label text-gray-900" for="inputAddress">{{ __('translations.select') }} {{ __('translations.user') }}</label>
                                            </div>
                                            <div class="col-sm-10 mb-10 mb-sm-10">
                                                <select class="form-control" name="user_id" autofocus>
                                                    @foreach($users as $user)
                                                        <option value="{{$user->id}}" {{$user->id == old('user_id') ? 'selected' : ''}}>{{$user->first_name}} {{$user->last_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 mb-2 mb-sm-2">
                                                <label class="col-form-label text-gray-900" for="inputAddress">{{ __('translations.select') }} {{ __('translations.broker') }}</label>
                                            </div>
                                            <div class="col-sm-10 mb-10 mb-sm-10">
                                                <select class="form-control" name="broker_id" autofocus>
                                                    @foreach($brokers as $broker)
                                                        <option value="{{$broker->id}}" {{$broker->id == old('broker_id') ? 'selected' : ''}}>{{$broker->first_name}} {{$broker->last_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 mb-2 mb-sm-2">
                                                <label class="col-form-label text-gray-900" for="text">{{ __('translations.comment_text') }}</label>
                                            </div>
                                            <div class="col-sm-10 mb-10 mb-sm-10">
                                                <textarea type="text" class="form-control @error('text') is-invalid @enderror" name="text" value="{{$comment->text}}"
                                                          required autocomplete="text" id="text" placeholder="{{ __('translations.comment_text') }}" autofocus></textarea>
                                                @error('text')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-footer text-center">
                            <button class="btn btn-sm btn-success" type="submit">{{ __('translations.submit') }}</button>
                            <a href="{{route('comments')}}" class="btn btn-sm btn-danger">
                                {{ __('translations.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.6/js/star-rating.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>

@endsection
