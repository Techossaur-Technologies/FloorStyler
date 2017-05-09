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
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> List of Agency </h2>
        </div>
    </div>
</div>
<div class="content animate-panel">

    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-body">
                    <p align="right">
                        {{link_to_route('addagency', $title = 'Add Agency', $parameters = array(), $attributes = array('type'=>'button', 'class'=>'btn w-xs btn-info'))}}
                    </p>                
                    @if (Session::has('message'))
                       <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message') }}</div>
                    @endif
                    <table id="example2" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Agency Name</th>
                            <th>Linked Org.</th>
                            <th>Status</th>
                            <th>Updated At</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($agencies as $agency)
                            <tr>
                                <th>{{$agency['id']}}</th>
                                <th>{{$agency['name']}}</th>
                                <th>{{$agency->organization->name}}</th>
                                <th>{{$agency['status']}}</th>
                                <th>{{$agency['updated_at']}}</th>
                                <th>{{$agency['created_at']}}</th>
                                <th>
                                    <a style="font-size: medium;" class="fa fa-pencil-square-o" href="agency/edit/{{$agency['name']}}/{{Crypt::encrypt($agency['id'])}}"></a>

                                    <a style="font-size: medium;" class="fa fa-trash-o" id="{{Crypt::encrypt($agency['id'])}}"></a>
                                    @if($agency['status'] == 'ALIVE')
                                        <a style="font-size: medium;" class="fa fa-times" id="{{Crypt::encrypt($agency['id'])}}"></a>
                                    @else
                                        <a style="font-size: medium;" class="fa fa-check" id="{{Crypt::encrypt($agency['id'])}}"></a>
                                    @endif

                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{!! HTML::script('admintheme/vendor/jquery/dist/jquery.min.js') !!}

{!! HTML::style('admintheme/vendor/datatables_plugins_homer/integration/bootstrap/3/dataTables.bootstrap.css') !!}

{!! HTML::script('plugins/bootbox.min.js') !!}
{!! HTML::script('admintheme/vendor/datatables_homer/media/js/jquery.dataTables.min.js') !!}

{!! HTML::script('admintheme/vendor/datatables_plugins_homer/integration/bootstrap/3/dataTables.bootstrap.min.js') !!}

<script type="text/javascript">
        $('.fa-trash-o').on('click', function(){
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure to delete?", function(result) {
                if (result == true) {
                    window.location.href = "agency/delete/"+id;
                } else {

                }
            });
        });
        $('.fa-check').on('click', function(){
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure to activate this agency?", function(result) {
                if (result == true) {
                    window.location.href = "agency/status/"+id;
                } else {

                }
            });
        });
        $('.fa-times').on('click', function(){
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure to inactivate this agency?", function(result) {
                if (result == true) {
                    window.location.href = "agency/status/"+id;
                } else {

                }
            });
        });
        $('div.alert').delay(5000).slideUp(300);
        $('#example2').dataTable();
</script>

@endsection