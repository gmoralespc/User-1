@extends('Admin::views.index')
@section('heading')
<h1>
    {{ Lang::get('user::package.name') }}
    <small> {{ Lang::get('app.manage') }} {{ Lang::get('user::package.names') }}</small>
</h1>
@stop

@section('title')
{{ Lang::get('user::user.module.names') }}
@stop

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i> {{ Lang::get('app.home') }} </a></li>
    <li class="active">{{ Lang::get('user::user.module.names') }}</li>
</ol>
@stop

@section('search')

<form class="form-horizontal pull-right" action="{{ URL::to('admin/user/user') }}" method="get" style="width:50%;margin-right:5px;">
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
<a class="btn   btn-sm btn-info pull-right {{ ($permissions['create']) ? '' : 'disabled' }} view-btn-create" href="{{ URL::to('admin/user/user/create') }}">
    <i class="fa fa-plus-circle"></i> {{ Lang::get('app.new') }} {{ Lang::get('user::user.module.name') }}
</a>
@stop

@section('content')
<table class="table table-condensed">
    <tr>
        <th>{{ Lang::get('user::user.label.name')}}</th>
        <th>{{ Lang::get('user::user.label.email') }}</th>
        <th>{{ Lang::get('user::group.label.permissions') }}</th>
        <th>{{ Lang::get('user::user.label.status') }}</th>
        <th width="140">{{ Lang::get('app.options') }}</th>
    </tr>
    @foreach ($users as $user)
    <tr>
    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
    <td><a href="{{ ($permissions['view']) ? (URL::to('admin/user/user') . '/' . $user->id ) : '#' }}">{{ $user->email }}</a></td>
    <td>
    @foreach ($types as $type)
    {{ ($user->hasAccess($type)) ? ' <i class="fa fa-check-square fa-fw"></i> ' . ucfirst($type) : '<i class="fa fa-times fa-fw"></i> ' . ucfirst($type)}}
    @endforeach
    </td>
    <td>{{ $userStatus[$user->id] }}</td>
    <td>
        <div class="btn-group  btn-group-xs">
            <a type="button" class="btn btn-info  {{ ($permissions['edit']) ? '' : 'disabled' }} view-btn-edit" href="{{ URL::to('admin/user/user')}}/{{$user->id}}/edit" title="{{ Lang::get('app.update') }} user"><i class="fa fa-pencil-square-o"></i></a>

            <a type="button" class="btn btn-warning {{ ($user->id == 1) ? 'disabled' : '' }}" href="{{ URL::to('admin/user/user/suspend') }}/{{ $user->id}}" title="Activate/Suspend User"><i class="fa fa-circle"></i></a>

            <a type="button" class="btn btn-danger action_confirm  {{ ($permissions['delete']) ? '' : 'disabled' }} view-btn-delete" data-method="delete" href="{{ URL::to('admin/user/user') }}/{{ $user->id }}" title="{{ Lang::get('app.delete') }} user"><i class="fa fa-times-circle-o"></i></a>
        </div>
    </td>
    </tr>
    @endforeach
</table>
{{ $users->links()}}
@stop