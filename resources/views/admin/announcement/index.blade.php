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
                                {{ __('translations.announcements') }}
                                <div class="card-header-actions">
                                    <a href="{{route('choose-category')}}" class="btn btn-sm btn-success">
                                        {{ __('translations.create') }} {{ __('translations.announcement') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{ __('translations.address') }}</th>
                                        <th>{{ __('translations.price') }}</th>
                                        <th>{{ __('translations.image') }}</th>
                                        <th>{{ __('translations.user') }}</th>
                                        <th>{{ __('translations.broker') }}</th>
                                        <th>{{ __('translations.status') }}</th>
                                        <th>{{ __('translations.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($announcements as $announcement)
                                        <tr>
                                            <td>{{$announcement->address}}</td>
                                            <td>{{$announcement->price}}</td>
                                            <td>
                                                <img src="{{$announcement->main_image ? asset('storage/uploads/announcements/'.$announcement->main_image) : asset('/assets/img/default.png')}}" width="100px" height="100px" alt="image">
                                            </td>
                                                <td>{{$announcement->user ? $announcement->user->first_name :null}} {{$announcement->user ? $announcement->user->last_name : null}}</td>
                                            <td>{{$announcement->broker ? $announcement->broker->first_name : null}} {{$announcement->broker ? $announcement->broker->last_name : null}}</td>
                                            <td>
                                                @if($announcement->verify === 4)
                                                    {{ __('translations.completed') }}
                                                @elseif($announcement->verify === 3)
                                                    {{ __('translations.archived') }}
                                                @else
                                                    {{ __('translations.current') }}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <ul class="list-inline m-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{route('find_announcement', $announcement->id)}}" class="btn btn-warning btn-sm">
                                                                <i class="c-icon cil-pen"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="{{route('archive_announcement', $announcement->id)}}" class="btn btn-behance btn-sm">
                                                                <i class="c-icon fa fa-archive"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a onclick="return confirm('Are you sure?')" href="{{route('delete_announcement', $announcement->id)}}" class="btn btn-danger btn-sm">
                                                                <i class="c-icon cil-trash"></i>
                                                            </a>
                                                        </li>
                                                        @if($announcement->verify === 1)
                                                            <li class="list-inline-item">
                                                                <a href="{{route('completed_announcement', $announcement->id)}}" class="btn btn-success btn-sm">
                                                                    {{__('translations.complete')}}
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $announcements->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
