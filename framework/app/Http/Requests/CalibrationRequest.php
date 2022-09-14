<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalibrationRequest extends FormRequest {
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
			'unique_id' => 'required',
			'date_of_calibration' => 'required',
			'due_date' => 'required',
			'contact_person_no' => 'numeric|nullable|min:6',
			'engineer_no' => 'numeric|nullable',
		];
	}
	public function messages() {
		return [
			'unique_id.required' => 'The Unique ID field is required.',
			'date_of_calibration.required' => 'The Calibration Date field is required.',
			'due_date.required' => 'The Due Date field is required',
		];
	}
}
