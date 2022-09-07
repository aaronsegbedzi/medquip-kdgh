<?php

namespace App\Http\Controllers;

use App\Setting;
use Exception;
use Illuminate\Http\Request;

class SettingController extends Controller {

	private $envPath, $envExamplePath;
	public function __construct() {
		$this->envPath = base_path('.env');
		$this->envExamplePath = base_path('.env.example');

	}
	public function index() {
		$this->check_role();
		$page = 'settings';
		$setting = Setting::first();
		return view('settings.index', compact('page', 'setting'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function post(Request $request) {
		$this->check_role();

		// dd($request->all());
		$settings = Setting::first();
		$env = $this->getEnvContent();
		if ($settings == null) {
			$settings = new Setting;
		}

		if ($file = $request->file('logo')) {
			if ($settings->logo && file_exists('uploads/' . $settings->logo)) {
				unlink('uploads/' . $settings->logo);
			}
			$name = time() . '_logo_' . $file->getClientOriginalName();
			$file->move('uploads', $name);
			$settings->logo = $name;
		}

		if ($request->company) {
			// @ignoreCodingStandard			
			$settings->company = $request->company;
		}

		$settings->save();

		return redirect()->back()->with('flash_message', 'Settings updated');
	}

	public function mailSettings(Request $request) {
		$this->check_role();

		$env = $this->getEnvContent();
		$validator = \Validator::make($request->all(), [
			'mail_driver' => 'required',
			'mail_host' => 'required',
			'mail_port' => 'required|numeric',
			'mail_username' => 'required',
			'mail_password' => 'required',
			'mail_encryption' => 'required',
		]);
		if ($validator->fails()) {
			return redirect()->back()
				->withErrors($validator, 'mail_errors')
				->withInput();
		}

		$mailDriver = $request->post('mail_driver');
		$mailHost = $request->post('mail_host');
		$mailPort = $request->post('mail_port');
		$mailUsername = $request->post('mail_username');
		$mailPassword = $request->post('mail_password');
		$mailEncryption = $request->post('mail_encryption');

		$smtpSetting = "\nMAIL_DRIVER=$mailDriver
MAIL_HOST=$mailHost
MAIL_PORT=$mailPort
MAIL_USERNAME=$mailUsername
MAIL_PASSWORD=$mailPassword
MAIL_ENCRYPTION=$mailEncryption";

		$rows = explode("\n", $env);
		$unwanted = "MAIL_DRIVER|MAIL_HOST|MAIL_PORT|MAIL_USERNAME|MAIL_PASSWORD|MAIL_ENCRYPTION";
		$cleanArray = preg_grep("/$unwanted/i", $rows, PREG_GREP_INVERT);

		$cleanString = implode("\n", $cleanArray);

		$env = $cleanString . $smtpSetting;
		try {
			file_put_contents($this->envPath, $env);
		} catch (Exception $e) {
			$message = trans('messages.environment.errors');
		}

		return redirect()->back()->with('flash_message', 'SMTP Settings updated');

	}

	public function deleteLogo($img) {
		if (file_exists('uploads/' . $img)) {
			$settings = Setting::first();
			$settings->update(['logo' => null]);
			unlink('uploads/' . $img);
			return redirect()->back()->with('flash_message', 'Logo is deleted');

		} else {
			return redirect()->back()->with('flash_message_error', 'Error in Logo delete');
		}
	}

	public function getEnvContent() {
		if (!file_exists($this->envPath)) {
			if (file_exists($this->envExamplePath)) {
				copy($this->envExamplePath, $this->envPath);
			} else {
				touch($this->envPath);
			}
		}

		return file_get_contents($this->envPath);
	}

	public function check_role() {
		if (!auth()->user()->hasRole('Admin')) {
			abort('401');
		}
		return true;
	}
}
