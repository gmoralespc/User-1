
<div class="user-user-create">
    <div class='row view-toolbar'>
        {{-- Breadcrumbs --}}
        <div class="col-md-8 col-xs-8 view-breadcrumb" >
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{  Lang::get('app.home') }}</a></li>
                <li><a href="{{ URL::to('admin/user/user') }}">{{ Lang::get('user::user.module.names') }}</a></li>
                <li class="active">{{ Lang::get('app.new') }} {{ Lang::get('user::user.module.name') }}</li>
            </ol>
        </div>

        {{-- Buttons --}}
        <div class="col-md-4 col-xs-4 view-buttons">
            <a class="btn btn-info pull-right" href="{{ URL::to('admin/user/user') }}"><i class="fa fa-angle-left"></i> {{  Lang::get('app.back') }}</a>
        </div>
    </div>

    {{-- Content --}}
    @include('user::partials.notifications')
    <div class='view-content'>
        <fieldset>
            {{Former::legend( Lang::get('app.new')  . ' ' . Lang::get('user::user.module.name'))}}
            {{Former::vertical_open()
            ->id('user/user')
            ->method('POST')
            ->action(URL::to('admin/user/user'))}}
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

            <div class="row">
                <div class="col-md-12">
                    {{Former::actions()
                    ->large_primary_submit('Submit')
                    ->large_default_reset('Reset')}}
                </div>

            </div>

            {{ Former::close() }}
        </fieldset>
    </div>
</div>
