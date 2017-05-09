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
                        <span> Edit Agency </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Edit Agency Id#{{$agencies->id}} </h2>
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

                    {{Form::open(array('action' => 'agencyController@update', 'method'=>'POST', 'id'=>'formdata', 'enctype'=>"multipart/form-data"))}}
                        <input class="form-control" type="hidden" name="agency_id" id="agency_id" value="{{Crypt::encrypt($agencies->id)}}">

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
                            <input class="form-control" type="text" name="agency_name" id="agency_name" value="{{$agencies->name}}">

                            @if ($errors->has('agency_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('agency_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn w-xs btn-success" name="submit">Edit Agency</button>
                            <a class="btn w-xs btn-info" href="{{url('agency')}}">Back</a>

                        </div>
                    {{Form::close()}}
                </div>
                <div class="panel-body">
                    <div class="lightBoxGallery">
                        <a href="{{config('global.baseURL').'/'.$agencies->logo_path}}" title="{{config('global.siteTitle')}} images" data-gallery=""><img src="{!!Image::url($agencies->logo_path,930,200,array('crop'))!!}"></a>

                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
{!! HTML::script('admintheme/vendor/jquery/dist/jquery.min.js') !!}
{!! HTML::script('plugins/jquery-validation-1.15.0/dist/jquery.validate.min.js') !!}
{!! HTML::script('plugins/jquery-validation-1.15.0/dist/additional-methods.min.js') !!}
<!-- {!! HTML::style('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') !!} -->

<!-- {!! HTML::script('plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.5') !!} -->

{!! HTML::script('admintheme/vendor/blueimp-gallery/js/jquery.blueimp-gallery.min.js') !!}

{!! HTML::style('admintheme/vendor/blueimp-gallery/css/blueimp-gallery.min.css') !!}
<script type="text/javascript">
jQuery.validator.setDefaults({ 
    debug: false 
    //success: "valid" 
});
$(document).ready(function(){

    $('div.alert').delay(5000).slideUp(300);
    $("#formdata").validate({
      rules: {
        'agency_name': {
            required: true
        }
      },
      messages: {
        'agency_name': {
            required: 'Please type agency name',
            accept: 'Only jpeg or jpg supported'
        }
      }
    });
});

</script>
@endsection