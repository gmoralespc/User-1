<div class="page-header">
    <h1>
    Change Password <small>Change your password!</small>
    </h1>
</div>
<div class="row">
    <div class="col-md-4">
        @include("user::partials.menu")
    </div>
    <div class="col-md-8">
        {{Former::vertical_open()
        ->id('change')
        ->method('POST')
        ->action(URL::to('/user/change'))}}
        <div class="form-group {{ ($errors->has('oldPassword')) ? 'has-error' : '' }}">
            {{ Former::password('oldPassword')
            -> label('')
            -> placeholder(trans('user::user.oldPassword')) }}
        </div>
        <div class="form-group {{ ($errors->has('newPassword')) ? 'has-error' : '' }}">
            {{ Former::password('newPassword')
            -> label('')
            -> placeholder(trans('user::user.newPassword')) }}
        </div>
        <div class="form-group {{ ($errors->has('newPassword_confirmation')) ? 'has-error' : '' }}">
            {{ Former::password('newPassword_confirmation')
            -> label('')
            -> placeholder(trans('user::user.Password_confirmation')) }}

            {{Former::actions()
            ->large_primary_submit('Change Password')}}

            {{ Former::close() }}
        </div>
    </div>
</div>
