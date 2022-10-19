@extends('layouts.auth_app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mx-4">
                    <div class="card-body p-4">
                        <h1 class="text-center">Agent/Broker Register</h1>
                        <p class="text-muted">Create your account</p>
                        <form class="user" method="POST" action="{{ route('agent_request') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="c-icon cil-user"></i>
                                    </span>
                                </div>
                                <input type="text"
                                       class="form-control  @error('first_name') is-invalid @enderror"
                                       name="first_name" value="{{ old('first_name') }}"
                                       required autocomplete="first_name"
                                       placeholder="First Name"
                                       autofocus>
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="c-icon cil-user"></i>
                                    </span>
                                </div>
                                <input type="text"
                                       class="form-control  @error('last_name') is-invalid @enderror"
                                       name="last_name" value="{{ old('last_name') }}"
                                       required autocomplete="last_name"
                                       placeholder="Last Name"
                                       autofocus>
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="c-icon cil-envelope-open"></i>
                                    </span>
                                </div>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}"
                                       required autocomplete="email" id="exampleInputEmail" placeholder="Email Address">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                           <i class="c-icon mr-2 cif-am"></i>
                                            +374
                                        </span>
                                    </div>
                                    <input type="number"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           name="phone" value="{{ old('phone') }}"
                                           required autocomplete="phone"
                                           id="phone"
                                           placeholder="77000000"
                                           autofocus>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-block btn-success" type="submit">Request To Create Account</button>
                        </form>
                    </div>
                    <div class="card-footer p-4">
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="text-center col-5">
                                <a class="small" href="{{route('login')}}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
