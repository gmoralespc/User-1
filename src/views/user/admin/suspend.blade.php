@extends('admin.layouts.create')

@section('heading')
<h1>
    {{ Lang::get('user::package.name') }}
    <small> {{ Lang::get('app.manage') }} {{ Lang::get('user::package.names') }}</small>
</h1>
@stop

@section('title')
Suspend User
@stop

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i> {{  Lang::get('app.home') }}</a></li>
    <li><a href="{{ URL::to('admin/user')}}">{{ Lang::get('user::user.module.names') }}</a></li>
    <li class="active">Suspend User</li>
</ol>

@stop

@section('buttons')
<a class="btn btn-info pull-right view-btn-back" href="{{ URL::to('admin/user/user') }}"><i class="fa fa-angle-left"></i> {{  Lang::get('app.back') }}</a>
@stop
@section('content')

{{Former::vertical_open()
    ->id('user')
    ->secure()
    ->method('POST')
    ->action(URL::to('/admin/user/user/suspend/'.$id))}}
    {{Former::hidden('id')}}
    <div class="box-body">
    <div class="row">
        <div class="col-md-12">


            {{ Former::text('minutes')
            -> label('user::user.label.minutes')
            -> placeholder('user::user.placeholder.minutes')}}
        </div>
    </div>
    <div class="tab-footer">
        <div class="row">
            <div class="col-md-12">

                {{ Form::hidden('id', $id) }}

                {{ Form::submit(trans('user::user.suspend').'!', array('class' => 'btn btn-primary')) }}
            </div>
        </div>
    </div>
    </div>
    {{ Former::close() }}

    @stop