<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCostRequest extends FormRequest {
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
		$rules = [];

		foreach ($this->request->get('cost') as $key => $val) {
			$rules['equipments.' . $key] = 'required';
			$rules['start_dates.' . $key] = 'required';
			$rules['end_dates.' . $key] = 'required';
			$rules['cost.' . $key] = 'required|numeric';
		}
		$m = [
			'tp_name' => 'required_if:cost_by,=,tp',
			'tp_mobile' => 'required_if:cost_by,=,tp|nullable|numeric',
			'tp_email' => 'required_if:cost_by,=,tp|nullable|email',
			'hospital_id' => 'required',
			'type' => 'required',
			'cost_by' => 'required',
		];
		return array_merge($rules, $m);
	}

	public function messages() {
		$messages = [];
		if ($this->cost) {
			foreach ($this->cost as $i => $v) {
				$messages['equipments.' . $i . '.required'] = 'Equipment field is required';
				$messages['start_dates.' . $i . '.required'] = 'Start Date field is required';
				$messages['end_dates.' . $i . '.required'] = 'End Date field is required';
				$messages['cost.' . $i . '.required'] = 'Cost field is required';
				$messages['cost.' . $i . '.numeric'] = 'Cost must be a number.';
			}
		}
		$messages['tp_name.required_if'] = 'Name field is required';
		$messages['tp_mobile.required_if'] = 'Mobile Number field is required';
		$messages['tp_mobile.numeric'] = 'Mobile Number field must be a number';
		$messages['tp_email.required_if'] = 'Email field is required';
		$messages['tp_email.email'] = 'Email must contain valid email-address';
		$messages['hospital_id.required'] = 'Hospital field is required';
		$messages['cost_by.required'] = 'Cost By field is required';
		$messages['type.required'] = 'Type field is required';
		return $messages;
	}
}
