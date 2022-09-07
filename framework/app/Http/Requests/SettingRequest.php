<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest {
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
			'yb_type' => 'required',
			'private_site' => 'required',
			'allow_contribution' => 'required',
		];
	}
	public function messages() {
		return [
			'yb_type.required' => 'Year Blog Type field is required',
			'private_site.required' => 'Private site field is required',
			'allow_contribution.required' => 'Allow Contributions field is required',
		];
	}
}
