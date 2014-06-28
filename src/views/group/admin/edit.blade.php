
<div class="row">
    <div class="col-md-12">
        {{Former::vertical_open()
        ->id('group')
        ->secure()
        ->method('PUT')
        ->action(URL::to('admin/user/group/'. $group['id']))}}
        <h2>{{trans('app.edit')}} {{trans('user::group.name')}}</h2>

        <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
            {{ Form::text('name', $group->name, array('class' => 'form-control', 'placeholder' => trans('user::group.name'))) }}
            {{ ($errors->has('name') ? $errors->first('name') : '') }}
        </div>

        {{ Form::label(trans('user::group.permissions')) }}


        <div class="form-group">
            @foreach($rights['default'] as $permission)
            <label class="checkbox-inline">
                {{ Form::checkbox("permissions[$permission]", 1, array_key_exists($permission, $permissions)) }} {{$permission}}
            </label>

            @endforeach
        </div>

        <div class='row'>

            @foreach($rights as $package => $p)
            @if (is_array($p) AND  $package != 'default')
            <div class="col-md-6">
                <h2>{{ucfirst($package)}}</h2>
                @foreach($p as $module => $m)
                @if (is_array($m))
                @foreach($m as $type => $t)
                @if (is_array($t))
                <div class="row">
                    <div class="col-md-3"> {{ucfirst($module)}} &raquo; {{ucfirst($type)}} </div>
                    <div class='col-md-9'>
                    @foreach($t as $permission => $te)
                    <label class="checkbox-inline"> {{ Form::checkbox('permissions['.$package.'.'.$module.'.'.$type.'.'.$te.']', 1, array_key_exists($package.'.'.$module.'.'.$type.'.'.$te, $permissions)) }} {{ucfirst($te)}}</label>
                    @endforeach
                    </div>
                </div>
                @endif
                @endforeach
                @endif
                @endforeach
            </div>
            @endif
            @endforeach

        </div>
        {{ Form::hidden('id', $group->id) }}
        {{ Form::submit(trans('app.update').' '.trans('user::group.name'), array('class' => 'btn btn-primary')) }}

 {{ Former::close() }}
</div>
</div>