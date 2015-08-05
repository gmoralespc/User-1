
<section class="container">
    <div class="row">
        <div class="col-md-8">
            <h2></h2>
            <h2>Change Password</h2>
            {{Former::vertical_open()
            ->id('change')
            ->method('POST')
            ->class('white-row')
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
        <div class="col-md-4">

            <h2></h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pellentesque neque eget diam porta.</p>
            <p>
                @include("user::partials.menu")
            </p>
            

        </div>
    </div>
</section>        