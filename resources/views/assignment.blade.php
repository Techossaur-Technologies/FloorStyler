@extends('layouts.apps')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Assignment </li>
                    <li class="active">
                        <span> Assignmnet List</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> List of Assignment </h2>
        </div>
    </div>
</div>
<div class="content animate-panel">

    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-body">
                    <p align="right">
                        {{link_to_route('addassignment', $title = 'Add Assignment', $parameters = array(), $attributes = array('type'=>'button', 'class'=>'btn w-xs btn-info'))}}
                    </p>                
                    @if (Session::has('message'))
                       <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message') }}</div>
                    @endif

                    <table id="example1" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Address Name</th>
                            @if (Auth::user()->user_type != 'USER')
                            <th>Photographer</th>
                            @endif
                            <th>Agency</th>
                            @if (Auth::user()->user_type == 'ADMIN')
                            <th>Organization</th>
                            @endif
                            <th>Blueprints</th>
                            <th>Status</th>
                            <th>BoligID</th>
                            <th>Updated At</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{!! HTML::script('admintheme/vendor/jquery/dist/jquery.min.js') !!}

{!! HTML::style('admintheme/vendor/datatables_plugins_homer/integration/bootstrap/3/dataTables.bootstrap.css') !!}
{!! HTML::script('plugins/bootbox.min.js') !!}
{!! HTML::script('plugins/jquery-loadmask-master/jquery.loadmask.min.js') !!}

{!! HTML::style('plugins/jquery-loadmask-master/jquery.loadmask.css') !!}

{!! HTML::script('admintheme/vendor/datatables_homer/media/js/jquery.dataTables.min.js') !!}

{!! HTML::script('admintheme/vendor/datatables_plugins_homer/integration/bootstrap/3/dataTables.bootstrap.min.js') !!}

<script type="text/javascript">
    $('div.alert').delay(5000).slideUp(300);

    var token = $('meta[name="csrf-token"]').attr('content');

    var example1 = $('#example1').dataTable({
      processing: true,
      serverSide: true,
      dom: 'lBfrtip',
      bProcessing: true,
      oLanguage: {
          sProcessing: "Please Wait...",
          sEmptyTable: "No data found."
      },
      iDisplayLength: 10,
      bSort : false,
      aaSorting: [],
      responsive: true,
      ordering: false,
      ajax:{
        url :"assignment/list", // json datasource
        type: "post",
        data: { _token: '{!! csrf_token() !!}'}
      }
    });
    $('#example1').on('click', '.fa-trash', function(){
        var id = $(this).attr('id');
        bootbox.confirm("Are you sure to delete this assignment?", function(result) {
            if (result == true) {
                // example1.api().ajax.reload();
                // window.location.href = "assignment/delete/"+id;
                $.ajax({
                   type: "post",
                   url: '{{URL::to('assignment/delete')}}',
                   headers: {'X-CSRF-TOKEN': token},
                   dataType : 'json',
                   data : {id: id},
                   cache: false,
                   success:function(data){
                     if(data.status == 'success'){
                        bootbox.alert(data.message);
                        $('#example1').unmask();
                        example1.api().ajax.reload();
                      } else {
                        bootbox.alert(data.message);
                        $('#example1').unmask();
                      }
                    }
                });
            } else {

            }
        });
    });

    $('#example1').on('click', '.fa-check-square-o, .fa-recycle', function(){
        var id = $(this).attr('id');
        var status = $(this).attr('title');
        bootbox.confirm("Are you sure to set "+status+" this assignment?", function(result) {
            if (result == true) {
                $.ajax({
                   type: "post",
                   url: '{{URL::to('assignment/status')}}',
                   headers: {'X-CSRF-TOKEN': token},
                   dataType : 'json',
                   data : {id: id},
                   cache: false,
                   success:function(data){
                     if(data.status == 'success'){
                        bootbox.alert(data.message);
                        $('#example1').unmask();
                        example1.api().ajax.reload();
                      } else {
                        bootbox.alert(data.message);
                        $('#example1').unmask();
                      }
                    }
                });
            } else {

            }
        });
    });

    $('#example1').on('click', '.linktobolig', function(){
        var id = $(this).attr('id');
        bootbox.dialog({
                title: "<h3>Please provide assignment ID of Boligofotografer App.</h3>",
                message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    '<form id="formBoligApp" class="form-horizontal"> ' +
                    '<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="name">Assignment ID</label> ' +
                    '<div class="col-md-4"> ' +
                    '<input id="app_id" name="app_id" type="number" placeholder="123" class="form-control input-md">' +
                    '</div> ' +
                    '</div> ' +
                    '<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="operation_type">Operation Type</label> ' +
                    '<div class="col-md-4"> ' +
                    '<select name = "operation_type" id = "operation_type" class="form-control">'+
                    '<option value="ADD">ADD</option><option value="EDIT">EDIT</option><option value="REMOVE">REMOVE</option>'+
                    '</select> ' +
                    '</div> ' +
                    '</div> ' +
                    '</form> </div>  </div>',
                buttons: {
                    success: {
                        label: "Post",
                        className: "btn-success",
                        callback: function () {
                            var operation_type = $('#operation_type').val();
                            var app_id = $('#app_id').val();
                            $('#example1').mask('Please Wait...');

                            $.ajax({
                               type: "post",
                               url: '{{URL::to('addBoligAppID')}}',
                               headers: {'X-CSRF-TOKEN': token},
                               dataType : 'json',
                               data : $('#formBoligApp').serialize()+ "&id=" + id,
                               cache: false,
                               success:function(data){
                                 if(data.status == 'success'){
                                    bootbox.alert(data.message);
                                    $('#example1').unmask();
                                    location.reload();
                                  } else {
                                    bootbox.alert(data.message);
                                    $('#example1').unmask();
                                  }
                                }
                            });
                        }
                    }
                }
            });
    });
</script>

@endsection