@extends('admin.layouts.index')
@section('heading')
        <h1>
            {{ Lang::get('user::group.name') }}
            <small> {{ Lang::get('app.manage') }} {{ Lang::get('user::group.names') }}</small>
        </h1>
@stop

@section('title')
            {{ Lang::get('user::group.names') }}
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i> {{ Lang::get('app.home') }} </a></li>
        <li class="active">{{ Lang::get('user::group.names') }}</li>
    </ol>
@stop

@section('search')

            <form class="form-horizontal pull-right" action="{{ URL::to('admin/user/group') }}" method="get" style="width:50%;margin-right:5px;">
                {{ Form::token() }}
                <div class="input-group">
                    <input type="search" class="form-control input-sm" name="q" value="{{$q}}"  placeholder="{{  Lang::get('app.search') }}">
                    <span class="input-group-btn">
                        <button class="btn  btn-sm btn-default" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
@stop

@section('buttons')
            <a class="btn   btn-sm btn-info pull-right {{ ($permissions['create']) ? '' : 'disabled' }} view-btn-create" href="{{ URL::to('admin/user/group/create') }}">
                <i class="fa fa-plus-circle"></i> {{ Lang::get('app.new') }} {{ Lang::get('user::group.name') }}
            </a>
@stop

@section('content')
        <table class="table table-condensed">
            <tr>
                <th>{{ Lang::get('user::group.name') }}</th>
                <th>{{ Lang::get('user::group.label.permissions') }}</th>
                <th width="70">{{ Lang::get('app.options') }}</th>
            </tr>
                @foreach ($groups as $group)
                <tr>
                    <td><a href="{{ ($permissions['view']) ? (URL::to('admin/user/group/') . '/' . $group->id ) : '#' }}">{{ $group->name }}</a></td>
                    <td>{{ (isset($group['permissions']['admin'])) ? '<i class="icon-ok"></i> Admin' : ''}} {{ (isset($group['permissions']['users'])) ? '<i class="icon-ok"></i> Users' : ''}}</td>
                    <td>
                        <div class="btn-group  btn-group-xs">
                            <a type="button" class="btn btn-info  {{ ($permissions['edit']) ? '' : 'disabled' }} view-btn-edit" href="{{ URL::to('admin/user/group')}}/{{$group->id}}/edit" title="{{ Lang::get('app.update') }} group"><i class="fa fa-pencil-square-o"></i></a>
                            <a type="button" class="btn btn-danger action_confirm  {{ ($permissions['delete']) ? '' : 'disabled' }} view-btn-delete" data-method="delete" href="{{ URL::to('admin/user/group') }}/{{ $group->id }}" title="{{ Lang::get('app.delete') }} group"><i class="fa fa-times-circle-o"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
        </table>
@stop








<!--




<div class='row view-toolbar'>
    {{-- Breadcrumbs --}}
    <div class="col-md-4 col-xs-12 view-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin') }}"> {{ Lang::get('app.home') }} </a></li>
            <li class="active">{{ Lang::get('user::group.names') }}</li>
        </ol>
    </div>
    <div class="col-md-6 col-xs-8 view-search">
        <form class="form-horizontal" action="{{ URL::to('admin/user/user') }}" method="get">
            {{ Form::token() }}
            <div class="input-group">
                <input type="search" class="form-control" name="q" value="{{$q}}"  placeholder="{{  Lang::get('app.search') }}">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
    </div>

    {{-- Buttons --}}
    <div class="col-md-2 col-xs-4 view-buttons">
        <a class="btn btn-info pull-right {{ ($permissions['create']) ? '' : 'disabled' }} view-btn-create" href="{{ URL::to('admin/user/group/create') }}">
            <i class="fa fa-plus-circle"></i> {{ Lang::get('app.new') }} {{ Lang::get('user::group.name') }}
        </a>
    </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <th>{{trans('user::group.name')}}</th>
                <th>{{trans('user::group.permissions')}}</th>
                <th width='70'>{{trans('app.options')}}</th>
            </thead>
            <tbody>
            @foreach ($groups as $group)
                <tr>
                    <td><a href="groups/{{ $group->id }}">{{ $group->name }}</a></td>
                    <td>{{ (isset($group['permissions']['admin'])) ? '<i class="icon-ok"></i> Admin' : ''}} {{ (isset($group['permissions']['users'])) ? '<i class="icon-ok"></i> Users' : ''}}</td>
                    <td>
                    <div class="btn-group  btn-group-xs">
                        <a type="button" class="btn btn-info  {{ ($permissions['edit']) ? '' : 'disabled' }} view-btn-edit" href="{{ URL::to('admin/user/group')}}/{{$group->id}}/edit" title="{{ Lang::get('app.update') }} user"><i class="fa fa-pencil-square-o"></i></a>
                        <a type="button" class="btn btn-danger action_confirm  {{ ($permissions['delete']) ? '' : 'disabled' }} view-btn-delete" data-method="delete" href="{{ URL::to('admin/user/group') }}/{{ $group->id }}" title="{{ Lang::get('app.delete') }} user"><i class="fa fa-times-circle-o"></i></a>
                    </div>
                     </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
   </div>
</div>

-->