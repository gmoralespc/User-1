<?php

namespace Lavalite\User\Http\Requests;

use App\Http\Requests\Request;
use User;

class StoreRoleRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return User::can(['role.create']);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		if(!Request::isMethod('POST')) return [];

		return [
			'name' => 'required',
		];
	}

}