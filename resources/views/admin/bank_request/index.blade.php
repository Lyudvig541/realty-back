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
                                {{ __('translations.bank_requests') }}
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{__('translations.first_name')}} {{__('translations.last_name')}}</th>
                                        <th>{{__('translations.company')}} {{__('translations.name')}} </th>
                                        <th>{{ __('translations.bedrooms') }}</th>
                                        <th>{{ __('translations.bathrooms') }}</th>
                                        <th>{{ __('translations.property_price') }}</th>
                                        <th>{{ __('translations.property_size') }}</th>
                                        <th>{{ __('translations.file') }}</th>
                                        <th>{{__('translations.action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($bank_requests as $bank_request)
                                        <tr>
                                            <td>{{$bank_request->user->first_name}} {{$bank_request->user->last_name}}</td>
                                            <td>{{$bank_request->company->name}}</td>
                                            <td>{{$bank_request->bedrooms}} </td>
                                            <td>{{$bank_request->bathrooms}} </td>
                                            <td>{{$bank_request->property_price}} </td>
                                            <td>{{$bank_request->property_size}} </td>
                                            <td>{{$bank_request->file}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <ul class="list-inline m-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{route('delete_bank_requests', $bank_request->id)}}" class="btn btn-danger btn-sm">
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
                                {{$bank_requests->links()}}
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
