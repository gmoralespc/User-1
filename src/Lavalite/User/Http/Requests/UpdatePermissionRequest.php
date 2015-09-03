<?php

namespace Lavalite\User\Http\Requests;

use App\Http\Requests\Request;
use User;

class UpdatePermissionRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return User::can(['permission.edit']);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		if(!Request::isMethod('PUT')) return [];

		return [
			'name' => 'required',
		];
	}

}
