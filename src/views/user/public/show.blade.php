
    <h4>{{trans('user::pages.profile')}}</h4>

    <div class="well clearfix">
        <div class="col-md-8">
            @if ($user->first_name)
                <p><strong>{{trans('user::user.fname')}}:</strong> {{ $user->first_name }} </p>
            @endif
            @if ($user->last_name)
                <p><strong>{{trans('user::user.lname')}}:</strong> {{ $user->last_name }} </p>
            @endif
            <p><strong>{{trans('user::user.email')}}</strong> {{ $user->email }}</p>

        </div>
        <div class="col-md-4">
            <p><em>{{trans('user::pages.profile')}} {{trans('user::pages.created')}}: {{ $user->created_at }}</em></p>
            <p><em>{{trans('user::pages.modified')}}: {{ $user->updated_at }}</em></p>
            <button class="btn btn-primary" onClick="location.href='{{ action('UserController@edit', array($user->id)) }}'">{{trans('user::pages.actionedit')}}</button>
        </div>
    </div>

    <h4>{{trans('user::user.group_membership')}}:</h4>
    <?php $userGroups = $user->getGroups(); ?>
    <div class="well">
        <ul>
            @if (count($userGroups) >= 1)
                @foreach ($userGroups as $group)
                    <li>{{ $group['name'] }}</li>
                @endforeach
            @else
                <li>{{trans('user::group.notfound')}}</li>
            @endif
        </ul>
    </div>

    <hr />

    <h4>User Object</h4>
    <div>
        <p>{{ var_dump($user) }}</p>
    </div>
