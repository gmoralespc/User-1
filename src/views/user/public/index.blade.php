
<h4>{{trans('user::pages.currentusers')}}:</h4>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <th>{{trans('user::pages.user')}}</th>
                <th>{{trans('user::pages.status')}}</th>
                <th>{{trans('user::pages.options')}}</th>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><a href="{{ action('Lavalite\User\Controllers\PublicController@show', array($user->id)) }}">{{ $user->email }}</a></td>
                        <td>@if ($user->status=='Active') {{trans('user::pages.active')}}
                         @else {{trans('user::pages.notactive')}}
                         @endif
                         </td>

                        <td>
                            <button class="btn btn-default" type="button" onClick="location.href='{{ action('Lavalite\User\Controllers\PublicController@edit', array($user->id)) }}'">{{trans('user::pages.actionedit')}}</button>
                            @if ($user->status != 'Suspended')
                                <button class="btn btn-default" type="button" onClick="location.href='{{ route('suspendUserForm', array($user->id)) }}'">{{trans('user::pages.actionsuspend')}}</button>
                            @else
                                <button class="btn btn-default" type="button" onClick="location.href='{{ action('Lavalite\User\Controllers\PublicController@unsuspend', array($user->id)) }}'">{{trans('user::pages.actionunsuspend')}}</button>
                            @endif
                            @if ($user->status != 'Banned')
                                <button class="btn btn-default" type="button" onClick="location.href='{{ action('Lavalite\User\Controllers\PublicController@ban', array($user->id)) }}'">{{trans('user::pages.actionban')}}</button>
                            @else
                                <button class="btn btn-default" type="button" onClick="location.href='{{ action('Lavalite\User\Controllers\PublicController@unban', array($user->id)) }}'">{{trans('user::pages.actionunban')}}</button>
                            @endif

                            <button class="btn btn-default action_confirm" href="{{ action('Lavalite\User\Controllers\PublicController@destroy', array($user->id)) }}" data-token="{{ Session::getToken() }}" data-method="delete">{{trans('user::pages.actiondelete')}}</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
</div>
