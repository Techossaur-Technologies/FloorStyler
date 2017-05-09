@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Assignment </li>
                    <li class="active">
                        <span> Assignmnet List</span>
                    </li>
                    <li class="active">
                        <span> Add Floorplan </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Assignment ID#{{$assignment['id']}} </h2>
        </div>
    </div>
</div>
<div class="content animate-panel">

    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-body">
                    <div class="pull-left">
                        @if (Session::has('message'))
                           <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message') }}</div>
                        @endif
                    </div>
                    <div class="pull-right">

                    </div>
                    
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>
                                  <span class="pull-left">Assignment ID:</span>
                                  <span class="pull-right">{{$assignment['id']}}</span>
                                </td>
                                <td>
                                  <span class="pull-left">Address:</span>
                                  <span class="pull-right">{{$assignment['name']}}</span>
                                </td>
                                <td>
                                  <span class="pull-left">No. of Blueprints:</span>
                                  <span class="pull-right">{{count($assignment->raw_plan->where('type', 'SKETCH'))}}</span>
                                </td>
                                <td>
                                  <span class="pull-left">User Name:</span>
                                  <span class="pull-right">{{$assignment->user['fname']." ".$assignment->user['lname']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  <span class="pull-left">Agency:</span>
                                  <span class="pull-right">{{$assignment->agency['name']}}</span>
                                </td>
                                <td>
                                  <span class="pull-left">Created At:</span>
                                  <span class="pull-right">{{$assignment['created_at']}}</span>
                                </td>
                                <td>
                                  <span class="pull-left">Last Updated At:</span>
                                  <span class="pull-right">{{$assignment['updated_at']}}</span>
                                </td>
                                <td>
                                  <span class="pull-left">Status:</span>
                                  <span class="pull-right">{{$assignment['status']}}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel-body">
                    @if (Session::has('message'))
                       <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message') }}</div>
                    @endif
                    {{Form::open(array('id'=>'formdata','files'=>true,'action' => 'assignmentController@update_fp', 'method'=>'POST', 'enctype'=>"multipart/form-data"))}}
                        <div class="form-group">
                            {!! Form::file('images[]', array('multiple'=>true, 'class'=>'btn btn-default')) !!}
                            @if ($errors->has('file'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('file') }}</strong>
                                </span>
                            @endif
                        </div>

                        <input class="form-control" type="hidden" name="assignment_id" id="assignment_id" value="{{Crypt::encrypt($assignment->id)}}">
                        <input class="form-control" type="hidden" name="assignment_name" id="assignment_name" value="{{$assignment->name}}">
                        <div class="form-group">
                            <label for="comment" class="control-label">Add Comment:</label>
                            <input class="form-control" name="comment" id="comment">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn w-xs btn-success" name="submit">Add Floorplan</button>
                            <a class="btn w-xs btn-info" href="{{ URL::previous() }}">Back</a>
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
            'images[]': {
              required: true,
              accept: 'image/jpeg,image/png'
            }
          },
          messages: {
            'images[]': {
              required: "Select Blueprints",
              accept: 'Only jpg and png supported'
            }
          }
        });
    });
</script>
@endsection