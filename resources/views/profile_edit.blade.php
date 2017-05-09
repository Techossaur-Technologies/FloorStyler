@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Settings </li>
                    <li class="active">
                        <span>Edit Profile</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">Edit Profile</h2>
        </div>
    </div>
</div>
<div class="content animate-panel">

    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-body">
                    <div class="profile-picture">
                        @if(!empty(Auth::user()->user_image))
                            {!! HTML::image(Auth::user()->image_path, 'alt', array('class'=>'img-circle m-b', 'width'=>'150', 'height'=>'150')) !!}
                        @else
                            {!!HTML::image('storage/user_images/default.png', 'alt', array('class'=>'img-circle m-b', 'width'=>'50', 'height'=>'50'))!!}
                        @endif
                        <div class="stats-label text-color">
                            <span class="font-extra-bold font-uppercase">{{Auth::user()->fname." ".Auth::user()->lname}}</span>
                        </div>
                    </div>
                    @if (Session::has('message'))
                       <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message') }}</div>
                    @endif
                    {{Form::open(array('files'=>true, 'action' => 'settingsController@update_profile', 'method'=>'POST', 'enctype'=>"multipart/form-data"))}}
                        <div class="form-group">
                            <label for="profile_photo" class="control-label">Add Profile Photo:</label>
                            {!! Form::file('images[]') !!}

                            @if ($errors->has('file'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('file') }}</strong>
                                </span>
                            @endif
                        </div>
                        <input class="form-control" type="hidden" name="user_id" id="user_id" value="{{Crypt::encrypt(Auth::user()->id)}}">

                        <div class="form-group">
                            <label for="first_name" class="control-label">First Name:</label>
                            <input class="form-control" type="text" name="first_name" id="first_name" value="{{Auth::user()->fname}}">
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="control-label">Last Name:</label>
                            <input class="form-control" type="text" name="last_name" id="last_name" value="{{Auth::user()->lname}}">
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">Email ID:</label>
                            <input class="form-control" type="text" name="email" id="email" value="{{Auth::user()->email}}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn w-xs btn-success" name="submit">Save Profile</button>
                            <a class="btn w-xs btn-info" href="{{  URL::previous() }}">Back</a>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
{!! HTML::script('admintheme/vendor/jquery/dist/jquery.min.js') !!}

<script type="text/javascript">
    $('div.alert').delay(5000).slideUp(300);
    
</script>

@endsection