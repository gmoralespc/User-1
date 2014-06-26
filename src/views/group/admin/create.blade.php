

<div class='row view-toolbar'>
    {{-- Breadcrumbs --}}
    <div class="col-md-6 col-xs-12 view-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin') }}"> {{ Lang::get('app.home') }} </a></li>
            <li class="active">{{ Lang::get('user::group.names') }}</li>
        </ol>
    </div>


        {{-- Buttons --}}
        <div class="col-md-6 col-xs-4 view-buttons">
            <a class="btn btn-info pull-right" href="{{ URL::to('admin/user/user') }}"><i class="fa fa-angle-left"></i> {{  Lang::get('app.back') }}</a>
        </div>
</div>

<div class="row">
    <div class="col-md-12">
            {{Former::vertical_open()
            ->id('group')
            ->secure()
            ->method('POST')
            ->action(URL::to('admin/user/group'))}}
        <h2>{{trans('user::group.create')}}</h2>
        {{ Former::text('name')
        -> label('user::user.label.name')
        -> placeholder('user::user.placeholder.name')}}


        {{ Form::label(trans('user::group.permissions')) }}
        <div class="form-group">
            @foreach($rights['default'] as $permission)
            <label class="checkbox-inline">
                {{ Form::checkbox("permissions[$permission]", 1 ) }} {{$permission}}
            </label>

            @endforeach
        </div>

        {{ Form::submit(trans('user::group.create'), array('class' => 'btn btn-primary')) }}

        {{ Former::close() }}
    </div>
</div>