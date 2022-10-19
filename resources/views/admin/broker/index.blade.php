@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.6/css/star-rating.min.css"/>
<style>
    .rating-container{
        padding: 5px;
    }
    .clear-rating{
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
                                @if($slug)
                                {{__('translations.brokers_company')}}
                                <div class="card-header-actions">
                                    <a href="{{route('create_super_broker')}}" class="btn btn-sm btn-success">
                                        {{ __('translations.create') }} {{ __('translations.brokers_company') }}
                                    </a>
                                </div>
                                @else
                                    {{__('translations.brokers')}}
                                    <div class="card-header-actions">
                                        <a href="{{route('create_broker')}}" class="btn btn-sm btn-success">
                                            {{ __('translations.create') }} {{ __('translations.broker') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{ __('translations.first_name') }}</th>
                                        @if(!$slug)
                                            <th>{{ __('translations.last_name') }}</th>
                                        @endif
                                        <th>{{ __('translations.email') }}</th>
                                        <th>{{ __('translations.phone') }}</th>
                                        <th>{{ __('translations.rating') }}</th>
                                        <th>{{ __('translations.avatar') }}</th>
                                        @if(!$slug)
                                            <th>{{ __('translations.agency') }}</th>
                                        @endif
                                        <th>{{ __('translations.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($brokers as $broker)
                                        <tr>
                                            @if(!$slug)
                                                <td>{{$broker->first_name}}</td>
                                                <td>{{$broker->last_name}}</td>
                                            @else
                                                <td>{{$broker->name}}</td>
                                            @endif
                                            <td>{{$broker->email}}</td>
                                            <td>{{$broker->phone}}</td>
                                            <td>
                                                <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $broker->averageRating }}" data-size="xs" disabled="">
                                            </td>
                                            <td>
                                                <img src="{{$broker->avatar ? asset('storage/uploads/users/'.$broker->avatar) : asset('/assets/img/default.png')}}" width="100px" height="100px" alt="image">
                                            </td>
                                            @if(!$slug)
                                                <td>{{ $broker->agency ? $broker->agency->name : ''}}</td>
                                            @endif
                                            <td>
                                                <div class="btn-group">
                                                    <ul class="list-inline m-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{route('find'.$slug.'_broker',$broker->id)}}" class="btn btn-warning btn-sm">
                                                                <i class="c-icon cil-pen"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a onclick="return confirm('Are you sure?')" href="{{route('delete'.$slug.'_broker', $broker->id)}}" class="btn btn-danger btn-sm">
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
                                {{ $brokers->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.6/js/star-rating.min.js" type="text/javascript"></script>

@endsection
