<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name' => 'required|max:150',
			'email' => 'required|unique:users,email,' . $this->id,
			'password' => 'required|confirmed',
			'phone' => 'required|numeric|max:16',
			'role' => 'required',
		];
	}
	public function messages() {
		return [
			'name.required' => 'The Name field is required.',
			'email.required' => 'The Email field is required.',
			'password.required' => 'The Password field is required.',
			'phone.required' => 'The Phone field is required.',
			'role.required' => 'The Role field is Required',
			'phone.numeric' => 'The Phone number can be numeric only'
		];
	}
}
