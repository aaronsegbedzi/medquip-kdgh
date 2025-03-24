<!DOCTYPE html>
<html>
<head>
	<title>@lang('equicare.calibration_single_sticker_generate')</title>
	<style type="text/css">
		.container{
			width: 700px;
		}
		.card{
			width: 50%;
			display: inline-block;
			border: 1px solid;
			border-radius: 50%;
			padding:5px;
			float: left;
			margin-right: 10px;
			margin-bottom: 10px;
		}
		.card > span{
			line-height: 1.5;
			font-size: 12px;
		}
		.page-break {
		    page-break-after: always;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="card">
			<img src="{{ asset('/framework/public/qrcodes/'.$calibration->equipment->id.'.png') }}" style="float:right; padding:5px; width:100px;">
			<span><b>@lang('equicare.equipment_id') </b> : {{ $calibration->equipment->unique_id}}</span><br/>
			<span><b>@lang('equicare.equipment_name')</b> : {{ $calibration->equipment->name}}</span>
			<br>
			<span><b>@lang('equicare.date_pm')</b> :
				{{ $calibration->equipment->call_entry?date('Y-m-d',strtotime($calibration->equipment->call_entry->call_register_date_time)): '-'}}
			</span>
			<br/>
			<span><b>@lang('equicare.due_pm')</b> :
				{{ $calibration->equipment->call_entry->next_due_date?? '-'}}
			</span>
			<br/>
			<span><b>@lang('equicare.calibration_date')</b> : {{ $calibration->date_of_calibration}}
			</span>
			<br/>
			<span><b>@lang('equicare.calibration_due_date')</b> : {{ $calibration->due_date}}
			</span>
			<br/>
			<span><b>@lang('equicare.engineer_contact_no')</b> : {{ $calibration->engineer_no}}
			</span>
		</div>
	</div>
</body>
</html>