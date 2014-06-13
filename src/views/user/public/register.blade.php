
<div class="row clearfix">
    <div class="col-md-12 column">
        <div class="page-header">
            <h1>
                Register <small>register a new account with us</small>
            </h1>
        </div>
        <div class="row clearfix">
            <div class="col-md-8 column">
                @include('user::partials.notifications')

                {{Former::vertical_open()
                ->id('register')
                ->method('POST')
                ->action(URL::to('/register'))}}

                <div class="row">

                    <div class="col-md-6">
                        {{ Former::text('first_name')
                        -> label('user::user.label.first_name')
                        -> placeholder('user::user.placeholder.first_name')}}
                    </div>

                    <div class="col-md-6">
                        {{ Former::text('last_name')
                        -> label('user::user.label.last_name')
                        -> placeholder('user::user.placeholder.last_name')}}
                    </div>

                    <div class="col-md-12">
                        {{ Former::email('email')
                        -> label('user::user.label.email')
                        -> placeholder('user::user.placeholder.email')}}
                    </div>

                    <div class="col-md-6">
                        {{ Former::password('password')
                        -> label('user::user.label.password')
                        -> placeholder('user::user.placeholder.password')}}
                    </div>

                    <div class="col-md-6">
                        {{ Former::password('password_confirmation')
                        -> label('user::user.label.password_confirmation')
                        -> placeholder('user::user.placeholder.password_confirmation')}}
                    </div>
                    <div class="col-md-12">
                        {{ Form::captcha(array('theme' => 'white')) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {{Former::actions()
                        ->large_primary_submit('register')}}
                    </div>

                </div>

                {{ Former::close() }}<br/><br/>
            </div>
            <div class="col-md-4 column">

                <button type="button" class="btn btn-primary btn-lg btn-block"><i class="fa fa-facebook"> Facebook</i></button>
                <button type="button" class="btn btn-primary btn-lg btn-block"><i class="fa fa-twitter"> Twitter</i></button>
                <button type="button" class="btn btn-primary btn-lg btn-block"><i class="fa fa-google-plus"> Google Plus</i></button>
                <button type="button" class="btn btn-primary btn-lg btn-block"><i class="fa fa-linkedin"> Linkedin</i></button>


            </div>
        </div>
        <div class="row">
            <div class="col-md-12 column">
                <h2> Already registered?</h2>                    <p>If you have already registered with us. <a href="{{URL::to('login')}}"> Click here </a> to login</p>
            </div>
        </div>
    </div>
</div>
