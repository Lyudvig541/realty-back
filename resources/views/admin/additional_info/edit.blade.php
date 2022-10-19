@extends('layouts.app')
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
</style>
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h4 m-0 font-weight-bold text-primary text-center">
                        {{ __('translations.edit') }}
                        {{ __('translations.additional_info') }}
                    </h1>
                </div>
                <div class="card-body">
                    <form class="additional_infos" method="POST" action="{{ route('edit_additional_info', $additional_info->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid">
                            <div class="fade-in">
                                <div class="row">
                                    <div class="col-12 nav-tabs-boxed">
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($languages as $language)
                                                <li class="nav-item">
                                                    <a class='{{$language === app()->getLocale() ? "nav-link active":"nav-link"}}' data-toggle="tab" href="#{{$language}}" role="tab" aria-controls="home">
                                                        {{$language}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($languages as $language)
                                                <div class='{{$language === app()->getLocale()? "tab-pane active":"tab-pane"}}' id="{{$language}}" role="tabpanel">
                                                    <div class="form-group row">
                                                        <div class="col-sm-2 mb-2 mb-sm-2">
                                                            <label class="col-form-label text-gray-900" for="title_{{$language}}">
                                                                {{__('translations.title')}}
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-10 mb-10 mb-sm-10">
                                                            <input type="text" class="form-control @error('title_'.$language) is-invalid @enderror" name="title_{{$language}}" value="{{ $additional_info->translate($language)->title }}" autocomplete="title_{{$language}}" placeholder="{{__('translations.title')}}" autofocus>
                                                            @error('title_'.$language)
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>
                                                                    {{ $message }}
                                                                </strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="form-group row">
                                                <div class="col-sm-2 mb-2 mb-sm-2">
                                                    <label class="col-form-label text-gray-900" for="value">
                                                        {{__('translations.value')}}
                                                    </label>
                                                </div>
                                                <div class="col-sm-10 mb-10 mb-sm-10">
                                                    <input type="text" class="form-control @error('value') is-invalid @enderror" name="value" value="{{ $additional_info->value }}" autocomplete="value" placeholder="{{__('translations.value')}}" autofocus>
                                                    @error('value')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>
                                                            {{ $message }}
                                                        </strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-2 mb-2 mb-sm-2">
                                                        <label class="col-form-label text-gray-900" for="image">
                                                            {{ __('translations.image') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-10 mb-10 mb-sm-10">
                                                        <input id="image" type="file" name="image" class="file @error('image') is-invalid @enderror">
                                                        @error('image')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-sm btn-success" type="submit">
                                {{__('translations.submit')}}
                            </button>
                            <a href="{{route('additional_infos')}}" class="btn btn-sm btn-danger">
                                {{__('translations.cancel')}}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>
    <script type="text/javascript">

        let  image = '{{$additional_info->image}}';
        let initialPreview = [];
        let initialPreviewConfig = [];
        if (image){
            initialPreview = ['/storage/uploads/additional_infos/' + image];
            initialPreviewConfig = [
                {caption: image, key: 'image'}
            ];
        }
        $("#image").fileinput({
            initialPreview: initialPreview,
            initialPreviewAsData: true,
            initialPreviewConfig: initialPreviewConfig,
            theme: 'fa',
            showUpload: false,
            uploadUrl: false,
            allowedFileExtensions: ['jpg', 'png', 'gif','jpeg'],
            overwriteInitial: false,
            maxFileSize: 2000,
            maxFilesNum: 1,
        });
        $(".kv-file-remove").click(function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            let id = '{{$additional_info->id}}'
            let link = '{{$additional_info->image}}'
            let type = 'image';
            let kv_file = $(this)
            $.ajax({
                type: "post",
                url: "/admin/additional_infos/remove-image",
                data: {id:id, type:type, image:link},
                dataType:'json',
                success: function (data) {
                    if (data.alert === 'success'){
                        kv_file.parent().parent().parent().parent().remove()
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                },
                error: function (data) {
                    toastr.error(data.message);
                }
            });
        });

    </script>
@endsection
