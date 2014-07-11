@extends('admin.layouts.show')
@section('heading')
<h1>
    {{ Lang::get('user::group.name') }}
    <small> {{ Lang::get('app.manage') }} {{ Lang::get('user::group.names') }}</small>
</h1>
@stop

@section('title')
{{$group['name']}} {{Lang::get('user::group.name')}}
@stop

@section('breadcrumb')
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i> {{ Lang::get('app.home') }}</a></li>
                <li><a href="{{ URL::to('admin/user/group') }}">{{ Lang::get('user::group.names') }}</a></li>
                <li class="active">{{ $group['name'] }}</li>
            </ol>

@stop

@section('buttons')
            <a class="btn btn-info  btn-xs" href="{{ URL::to('admin/user/group') }}" ><i class="fa fa-angle-left"></i> {{ Lang::get('app.back') }}</a>
            
@stop



@section('content')
<div class="row">
    <div class="col-md-6 ">
        <div class="form-group">
            <label for="order">
                {{ Lang::get('user::group.label.name') }}
            </label><br />
            {{ $group['name'] }}
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label for="image">
                {{ Lang::get('user::group.label.permissions') }}
            </label><br />
            {{ (isset($group['permissions']['admin'])) ? '<i class="icon-ok"></i> Admin' : ''}} {{ (isset($group['permissions']['users'])) ? '<i class="icon-ok"></i> Users' : ''}}
        </div>
    </div>
</div>
@stop




















