@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Agency </li>
                    <li class="active">
                        <span> Agency List</span>
                    </li>
                    <li class="active">
                        <span> Add Agency </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Add an Agency </h2>
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
                    {{Form::open(array('action' => 'agencyController@create', 'method'=>'POST', 'id'=>'formdata', 'enctype'=>"multipart/form-data"))}}
                        <div class="form-group">
                            <label for="agency_logo" class="control-label">Add a logo for agency:</label>
                            {!! Form::file('images[]') !!}
                            @if ($errors->has('images'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('images') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="agency_name" class="control-label">Agency Name:</label>
                            <input class="form-control" type="text" name="agency_name" id="agency_name">
                            @if ($errors->has('agency_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('agency_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn w-xs btn-success" name="submit">Add Agency</button>
                            <a class="btn w-xs btn-info" href="{{ url('agency')}}">Back</a>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
{!! HTML::script('admintheme/vendor/jquery/dist/jquery.min.js') !!}
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
        'images[]': {
          required: true,
          accept: 'image/jpeg'
        },
        'agency_name': {
            required: true
        }
      },
      messages: {
        'images[]': {
          required: "Select a logo"
        },
        'agency_name': {
            required: 'Please type agency name'
        }
      }
    });
});

</script>
@endsection