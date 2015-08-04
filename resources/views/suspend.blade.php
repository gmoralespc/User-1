
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('action' => array('Lavalite\User\PublicController@suspend', $id), 'method' => 'post')) }}

            <h2>{{trans('user::pages.actionsuspend')}} {{trans('user::pages.user')}}</h2>

            <div class="form-group {{ ($errors->has('minutes')) ? 'has-error' : '' }}">
                {{ Form::text('minutes', null, array('class' => 'form-control', 'placeholder' => trans('user::pages.minutes'), 'autofocus')) }}
                {{ ($errors->has('minutes') ? $errors->first('minutes') : '') }}
            </div>

            {{ Form::hidden('id', $id) }}

            {{ Form::submit(trans('user::pages.actionsuspend').'!', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}
    </div>
</div>
