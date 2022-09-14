<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HospitalRequest extends FormRequest {
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
			'name' => 'required',
			'email' => 'required',
			'contact_person' => 'required',
			'phone_no' => 'required|numeric|min:6',
			'mobile_no' => 'required|numeric|min:10',
			'address' => 'required',
		];
	}
	public function messages() {
		return [
			'name.required' => 'The Name field is required.',
			'email.required' => 'The Email field is required.',
			'contact_person' => 'The Contact Person field is required.',
			'phone_no.required' => 'The Phone number field is required.',
			'mobile_no.required' => 'The Mobile number field is required.',
			'address.required' => 'The Address field is required.',
			'phone_no.numeric' => 'The Phone number can be numeric only.',
			'mobile.numeric' => 'The Mobile number can be numeric only.'
		];
	}
}
