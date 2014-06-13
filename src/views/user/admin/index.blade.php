<div class="users-index">
    <div class='row view-toolbar'>
        {{-- Breadcrumbs --}}
        <div class="col-md-4 col-xs-12 view-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}"> {{ Lang::get('app.home') }} </a></li>
                <li class="active">{{ Lang::get('user::user.module.names') }}</li>
            </ol>
        </div>
        <div class="col-md-6 col-xs-8 view-search">
            <form class="form-horizontal" action="{{ URL::to('admin/user/user') }}" method="get">
                {{ Form::token() }}
                <div class="input-group">
                    <input type="search" class="form-control" name="q" value="{{$q}}"  placeholder="{{  Lang::get('app.search') }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
        </div>

        {{-- Buttons --}}
        <div class="col-md-2 col-xs-4 view-buttons">
            <a class="btn btn-info pull-right {{ ($permissions['create']) ? '' : 'disabled' }} view-btn-create" href="{{ URL::to('admin/user/user/create') }}">
                <i class="fa fa-plus-circle"></i> {{ Lang::get('app.new') }} {{ Lang::get('user::user.module.name') }}
            </a>
        </div>
    </div>

    {{-- Content --}}
    <!-- Success-Messages -->
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block view-message">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Success</h4>
        {{{ $message }}}
    </div>
    @endif
    <div class='view-content'>
        <table class="table">
            <thead>
               <th>{{ Lang::get('user::user.label.name')}}</th>
               <th>{{ Lang::get('user::user.label.email') }}</th>
               <th>{{ Lang::get('user::user.label.status') }}</th>
               <th width="140">{{ Lang::get('app.options') }}</th>
           </thead>
           <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                <td><a href="{{ ($permissions['view']) ? (URL::to('admin/user/user') . '/' . $user->id ) : '#' }}">{{ $user->email }}</a></td>
                <td>{{ $userStatus[$user->id] }}</td>
                <td>
                    <div class="btn-group  btn-group-xs">
                        <a type="button" class="btn btn-info  {{ ($permissions['edit']) ? '' : 'disabled' }} view-btn-edit" href="{{ URL::to('admin/user/user')}}/{{$user->id}}/edit" title="{{ Lang::get('app.update') }} user"><i class="fa fa-pencil-square-o"></i></a>

                        <a type="button" class="btn btn-warning {{ ($user->id == 1) ? 'disabled' : '' }}" href="{{ URL::to('admin/user/user/suspend') }}/{{ $user->id}}" title="Activate/Suspend User"><i class="fa fa-circle"></i></a>

                        <a type="button" class="btn btn-danger action_confirm  {{ ($permissions['delete']) ? '' : 'disabled' }} view-btn-delete" data-method="delete" href="{{ URL::to('admin/user/user') }}/{{ $user->id }}" title="{{ Lang::get('app.delete') }} user"><i class="fa fa-times-circle-o"></i></a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links()}}
</div>
</div>
