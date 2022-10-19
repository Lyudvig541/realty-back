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
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{ __('translations.address') }}</th>
                                        <th>{{ __('translations.price') }}</th>
                                        <th>{{ __('translations.image') }}</th>
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
                                            <td>
                                                <div class="btn-group">
                                                    <ul class="list-inline m-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{route('show_announcement',$announcement->id)}}" target="_blank" class="btn btn-warning btn-sm">
                                                                <i class="c-icon cil-link"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="{{route('take_announcement',$announcement->id)}}" class="btn btn-success btn-sm">
                                                                <i class="c-icon cil-check-circle"></i>
                                                            </a>
                                                        </li>
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
