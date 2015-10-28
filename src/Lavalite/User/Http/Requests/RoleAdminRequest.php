<?php

namespace Lavalite\User\Http\Requests;

use App\Http\Requests\Request;
use User;

class RoleAdminRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(\Illuminate\Http\Request $request)
	{
		// Determine if the user is authorized to create an entry,
		if($request->isMethod('POST') || $request->is('*/create'))
			return User::can('user.role.create');

		// Determine if the user is authorized to update an entry,
		if($request->isMethod('PUT') || $request->isMethod('PATCH') || $request->is('*/edit'))
			return User::can('user.role.edit');

		// Determine if the user is authorized to delete an entry,
		if($request->isMethod('DELETE'))
			return User::can('user.role.delete');

		// Determine if the user is authorized to view the module.
		return User::can('user.role.view');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(\Illuminate\Http\Request $request)
	{
		// validation rule for create request.
		if($request->isMethod('POST'))
			return [
				'name' => 'required'
			];

		// Validation rule for update request.
		if($request->isMethod('PUT') || $request->isMethod('PATCH'))
			return [
				'name' => 'required'
			];

		// Default validation rule.
		return [

		];

	}

}