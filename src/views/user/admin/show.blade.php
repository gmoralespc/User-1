<div class="user-show">
    <div class='row view-toolbar'>
        {{-- Breadcrumbs --}}
        <div class="col-md-8 col-xs-7 view-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('app.home') }}</a></li>
                <li><a href="{{ URL::to('admin/user') }}">{{ Lang::get('user::user.module.names') }}</a></li>
                <li class="active">{{ $user['name'] }}</li>
            </ol>
        </div>

        {{-- Buttons --}}
        <div class="col-md-4 col-xs-5 view-buttons" align="right">
            <a class="btn btn-info view-btn-back" href="{{ URL::to('admin/user') }}" ><i class="fa fa-angle-left"></i> {{ Lang::get('app.back') }}</a>
            <a class="btn btn-info view-btn-edit {{ ($permissions['edit']) ? '' : 'disabled' }}" href="{{ URL::to('admin/user') . '/' . $user['id'] . '/edit'}}">
                <i class="fa fa-pencil-square-o"></i> {{ Lang::get('app.edit') }}
            </a>
        </div>
    </div>

    {{-- Content --}}
    <div class='view-content'>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('user::user.module.name') }} [{{ $user['email'] }}]</h3>
            </div>
            <div class="panel-body">
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
            </div>
        </div>
    </div>
</div>
