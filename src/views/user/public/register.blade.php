

            <div id="shop">

                <!-- PAGE TITLE -->
                <header id="page-title">
                    <div class="container">
                        <h1>Sign UP</h1>

                        <ul class="breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">Sign UP</li>
                        </ul>
                    </div>
                </header>


                <section class="container">

                    <div class="row">

                        <!-- REGISTER -->
                        <div class="col-md-6">

                            <h2>Create <strong>Account</strong></h2>

                           

                @include('user::partials.notifications')

                {{Former::vertical_open()
                ->id('register')
                ->class('white-row')
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
                        -> addClass('pull-right')
                        ->large_primary_submit('Sign Up')}}
                    </div>

                </div>

                {{ Former::close() }}<br/><br/>

                           

                        </div>
                        <!-- /REGISTER -->

                        <!-- WHY? -->
                        <div class="col-md-6">

                            <h2>Why to register?</h2>

                            <div class="white-row">

                                <h4>Registration is fast, easy, and free.</h4>

                                <p>Once you're registered, you can:</p>
                                <ul class="list-icon check">
                                    <li>Buy, sell, and interact with other members.</li>
                                    <li>Save your favorite searches and get notified.</li>
                                    <li>Watch the status of up to 200 items.</li>
                                    <li>View your Atropos information from any computer in the world.</li>
                                    <li>Connect with the Atropos community.</li>
                                </ul>

                                <hr class="half-margins" />

                                <p>
                                    Already have an account?
                                    <a href="{{ URL::to('/login') }}">Click to Sign In</a>
                                </p>
                            </div>

                            <div class="white-row">
                                <h4>Contact Customer Support</h4>
                                <p>
                                    If you're looking for more help or have a question to ask, please <a href="{{ URL::to('contact.htm') }}">contact us</a>.
                                </p>
                            </div>

                        </div>
                        <!-- /WHY? -->

                    </div>

                </section>

            </div>

