@extends('Admin::views.edit')

@section('heading')
<h1>
    {{ Lang::get('user::group.name') }}
    <small> {{ Lang::get('app.manage') }} {{ Lang::get('user::group.names') }}</small>
</h1>
@stop

@section('title')
{{Lang::get('app.edit')}} {{Lang::get('user::group.name')}} {{$group['name']}}
@stop

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i> {{  Lang::get('app.home') }}</a></li>
    <li><a href="{{ URL::to('admin/user/group')}}">{{ Lang::get('user::group.names') }}</a></li>
    <li class="active">{{ $group['name'] }}</li>
</ol>

@stop

@section('buttons')
<a class="btn btn-info pull-right view-btn-back" href="{{ URL::to('admin/user/group') }}"><i class="fa fa-angle-left"></i> {{  Lang::get('app.back') }}</a>
@stop
@section('tabs')
<li class="active"><a href="#details" data-toggle="tab">Group</a></li>
@stop
@section('icon')
<i class="fa fa-th"></i>
@stop
@section('content')
{{Former::vertical_open()
    ->id('group')
    ->secure()
    ->method('PUT')
    ->action(URL::to('admin/user/group/'. $group['id']))}}
    <div class="tab-content">
        <div class="tab-pane active" id="details">
            <div class="row">
                <div class="col-md-12 ">
                     {{ Form::label(trans('user::group.label.name')) }}
                    <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
                        {{ Form::text('name', $group->name, array('class' => 'form-control', 'placeholder' => trans('user::group.name'))) }}
                        {{ ($errors->has('name') ? $errors->first('name') : '') }}
                    </div>
                </div>

                <div class="col-md-12 ">
                <fieldset>
                    <legend>{{ trans('user::group.label.permissions') }}</legend>
                    @foreach($rights['default'] as $permission)
                        <label class="checkbox-inline">
                            {{ Form::hidden("permissions[$permission]" , 0)}}
                            {{ Form::checkbox("permissions[$permission]", 1, array_key_exists($permission, $permissions)) }} {{$permission}}
                        </label>
                    @endforeach
                </fieldset>


                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ">
                <div class="row ">
                    @foreach($rights as $package => $p)
                        @if (is_array($p) AND  $package != 'default')
                            <div class="col-md-6">
                            <br />
                            <fieldset>
                                <legend>{{ ucfirst($package) }}</legend>
                                @foreach($p as $module => $m)
                                @if (is_array($m))
                                @foreach($m as $type => $t)
                                @if (is_array($t))
                                <div class="row" >
                                    <div class="col-lg-2 col-md-3" > {{ucfirst($module)}} &raquo; {{ucfirst($type)}} </div>
                                    <div class='col-lg-10 col-md-9' >
                                        @foreach($t as $permission => $te)
                                            <label class="checkbox-inline">
                                            {{-- */$key    = $package.'.'.$module.'.'.$type.'.'.$te/* --}}
                                            {{ Form::hidden('permissions['.$key.']' , 0)}}
                                            {{ Form::checkbox('permissions['.$key.']', 1,
                                                                array_key_exists($key, $permissions),
                                                                array('unchecked_value' => '0')) }}
                                                                {{ucfirst($te)}}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </fieldset>

                            @endif
                            @endforeach
                            @endif
                            @endforeach
                            </div>
                        @endif
                    @endforeach


                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-footer">
        <div class="row">
            <div class="col-md-12">
                {{Former::actions()
                ->large_primary_submit(Lang::get('app.save'))
                ->large_default_reset(Lang::get('app.reset'))}}
            </div>
        </div>
    </div>
    {{Former::close()}}
    @stop