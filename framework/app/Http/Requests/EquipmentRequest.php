<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest {
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
			'short_name' => 'required',
			'hospital_id' => 'required',
			'sr_no' => 'required|regex:/^\S*$/',
			'model' => 'required',
			'department' => 'required',
			'company' => 'required',
			'service_engineer_no' => 'required|numeric',
		];
	}
	public function messages() {
		return [
			'name.required' => 'The Name field is required.',
			'short_name.required' => 'The Short Name field is required.',
			'hospital_id.required' => 'The Hospital field is required.',
			'sr_no.required' => 'The Serial Number field is required.',
			'model.required' => 'The Model field is required.',
			'department.required' => 'The Department field is required',
			'company.required' => 'The Company field is required.',
			'service_engineer_no.required' => 'The Service Engineer number field is required.',
			'date_of_purchase.required' => 'The Purchase Date field is required.',
			'sr_no.regex' => 'The Serial number field not allowed blank spaces.',
			'service_engineer_no.numeric' => 'The Service Engineer (Mobile No.) must be a number.'
		];
	}
}
