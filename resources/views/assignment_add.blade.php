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
                        <span> Add Assignmnet </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Add an Assignment </h2>
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
                    {{Form::open(array('files'=>true,'id'=>'formdata','action' => 'assignmentController@create', 'method'=>'POST', 'enctype'=>"multipart/form-data"))}}
                        <div class="form-group">
                            {!! Form::file('images[]', array('multiple'=>true, 'class'=>'btn-primary2')) !!}
                            @if ($errors->has('file'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('file') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="assignment_name" class="control-label">Address Name:</label>
                            <input class="form-control" type="text" name="assignment_name" id="assignment_name">
                            @if ($errors->has('assignment_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('assignment_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Photographer:</label>
                            <div class="input-group">
                                <select class="form-control m-b" name="user" id="user">
                                    <option selected disabled value="">Select Photographer</option>
                                    @foreach($user as $user)
                                    <option value="{{$user['id']}}">{{$user['fname'].' '.$user['lname']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('user'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('user') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Agency:</label>
                            <div class="input-group">
                                <select class="form-control m-b" name="agency" id="agency">
                                    <option selected value="1">None</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn w-xs btn-success" name="submit">Add Assignment</button>
                            <a class="btn w-xs btn-info" href="{{ url('assignment')}}">Back</a>
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
              accept: 'image/jpeg'
            },
            'assignment_name': {
                required: true
            },
            'user': {
                required: true
            }
          },
          messages: {
            'images[]': {
              required: "Select Blueprints"
            },
            'assignment_name': {
                required: 'Please type Assignment name'
            },
            'user': {
                required: 'Please Select a User Name'
            }
          }
        });
    });
    $('#user').change(function(){
      getagency();
    });
    function getagency(){
      var user_id = $('#user').val();
      var token = $('input[name=_token]').val();
      $.ajax({
        'type':'post',
        'url':'{{URL::to('postagency')}}',
        'headers': {'X-CSRF-TOKEN': token},
        'data':{'user_id':user_id},
        'dataType':'json',
        'beforeSend':function(){ $('.row').mask('Please Wait...'); },
        'success':function(resp){
            $('#agency').children('option').empty().remove();
            $.each(resp,function(intex,info){
              $('<option value="'+ info.id +'">'+ info.name +'</option>').appendTo('#agency');
              $('.row').unmask();
            });
        }
      }); 
    }

</script>
@endsection