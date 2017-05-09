@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Settings </li>
                    <li class="active">
                        <span>Change Password</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">Change Password</h2>
        </div>
    </div>
</div>
<div class="content animate-panel">

    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-body">
                    @if (Session::has('message'))
                       <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message') }}</div>
                    @endif
                    {{Form::open(array('id'=>'formdata','action' => 'settingsController@updatePassword', 'method'=>'POST'))}}
                        <div class="form-group">
                            <label for="currentPassword" class="control-label">Current Password:</label>
                            <input class="form-control" type="password" name="currentPassword" id="currentPassword">
                            @if ($errors->has('currentPassword'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('currentPassword') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="newPassword" class="control-label">New Password:</label>
                            <input class="form-control" type="password" name="newPassword" id="newPassword">
                            @if ($errors->has('newPassword'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('newPassword') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="corfirmPassword" class="control-label">Confirm Password:</label>
                            <input class="form-control" type="password" name="corfirmPassword" id="corfirmPassword">
                            @if ($errors->has('corfirmPassword'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('corfirmPassword') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn w-xs btn-success" name="submit">Save Password</button>
                            <a class="btn w-xs btn-info" href="{{  URL::previous() }}">Back</a>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
{!! HTML::script('admintheme/vendor/jquery/dist/jquery.min.js') !!}
{!! HTML::script('plugins/jquery-loadmask-master/jquery.loadmask.min.js') !!}
{!! HTML::style('plugins/jquery-loadmask-master/jquery.loadmask.css') !!}
{!! HTML::script('plugins/jquery-validation-1.15.0/dist/jquery.validate.min.js') !!}
{!! HTML::script('plugins/jquery-validation-1.15.0/dist/additional-methods.min.js') !!}
<script type="text/javascript">
    jQuery.validator.setDefaults({ 
        debug: false 
        //success: "valid" 
    });
    $(document).ready(function(){
        $('div.alert').delay(5000).slideUp(300);
        $("#formdata").validate({
          rules: {
            'currentPassword': {
                required: true
            },
            'newPassword': {
                required: true
            },
            'corfirmPassword': {
                // required: true,
                equalTo: '#newPassword'
            }
          },
          messages: {
            'currentPassword': {
                required: "Please type Current Password"
            },
            'newPassword': {
                required: "Please type New Password"
            },
            'corfirmPassword': {
                equalTo: 'New Password not matched'
                // required: "Please re-type New Password Again"
            }
          }
        });
        // $('button[name="submit"]').on('click', function(){
        //     $('.panel-body').mask('Please Wait...');
        // })
    });
    
</script>

@endsection