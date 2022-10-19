@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="c-icon cil-group"></i>{{__('translations.users')}}
                                <div class="card-header-actions">
                                    <a href="{{route('create_user')}}" class = "btn btn-sm btn-success">{{__('translations.create')}} {{__('translations.user')}}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{__('translations.first_name')}}</th>
                                        <th>{{__('translations.last_name')}}</th>
                                        <th>{{__('translations.email')}}</th>
                                        <th>{{__('translations.phone')}}</th>
                                        <th>{{__('translations.role')}}</th>
                                        <th>{{__('translations.action')}}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                @if($user->hasRole('super_broker'))
                                                    @for($i = 0; $i < count($languages); $i++)
                                                        @if($languages[$i] === app()->getLocale())
                                                            {{$user->translations[$i]->name}}
                                                        @endif
                                                    @endfor
                                                @else
                                                    {{$user->first_name}}
                                                @endif
                                            </td>
                                            <td>{{$user->last_name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->phone}}</td>
                                            <td>
                                                @foreach($user->roles as $role)
                                                    {{$role->name}}
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <ul class="list-inline m-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{route('edit_user',$user->id)}}" class="btn btn-warning btn-sm">
                                                                <i class="c-icon cil-pen"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a onclick="return confirm('Are you sure?')" href="{{route('delete_user',$user->id)}}" class="btn btn-danger btn-sm">
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
                                {{ $users->links() }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
