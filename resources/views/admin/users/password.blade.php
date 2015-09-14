{!! Former::open_vertical()
-> action ('admin/user/change-password')
-> method ('POST')
->id('form-change-password') !!}
{!! csrf_field(); !!}
{!! Former::password('password')->minlength(6)->required() !!}
{!! Former::password('password_confirmation')->setAttribute('equalTo', '#password')->required() !!}
{!! Former::close() !!}