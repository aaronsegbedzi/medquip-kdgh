<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();

Route::get('install', 'LaravelWebInstaller@index');
Route::post('installed', 'LaravelWebInstaller@install');
Route::get('installed', 'LaravelWebInstaller@index');
Route::get('migrate', 'LaravelWebInstaller@db_migration');
Route::get('migration', 'LaravelWebInstaller@migration');
Route::get('/equipments/history/{equipment}', 'EquipmentController@history')->name('equipments.history');

Route::group(['middleware' => ['installed_or_not', 'auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', function () {
        return redirect('/admin/dashboard');
    });
    Route::get('/admin/dashboard', 'HomeController@index')->name('home');

    Route::get('admin/change-password', 'ChangePasswordController@changePassword')->name('change-password');
    Route::post('admin/change-password', 'ChangePasswordController@updatePassword')->name('change-password.store');

    Route::resource('admin/users', 'UserController');
    Route::resource('admin/roles', 'RoleController');
    Route::resource('admin/permissions', 'PermissionController');
    Route::resource('admin/hospitals', 'HospitalController');

    Route::get('/admin/equipment/qr/{id}', 'EquipmentController@qr')->name('equipments.qr');
    Route::get('/admin/equipment/qr-image/{id}', 'EquipmentController@qr_image')->name('equipments.qrimage');

    Route::get('/admin/equipments', 'EquipmentController@index')->name('equipments.index');
    Route::post('/admin/equipments', 'EquipmentController@store')->name('equipments.store');
    Route::get('/admin/equipments/create', 'EquipmentController@create')->name('equipments.create');
    Route::delete('/admin/equipments/{equipment}', 'EquipmentController@destroy')->name('equipments.destroy');
    Route::patch('/admin/equipments/{equipment}', 'EquipmentController@update')->name('equipments.update');
    Route::get('/admin/equipments/{equipment}/edit', 'EquipmentController@edit')->name('equipments.edit');
    
	 
    Route::resource('admin/departments', 'DepartmentController');
    Route::resource('admin/call/breakdown_maintenance', 'BreakdownController');
    Route::get('admin/call/breakdown_maintenance/attend/{id}', 'BreakdownController@attend_call_get');
    Route::post('admin/call/breakdown_maintenance/attend', 'BreakdownController@attend_call');
    Route::get('admin/call/breakdown_maintenance/call_complete/{id}', 'BreakdownController@call_complete_get');
    Route::post('admin/call/breakdown_maintenance/call_complete', 'BreakdownController@call_complete');

    Route::get('admin/call/preventive_maintenance/attend/{id}', 'PreventiveController@attend_call_get');
    Route::post('admin/call/preventive_maintenance/attend', 'PreventiveController@attend_call');
    Route::get('admin/call/preventive_maintenance/call_complete/{id}', 'PreventiveController@call_complete_get');
    Route::post('admin/call/preventive_maintenance/call_complete', 'PreventiveController@call_complete');

    # Breakdown call routes
    Route::get('unique_id_breakdown', 'BreakdownController@ajax_unique_id');
    Route::get('hospital_breakdown', 'BreakdownController@ajax_hospital_change');
    Route::get('department_breakdown', 'BreakdownController@ajax_department_change');

    # preventive call routes
    Route::get('unique_id_preventive', 'PreventiveController@ajax_unique_id');
    Route::get('hospital_preventive', 'PreventiveController@ajax_hospital_change');
    Route::get('department_preventive', 'PreventiveController@ajax_department_change');
    Route::get('call_complete_preventive_new_item', 'PreventiveController@ajax_new_item');
    Route::post('call_complete_preventive_new_item', 'PreventiveController@ajax_new_item_post');

    Route::get('admin/reports/time_indicator', 'ReportController@time_indicator');
    Route::get('admin/reports/time_indicator/filter', 'ReportController@time_indicator_filter');
    Route::get('admin/reports/time_indicator/ajax_equipment_based_on_hospital', 'ReportController@ajax_to_get_equipment');
    Route::get('admin/reports/equipments', 'ReportController@equipment_report');
    Route::get('admin/reports/equipments/filter', 'ReportController@equipment_report_post');
    Route::get('admin/reminder/preventive_maintenance', 'ReminderController@preventive_reminder');
    Route::get('admin/reminder/calibration', 'ReminderController@calibrations_reminder');
    Route::resource('admin/calibration', 'CalibrationController');
    Route::resource('admin/call/preventive_maintenance', 'PreventiveController');
    Route::get('/payments/excel',
        [
            'as' => 'excel',
            'uses' => 'ReportController@excel_export_equipment',
        ]);
    Route::resource('admin/maintenance_cost', 'CostController');
    Route::post('admin/maintenance_cost/get_info', 'CostController@get_info')->name('maintenance_cost.get_info');
    Route::get('get_equipment', 'CostController@get_equipment');
    Route::get('admin/settings', 'SettingController@index');
    Route::post('admin/settings', 'SettingController@post');
    Route::post('admin/mail-settings', 'SettingController@mailSettings');
    Route::get('admin/delete_logo/{logo}', 'SettingController@deleteLogo');
    Route::get('admin/calibrations_sticker/get_equipment', 'StickerController@get_equipment_ajax');
    Route::get('admin/calibrations_sticker', 'StickerController@index');
    Route::get('admin/calibrations_sticker2', 'StickerController@post');
    Route::get('admin/calibrations_sticker/{id}', 'StickerController@single_sticker');
});
