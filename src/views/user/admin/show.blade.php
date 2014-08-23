@extends('Admin::views.show')

@section('heading')
<h1>
    {{ Lang::get('user::package.name') }}
    <small> {{ Lang::get('app.manage') }} {{ Lang::get('user::package.names') }}</small>
</h1>
@stop

@section('title')
{{$user['name']}} {{Lang::get('user::user.module.name')}}
@stop
@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ URL::to('admin') }}">{{ Lang::get('app.home') }}</a></li>
    <li><a href="{{ URL::to('admin/user/user') }}">{{ Lang::get('user::user.module.names') }}</a></li>
    <li class="active">{{ $user['name'] }}</li>
</ol>

@stop
@section('buttons')
<a class="btn btn-info  btn-xs" href="{{ URL::to('admin/user/user') }}" ><i class="fa fa-angle-left"></i> {{ Lang::get('app.back') }}</a>
<a class="btn btn-info  btn-xs {{ ($permissions['edit']) ? '' : 'disabled' }}" href="{{ URL::to('admin/user/user') . '/' . $user['id'] . '/edit'}}">
    <i class="fa fa-pencil-square-o"></i> {{ Lang::get('app.edit') }}
</a>
@stop

@section('content')

<div class="row">

    <div class="col-md-6 ">
        <div class="form-group">
            <label for="name">{{ Lang::get('user::user.label.name') }}</label><br />

            {{ $user['first_name'] }} {{ $user['last_name'] }}
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label for="sex">{{ Lang::get('user::user.label.sex') }}</label><br />

            {{ $user['sex'] }}
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label for="date_of_birth">{{ Lang::get('user::user.label.date_of_birth') }}</label><br />

            {{ $user['date_of_birth'] }}
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label for="photo">{{ Lang::get('user::user.label.photo') }}</label><br />

            {{ $user['photo'] }}
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label for="address">{{ Lang::get('user::user.label.address') }}</label><br />

            {{ $user['address'] }}
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label for="street">{{ Lang::get('user::user.label.street') }}</label><br />

            {{ $user['street'] }}
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label for="city">{{ Lang::get('user::user.label.city') }}</label><br />

            {{ $user['city'] }}
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label for="district">{{ Lang::get('user::user.label.district') }}</label><br />

            {{ $user['district'] }}
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label for="state">{{ Lang::get('user::user.label.state') }}</label><br />

            {{ $user['state'] }}
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label for="country">{{ Lang::get('user::user.label.country') }}</label><br />

            {{ $user['country'] }}
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label for="mobile">{{ Lang::get('user::user.label.mobile') }}</label><br />

            {{ $user['mobile'] }}
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label for="phone">{{ Lang::get('user::user.label.phone') }}</label><br />

            {{ $user['phone'] }}
        </div>
    </div>


    <div class="col-md-6 ">
        <div class="form-group">
            <label for="web">{{ Lang::get('user::user.label.web') }}</label><br />

            {{ $user['web'] }}
        </div>
    </div>
</div>

@stop