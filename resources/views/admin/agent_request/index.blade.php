@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="c-icon cil-briefcase"></i>
                               Agents Requests
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                <thead>
                                <tr>
                                    <th>{{__('translations.first_name')}}</th>
                                    <th>{{__('translations.last_name')}}</th>
                                    <th>{{__('translations.email')}}</th>
                                    <th>{{__('translations.phone')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($requests as $request)
                                    <tr>
                                        <td>{{$request->first_name}}</td>
                                        <td>{{$request->last_name}}</td>
                                        <td>{{$request->email}}</td>
                                        <td>{{$request->phone}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$requests->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
