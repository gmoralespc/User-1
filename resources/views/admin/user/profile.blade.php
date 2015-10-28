{!! Former::open_vertical()
-> action ('/admin/user/update-profile')
-> method ('POST')
-> id('form-update-profile')  !!}
{!! csrf_field(); !!}

        {!! Former::text('name')
        -> label(trans('user::user.label.name'))
        -> placeholder(trans('user::user.placeholder.name')) !!}

        {!! Former::tel('mobile')
        -> label(trans('user::user.label.mobile'))
        -> placeholder(trans('user::user.placeholder.mobile')) !!}

        {!! Former::tel('phone')
        -> label(trans('user::user.label.phone'))
        -> placeholder(trans('user::user.placeholder.phone')) !!}

        {!! Former::date('dob')
        -> label(trans('user::user.label.dob'))
        -> placeholder(trans('user::user.placeholder.dob')) !!}

        {!! Former::text('address')
        -> label(trans('user::user.label.address'))
        -> placeholder(trans('user::user.placeholder.address')) !!}

        {!! Former::text('street')
        -> label(trans('user::user.label.street'))
        -> placeholder(trans('user::user.placeholder.street')) !!}

        {!! Former::text('city')
        -> label(trans('user::user.label.city'))
        -> placeholder(trans('user::user.placeholder.city')) !!}

        {!! Former::text('district')
        -> label(trans('user::user.label.district'))
        -> placeholder(trans('user::user.placeholder.district')) !!}

        {!! Former::text('state')
        -> label(trans('user::user.label.state'))
        -> placeholder(trans('user::user.placeholder.state')) !!}

        {!! Former::text('country')
        -> label(trans('user::user.label.country'))
        -> placeholder(trans('user::user.placeholder.country')) !!}

        {!! Former::url('web')
        -> label(trans('user::user.label.web'))
        -> placeholder(trans('user::user.placeholder.web')) !!}

{!! Former::close() !!}