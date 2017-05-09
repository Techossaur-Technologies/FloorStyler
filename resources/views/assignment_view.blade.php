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
                        <span> View Assignmnet </span>
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
                        <a class="btn w-xs btn-info" href="{{ url('assignment')}}">Back</a>
                        {{link_to_route('assignment.addfp', $title = ' Add Floorplan', $parameters = array('name'=>$assignment['name'], 'id'=>Crypt::encrypt($assignment['id'])), $attributes = array('class'=>"btn btn-outline btn-info fa fa-arrow-circle-up"))}}

                        {{link_to_route('assignment.addcomment', $title = ' Add Comment', $parameters = array('name'=>$assignment['name'], 'id'=>Crypt::encrypt($assignment['id'])), $attributes = array('class'=>"btn btn-outline btn-info fa fa-comments-o"))}}

                        {{link_to_route('assignment.edit', $title = ' Edit', $parameters = array('name'=>$assignment['name'], 'id'=>Crypt::encrypt($assignment['id'])), $attributes = array('class'=>"btn btn-outline btn-info fa fa-pencil-square-o"))}}
                    </div>
                </div>
                <div class="panel-body">                
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
                @foreach($assignment_details as $assignment_detail)
                <div class="panel-body">
                    <div class="media">
                        <div class="media-body">
                            <strong>{{$assignment_detail['created_at']}}</strong><br>
                            <h5>{{$assignment_detail['type']}}
                            @if($assignment_detail['type'] == 'COMMENT')
                                <?php
                                    $commentBy = App\User::find($assignment_detail['commentBy']);
                                ?>
                                By {{$commentBy->fname}} {{$commentBy->lname}} ({{$commentBy->user_type}})

                            @endif</h5>
                            <?php
                                $images = explode(",", $assignment_detail['paths']);
                            ?>
                            <div class="lightBoxGallery">
                            @if($assignment_detail['paths'] != "")
                                @foreach($images as $image)
                                    <a href="{{config('global.baseURL').'/'.$image}}" title="Image from Unsplash" data-gallery=""><img src="{!!Image::url($image,150,200,array('crop'))!!}"></a>
                                @endforeach
                            @endif
                            @if($assignment_detail['comment'] != "")
                                <div class="panel-footer"><b>{{$assignment_detail['comment']}}</b></div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
{!! HTML::script('plugins/jquery-loadmask-master/jquery.loadmask.min.js') !!}
{!! HTML::style('plugins/jquery-loadmask-master/jquery.loadmask.css') !!}
{!! HTML::style('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') !!}
{!! HTML::script('plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.5') !!}
{!! HTML::script('admintheme/vendor/blueimp-gallery/js/jquery.blueimp-gallery.min.js') !!}
{!! HTML::style('admintheme/vendor/blueimp-gallery/css/blueimp-gallery.min.css') !!}
    <!-- <link rel="stylesheet" href="vendor/blueimp-gallery/css/blueimp-gallery.min.css" /> -->
<!-- <script src="vendor/blueimp-gallery/js/jquery.blueimp-gallery.min.js"></script> -->

<style>

    .lightBoxGallery {
        text-align: center;
    }

    .lightBoxGallery a {
        margin: 5px;
        display: inline-block;
    }

</style>
<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox();
    });
    $('div.alert').delay(5000).slideUp(300);

</script>
@endsection