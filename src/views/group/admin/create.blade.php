@extends('admin.layouts.create')

@section('heading')
<h1>
    {{ Lang::get('user::group.name') }}
    <small> {{ Lang::get('app.manage') }} {{ Lang::get('user::group.names') }}</small>
</h1>
@stop

@section('title')
{{Lang::get('app.new')}} {{Lang::get('user::group.name')}}
@stop

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i> {{  Lang::get('app.home') }}</a></li>
    <li><a href="{{ URL::to('admin/user/group') }}">{{ Lang::get('user::group.names') }}</a></li>
    <li class="active">{{ Lang::get('app.new') }} {{ Lang::get('user::group.name') }}</li>
</ol>
@stop


@section('buttons')
<a class="btn btn-info pull-right   btn-xs" href="{{ URL::to('admin/user/group') }}"><i class="fa fa-angle-left"></i> {{  Lang::get('app.back') }}</a>
@stop

@section('content')

{{Former::vertical_open()
    ->id('group')
    ->method('POST')
    ->files('true')
    ->action(URL::to('admin/user/group'))}}
    <div class="box-body">
        <div class="row">
            <div class="col-md-12 ">
                {{ Former::text('name')
                -> label('user::group.label.name')
                -> placeholder('user::group.placeholder.name')}}
            </div>
            <div class="col-md-12 ">
                {{ Form::label(trans('user::group.label.permissions')) }}
            </div>
            <div class="col-md-12 ">
                @foreach($rights['default'] as $permission)
                    <label class="checkbox-inline">
                        {{ Form::checkbox("permissions[$permission]", 1 ) }} {{$permission}}
                    </label>
                @endforeach
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-md-12">
                {{Former::actions()
                ->large_primary_submit(Lang::get('app.save'))
                ->large_default_reset(Lang::get('app.reset'))}}
            </div>

        </div>
    </div>

    {{ Former::close() }}
    @stop