<div class="tab-pane active" id="details">
    <div class="row">
        <div class='col-md-3 col-sm-4'>{!! Former::select('parent')
            -> options(trans('user::user.options.parent'))
            -> label(trans('user::user.label.parent'))
            -> placeholder(trans('user::user.placeholder.parent'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::text('email')
            -> label(trans('user::user.label.email'))
            -> placeholder(trans('user::user.placeholder.email'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::password('password')
            -> label(trans('user::user.label.password'))
            -> placeholder(trans('user::user.placeholder.password'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::text('activated')
            -> label(trans('user::user.label.activated'))
            -> placeholder(trans('user::user.placeholder.activated'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::text('first_name')
            -> label(trans('user::user.label.first_name'))
            -> placeholder(trans('user::user.placeholder.first_name'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::text('last_name')
            -> label(trans('user::user.label.last_name'))
            -> placeholder(trans('user::user.placeholder.last_name'))!!}
        </div>
        <div class='col-md-4 col-sm-6'>{!! Former::inline_radios('sex')
            -> radios(trans('user::user.options.sex'))
            -> label(trans('user::user.label.sex'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::datetime('dob')
            -> label(trans('user::user.label.dob'))
            -> placeholder(trans('user::user.placeholder.dob'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::select('department')
            -> options(trans('user::user.options.department'))
            -> label(trans('user::user.label.department'))
            -> placeholder(trans('user::user.placeholder.department'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::text('designation')
            -> label(trans('user::user.label.designation'))
            -> placeholder(trans('user::user.placeholder.designation'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::tel('mobile')
            -> label(trans('user::user.label.mobile'))
            -> placeholder(trans('user::user.placeholder.mobile'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::tel('phone')
            -> label(trans('user::user.label.phone'))
            -> placeholder(trans('user::user.placeholder.phone'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::text('address')
            -> label(trans('user::user.label.address'))
            -> placeholder(trans('user::user.placeholder.address'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::text('street')
            -> label(trans('user::user.label.street'))
            -> placeholder(trans('user::user.placeholder.street'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::text('city')
            -> label(trans('user::user.label.city'))
            -> placeholder(trans('user::user.placeholder.city'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::text('district')
            -> label(trans('user::user.label.district'))
            -> placeholder(trans('user::user.placeholder.district'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::text('state')
            -> label(trans('user::user.label.state'))
            -> placeholder(trans('user::user.placeholder.state'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::text('country')
            -> label(trans('user::user.label.country'))
            -> placeholder(trans('user::user.placeholder.country'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::text('photo')
            -> label(trans('user::user.label.photo'))
            -> placeholder(trans('user::user.placeholder.photo'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::url('web')
            -> label(trans('user::user.label.web'))
            -> placeholder(trans('user::user.placeholder.web'))!!}
        </div>
        <div class='col-md-3 col-sm-4'>{!! Former::select('type')
            -> options(trans('user::user.options.type'))
            -> label(trans('user::user.label.type'))
            -> placeholder(trans('user::user.placeholder.type'))!!}
        </div>
    </div>
</div>
<div class="tab-pane " id="groups">
    <div class="row">
        <div class='col-md-3 col-sm-4'>
            <table class="table">
                <thead>
                    <th>Group</th>
                    <th>Membership Status</th>
                </thead>
                <tbody>
                    @foreach ($allGroups as $group)
                    <tr>
                        <td>{{ $group->name }}</td>
                        <td>
                            <input name="groups[{{ $group->id }}]" type="checkbox" {{ ( $user->
                        inGroup($group)) ? 'checked' : '' }} > </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class='col-md-3 col-sm-4'>
            <table class="table">
                <thead>
                    <th>Modules</th>
                    <th>Permissions</th>
                </thead>
                <tbody>
                    @foreach(config('cms.packages') as $package)
                    <tr>
                        <td>{{ucfirst($package)}}</td>
                        <td>
                            @forelse(config($package.'.permissions') as $key => $permission)
                                {!!Former::hidden('permissions['.$key.']')->forceValue(0)->raw()!!}
                                {!!Former::checkbox('permissions['.$key.']')->inline()->value(1)->raw()!!} {{$permission}}
                            @empty
                                No permissions assigned
                            @endforelse
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
<div class="tab-pane " id="settings">
    <div class="row">
        <div class='col-md-3 col-sm-4'>{!! Former::password('password')
            -> label(trans('user::user.label.password'))
            -> placeholder(trans('user::user.placeholder.password'))!!}
        </div>
    </div>
</div>