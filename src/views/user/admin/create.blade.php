@extends('Admin::views.create')

@section('heading')
<h1>
    {{ Lang::get('user::package.name') }}
    <small> {{ Lang::get('app.manage') }} {{ Lang::get('user::package.names') }}</small>
</h1>
@stop

@section('title')
{{Lang::get('app.new')}} {{Lang::get('user::user.module.name')}}
@stop

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i> {{  Lang::get('app.home') }}</a></li>
    <li><a href="{{ URL::to('admin/user/user') }}">{{ Lang::get('user::user.module.names') }}</a></li>
    <li class="active">{{ Lang::get('app.new') }} {{ Lang::get('user::user.module.name') }}</li>
</ol>
@stop
@section('buttons')
<a class="btn btn-info pull-right" href="{{ URL::to('admin/user/user') }}"><i class="fa fa-angle-left"></i> {{  Lang::get('app.back') }}</a>
@stop
@section('content')

{{Former::vertical_open()
    ->id('user/user')
    ->method('POST')
    ->action(URL::to('admin/user/user'))}}
    <div class="box-body">

         <div class="row">

                <div class="col-md-6 ">
                    {{ Former::email('email')
                    -> label('user::user.label.email')
                    -> placeholder('user::user.placeholder.email')}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 ">
                    {{ Former::text('first_name')
                    -> label('user::user.label.first_name')
                    -> placeholder('user::user.placeholder.first_name')}}
                </div>
                <div class="col-md-6 ">
                    {{ Former::text('last_name')
                    -> label('user::user.label.last_name')
                    -> placeholder('user::user.placeholder.last_name')}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 ">
                    {{ Former::password('password')
                    -> label('user::user.label.password')
                    -> placeholder('user::user.placeholder.password')}}
                </div>
                <div class="col-md-6 ">
                    {{ Former::password('password_confirmation')
                    -> label('user::user.label.password_confirmation')
                    -> placeholder('user::user.placeholder.password_confirmation')}}
                </div>
            </div>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-md-12">
                   {{Former::actions()
                    ->large_primary_submit('Submit')
                    ->large_default_reset('Reset')}}
            </div>

        </div>
    </div>

    {{ Former::close() }}
    @stop

    @section('script')


    @stop

