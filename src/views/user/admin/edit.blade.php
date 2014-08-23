@extends('Admin::views.edit')

@section('heading')
<h1>
    {{ Lang::get('user::package.name') }}
    <small> {{ Lang::get('app.manage') }} {{ Lang::get('user::package.names') }}</small>
</h1>
@stop

@section('title')
{{Lang::get('app.edit')}} {{Lang::get('user::user.module.name')}} {{$user['name']}}
@stop

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i> {{  Lang::get('app.home') }}</a></li>
    <li><a href="{{ URL::to('admin/user/user')}}">{{ Lang::get('user::user.module.names') }}</a></li>
    <li class="active">{{ $user['email'] }}</li>
</ol>
@stop

@section('buttons')
<a class="btn btn-info pull-right view-btn-back" href="{{ URL::to('admin/user/user') }}"><i class="fa fa-angle-left"></i> {{  Lang::get('app.back') }}</a>
@stop

@section('tabs')
<li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
<li><a href="#groups" data-toggle="tab">Permissions</a></li>
<li><a href="#password" data-toggle="tab">Password</a></li>
<li><a href="#settings" data-toggle="tab">Settings</a></li>
@stop

@section('icon')
<i class="fa fa-th"></i>
@stop

@section('content')
{{Former::vertical_open()
    ->id('user')
    ->secure()
    ->method('PUT')
    ->action(URL::to('admin/user/user/'. $user['id']))}}
    {{Former::hidden('id')}}
    <div class="tab-content">

        <div class="tab-pane active" id="profile">

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

                <div class="col-md-6 ">
                    {{ Former::select('sex')
                    -> options(Lang::get('user::user.options.sex'))
                    -> label('user::user.label.sex')
                    -> placeholder('user::user.placeholder.sex')}}
                </div>

                <div class="col-md-6 ">
                    {{ Former::date('date_of_birth')
                    -> label('user::user.label.date_of_birth')
                    -> placeholder('user::user.placeholder.date_of_birth')}}
                </div>

                <div class="col-md-6 ">
                    {{ Former::file('photo')
                    -> label('user::user.label.photo')
                    -> placeholder('user::user.placeholder.photo')
                    -> addClass('image-up') }}
                </div>

                <div class="col-md-6 ">
                    {{ Former::text('designation')
                    -> label('user::user.label.designation')
                    -> placeholder('user::user.placeholder.designation')}}
                </div>

                <div class="col-md-6 ">
                    {{ Former::textarea ('address')
                    -> label('user::user.label.address')
                    -> placeholder('user::user.placeholder.address')}}
                </div>

                <div class="col-md-6 ">
                    {{ Former::text('street')
                    -> label('user::user.label.street')
                    -> placeholder('user::user.placeholder.street')}}
                </div>

                <div class="col-md-6 ">
                    {{ Former::text('city')
                    -> label('user::user.label.city')
                    -> placeholder('user::user.placeholder.city')}}
                </div>

                <div class="col-md-6 ">
                    {{ Former::text('district')
                    -> label('user::user.label.district')
                    -> placeholder('user::user.placeholder.district')}}
                </div>

                <div class="col-md-6 ">
                    {{ Former::text('state')
                    -> label('user::user.label.state')
                    -> placeholder('user::user.placeholder.state')}}
                </div>

                <div class="col-md-6 ">
                    {{ Former::text('country')
                    -> label('user::user.label.country')
                    -> placeholder('user::user.placeholder.country')}}
                </div>

                <div class="col-md-6 ">
                    {{ Former::tel('mobile')
                    -> label('user::user.label.mobile')
                    -> placeholder('user::user.placeholder.mobile')}}
                </div>

                <div class="col-md-6 ">
                    {{ Former::tel('phone')
                    -> label('user::user.label.phone')
                    -> placeholder('user::user.placeholder.phone')}}
                </div>

                <div class="col-md-6 ">
                    {{ Former::url('web')
                    -> label('user::user.label.web')
                    -> placeholder('user::user.placeholder.web')}}
                </div>
            </div>
        </div>
        <div class="tab-pane" id="groups">
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <th>Group</th>
                            <th>Membership Status</th>
                        </thead>
                        <tbody>
                            @foreach ($allGroups as $group)
                            <tr>
                                <td>{{ $group->name }}</td>
                                <td>
                                    <input name="groups[{{ $group->id }}]" type="checkbox" {{ ( $user->
                                    inGroup($group)) ? 'checked' : '' }} > </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="password"><div class="row">
                <div class="col-md-12">
                    {{-- Former::password('password')
                    -> label('user::user.label.password')
                    -> value('')
                    -> placeholder('user::user.placeholder.password')--}}
                </div>
            </div></div>
            <div class="tab-pane" id="settings">
                Coming soon...
            </div>
        </div>
        <div class="tab-footer">
            <div class="row">
                <div class="col-md-12">
                    {{Former::actions()
                    ->large_primary_submit('Submit')
                    ->large_default_reset('Reset')}}
                </div>
            </div>
        </div>
        {{Former::close()}}
        @stop

        @section('script')

        @stop

