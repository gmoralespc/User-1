
<div class="row">
    <div class="col-md-8">
        {{ Form::open(array('action' => 'Lavalite\User\Controllers\PublicController@forgot', 'method' => 'post')) }}

            <h2>{{trans('user::user.forgotupword')}}</h2>

            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => trans('user::user.email'), 'autofocus')) }}
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

            {{ Form::submit(trans('user::user.resendpword'), array('class' => 'btn btn-primary'))}}
            <a class="btn btn-link" href="{{ URL::to('/login') }}">{{trans('user::user.backlogin')}}</a>

        {{ Form::close() }}
    </div>
</div>
