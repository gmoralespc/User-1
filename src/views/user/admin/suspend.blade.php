
<div class="row">
    <div class="col-md-8">
            {{Former::vertical_open()
            ->id('user')
            ->secure()
            ->method('POST')
            ->action(URL::to('/admin/user/user/suspend/'.$id))}}
            {{Former::hidden('id')}}


            <h2>{{trans('user::user.suspend')}} {{trans('user::user.user')}}</h2>
                        {{ Former::text('minutes')
                        -> label('user::user.label.minutes')
                        -> placeholder('user::user.placeholder.minutes')}}

            {{ Form::hidden('id', $id) }}

            {{ Form::submit(trans('user::user.suspend').'!', array('class' => 'btn btn-primary')) }}

        {{ Former::close() }}
    </div>
</div>
