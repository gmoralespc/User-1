<div class="page-header">
	<h1>
		Profile <small>Your Profile!</small>
	</h1>
</div>
<div class="row">
	<div class="col-md-4">
		@include("user::partials.menu")
	</div>

	{{Former::vertical_open()
	->id('profile')
	->secure()
	->method('POST')
	->action(URL::to('user/profile'))}}
	{{Former::hidden('id')}}

	<div class="col-md-8">

		<div class="row">
			<div class="col-md-12">
				@if ($message = Session::get('success'))
				<div class="alert alert-success alert-block view-message">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<h4>Success</h4>
					{{{ $message }}}
				</div>
				@endif
				{{ Former::text('first_name')
				-> label(trans('user::user.label.first_name'))
				-> value($user->first_name)
				-> placeholder(trans('user::user.placeholder.first_name'))		}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ Former::text('last_name')
				-> label(trans('user::user.label.last_name'))
				-> value($user->last_name)
				-> placeholder(trans('user::user.placeholder.last_name'))	}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ Former::select('sex')
				-> options(trans('user::user.options.sex'))
				-> value($user->sex)
				-> placeholder(trans('user::user.placeholder.sex'))}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ Former::text('date_of_birth')
				-> label(trans('user::user.label.date_of_birth'))
				-> value($user->date_of_birth)
				-> addClass('date-picker')
				-> placeholder(trans('user::user.placeholder.date_of_birth'))}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ Former::text('mobile')
				-> value($user->mobile)
				-> label(trans('user::user.label.mobile'))
				-> placeholder(trans('user::user.placeholder.mobile'))}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ Former::text('phone')
				-> label(trans('user::user.label.phone'))
				-> value($user->phone)
				-> placeholder(trans('user::user.placeholder.phone'))}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ Former::textarea('address')
				-> label(trans('user::user.label.address'))
				-> value($user->address)
				-> placeholder(trans('user::user.placeholder.address'))}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ Former::text('street')
				-> label(trans('user::user.label.street'))
				-> value($user->street)
				-> placeholder(trans('user::user.placeholder.street'))}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ Former::text('city')
				-> label(trans('user::user.label.city'))
				-> value($user->city)
				-> placeholder(trans('user::user.placeholder.city'))}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ Former::text('district')
				-> label(trans('user::user.label.district'))
				-> value($user->district)
				-> placeholder(trans('user::user.placeholder.district'))}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ Former::text('state')
				-> label(trans('user::user.label.state'))
				-> value($user->state)
				-> placeholder(trans('user::user.placeholder.state'))}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ Former::text('web')
				-> label(trans('user::user.label.web'))
				-> value($user->web)
				-> placeholder(trans('user::user.placeholder.web'))}}
			</div>
		</div>
		<div class="row" align="center">
			<div class="col-md-12">
				{{Former::actions()
				->large_primary_submit('Update')	}}
			</div>

		</div>
		{{Former::close()}}
	</div>
</div>