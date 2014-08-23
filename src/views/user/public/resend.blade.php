
<section class="container">
  <h2></h2>
    <div class="white-row">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                {{ Form::open(array('action' => 'Lavalite\User\Controllers\PublicController@resend', 'method' => 'post')) }}

                <h2>{{ trans('user::user.resend') }}</h2>

                <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                    {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => trans('user::user.email'), 'autofocus')) }}
                    {{ ($errors->has('email') ? $errors->first('email') : '') }}
                </div>

                {{ Form::submit(trans('user::user.resend'), array('class' => 'btn btn-primary')) }}

                {{ Form::close() }}
            </div>
        </div>
    </div>
</section>