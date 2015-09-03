@extends('admin::curd.index')
@section('heading')
<i class="fa fa-file-text-o"></i> {!! trans('user::user.name') !!} <small> {!! trans('cms.manage') !!} {!! trans('user::user.names') !!}</small>
@stop
@section('title')
{!! trans('user::user.names') !!}
@stop
@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{!! URL::to('admin') !!}"><i class="fa fa-dashboard"></i> {!! trans('cms.home') !!} </a></li>
    <li class="active">{!! trans('user::user.names') !!}</li>
</ol>
@stop
@section('entry')
<div class="box box-warning" id='entry-user'>
</div>
@stop
@section('tools')
@stop
@section('content')
<table id="main-list" class="table table-striped table-bordered">
    <thead>
        <th>{!! trans('user::user.label.first_name')!!}</th>
        <th>{!! trans('user::user.label.last_name')!!}</th>
        <th>{!! trans('user::user.label.email')!!}</th>
        <th>{!! trans('user::user.label.sex')!!}</th>
        <th>{!! trans('user::user.label.designation')!!}</th>
    </thead>
</table>
@stop
@section('script')
<script type="text/javascript">
var oTable;
$(document).ready(function(){
    $('#entry-user').load('{{URL::to('admin/user/user/0')}}');
    oTable = $('#main-list').dataTable( {
        "ajax": '{{ URL::to('/admin/user/user/list') }}',
        "columns": [
        { "data": "first_name" },
        { "data": "last_name" },
        { "data": "email" },
        { "data": "sex" },
        { "data": "designation" },],
        "userLength": 50
    });
    $('#main-list tbody').on( 'click', 'tr', function () {
        $(this).toggleClass("selected").siblings(".selected").removeClass("selected");
        var d = $('#main-list').DataTable().row( this ).data();
        $('#entry-user').load('{{URL::to('admin/user/user')}}' + '/' + d.id);
    });
});
</script>
@stop
@section('style')
@stop