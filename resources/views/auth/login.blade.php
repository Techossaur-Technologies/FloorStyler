@extends('layouts.log')

@section('content')
<div class="login-container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
                <h3>Please LogIn To {{config('global.siteTitle')}}</h3>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                   <form role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="control-label" for="username">Username</label>
                            <input id="email" type="email" placeholder="example@domain.com" class="form-control" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            <span class="help-block small">Your unique username to app</span>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="control-label" for="password">Password</label>
                            <input id="password" type="password" placeholder="*********" class="form-control" name="password">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            <span class="help-block small">Your strong password</span>
                        </div>
                        <!-- <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="i-checks" name="remember"> Remember Me
                                    <p class="help-block small">(if this is a private computer)</p>
                                </label>
                            </div>
                        </div> -->

                        <div class="form-group" align="center">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fa fa-btn fa-sign-in"></i> Login
                            </button>
                            <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            <a class="btn btn-link" href="{{ url('/register') }}">Create New User</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            {{config('global.currentYear')}} Copyright@ {!!HTML::link(config('global.appWebPage'),config('global.companyName'), array('target'=>'_blank'))!!}
        </div>
    </div>
</div>
@endsection




