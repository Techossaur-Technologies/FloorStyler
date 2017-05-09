@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Settings </li>
                    <li class="active">
                        <span>Email Template</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">Email Template</h2>
        </div>
    </div>
</div>
<div class="content animate-panel">

    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-body">


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