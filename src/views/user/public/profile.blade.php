
<section class="container">
    <div class="row">
        <div class="col-md-8">
            <h2></h2>
            <h2>Update Profile</h2>
            	{{Former::vertical_open()
	->id('profile')
	->secure()
	->method('POST')
	->class('white-row')
	->action(URL::to('user/profile'))}}
	{{Former::hidden('id')}}
		@if ($message = Session::get('success'))
				<div class="alert alert-success alert-block view-message">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<h4>Success</h4>
					{{{ $message }}}
				</div>
				@endif
		<div class="row">
			<div class="col-md-6">
				
				{{ Former::text('first_name')
				-> label(trans('user::user.label.first_name'))
				-> value($user->first_name)
				-> placeholder(trans('user::user.placeholder.first_name'))		}}
			</div>

			<div class="col-md-6">
				{{ Former::text('last_name')
				-> label(trans('user::user.label.last_name'))
				-> value($user->last_name)
				-> placeholder(trans('user::user.placeholder.last_name'))	}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				@if($user->sex == 'male')
					{{
					Former::radios('sex')

					->radios(array(
					'Male'   => array('name' => 'sex', 'value' => 'male','checked' => 'checked'),
					'Female' => array('name' => 'sex', 'value' => 'female'),
					))}}
					@else
					{{
					Former::radios('sex')
					->radios(array(
					'Male'   => array('name' => 'sex', 'value' => 'male'),
					'Female' => array('name' => 'sex', 'value' => 'female','checked' => 'checked'),
					))}}
					@endif
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				{{ Former::text('date_of_birth')
				-> label(trans('user::user.label.date_of_birth'))
				-> value($user->date_of_birth)
				-> addClass('date-picker')
				-> placeholder(trans('user::user.placeholder.date_of_birth'))}}
			</div>
			<div class="col-md-6">
				{{ Former::text('mobile')
				-> value($user->mobile)
				-> label(trans('user::user.label.mobile'))
				-> placeholder(trans('user::user.placeholder.mobile'))}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				{{ Former::text('country')
				-> label(trans('user::user.label.country'))
				-> value($user->country)
				-> placeholder(trans('user::user.placeholder.country'))}}
			</div>
			<div class="col-md-6">
				{{ Former::text('state')
				-> label(trans('user::user.label.state'))
				-> value($user->state)
				-> placeholder(trans('user::user.placeholder.state'))}}
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
         <div class="col-md-4">

            <h2></h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pellentesque neque eget diam porta.</p>
            <p>
                @include("user::partials.menu")
            </p>
            

        </div>
    </div>
</section>    