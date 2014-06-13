<div class="page-header">
	<h1>
		Profile <small>Your Profile!</small>
	</h1>
</div>
<div class="row">
	<div class="col-md-4">
		@include("user::partials.menu")
	</div>

	<div class="col-md-8">
		
			<div class="row">
				<div class="col-md-12">
					{{ $user->first_name}}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ $user->last_name}}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ $user->sex}}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ $user->date_of_birth}}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ $user->mobile}}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ $user->phone}}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ $user->address}}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ $user->street}}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ $user->city}}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ $user->district}}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ $user->state}}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ $user->web}}
				</div>
			</div>
		
	</div>
</div>