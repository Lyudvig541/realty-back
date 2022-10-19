@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="h4 m-0 font-weight-bold text-primary text-center">
                    {{ __('translations.choose') }}
                    {{ __('translations.category') }}
                </h4>
            </div>
            <div class="card-body">
                <div class="card-deck d-flex justify-content-center">
                    <div class="row" style="text-align: center">
                        @foreach($categories as $category)
                            <div class="card col-xl-5 col-md-5 col-lg-5 ">
                                <img width="200px" height="200px" src="{{$category->image ? asset('storage/uploads/categories/'.$category->image) : asset('/assets/img/default.png')}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{$category->name}}</h5>
                                    <a href="{{route('choose-type',$category->id)}}" class="btn btn-primary">{{__('translations.continue')}}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{route('announcements')}}" class="btn btn-sm btn-danger">
                    {{ __('translations.cancel') }}
                </a>
            </div>
@endsection

