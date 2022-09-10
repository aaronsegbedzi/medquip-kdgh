<!DOCTYPE html>
<html>
<head>
	<title>@lang('equicare.equipments_excel')</title>
</head>
<body>
		@if(isset($equipments) && $equipments->count())
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead class="thead-inverse">
					<tr>
						<th class="text-center"> # </th>
						<th> @lang('equicare.name') </th>
						<th> @lang('equicare.short_name') </th>
						<th> @lang('equicare.user') </th>
						<th> @lang('equicare.company') </th>
						<th> @lang('equicare.model') </th>
						<th> @lang('equicare.hospital') </th>
						<th> @lang('equicare.serial_no') </th>
						<th> @lang('equicare.department') </th>
						<th> @lang('equicare.unique_id') </th>
						<th> @lang('equicare.purchase_date') </th>
						<th> @lang('equicare.order_date') </th>
						<th> @lang('equicare.installation_date') </th>
						<th> @lang('equicare.warranty_date') </th>
					</tr>
				</thead>
				<tbody>
					@foreach ($equipments as $key => $equipment)
					<tr>
						<td> {{ $key+1 }} </td>
						<td> {{ ucfirst($equipment->name) }} </td>
						<td>{{ $equipment->short_name }}</td>
						<td>{{ $equipment->user?ucfirst($equipment->user->name):'-' }}</td>
						<td>{{ $equipment->company?? '-' }}</td>
						<td>{{ $equipment->model ?? '-' }}</td>
						<td>{{ $equipment->hospital?$equipment->hospital->name:'-' }}</td>
						<td>{{ $equipment->sr_no }}</td>
						<td>{{ ($equipment->get_department->short_name)??"-" }} ({{ ($equipment->get_department->name) ??'-' }})</td>
						<td>{{ $equipment->unique_id }}</td>
						<td>{{ $equipment->date_of_purchase?? '-' }}</td>
						<td>{{ $equipment->order_date?? '-' }}</td>
						<td>{{ $equipment->date_of_installation??'-' }}</td>
						<td>{{ $equipment->warranty_due_date??'-' }}</td>
					</tr>

					@endforeach

				</tbody>
				<tfoot>
					<tr>
						<th class="text-center"> # </th>
						<th> @lang('equicare.name') </th>
						<th> @lang('equicare.short_name') </th>
						<th> @lang('equicare.user') </th>
						<th> @lang('equicare.company') </th>
						<th> @lang('equicare.model') </th>
						<th> @lang('equicare.hospital') </th>
						<th> @lang('equicare.serial_no') </th>
						<th> @lang('equicare.department') </th>
						<th> @lang('equicare.unique_id') </th>
						<th> @lang('equicare.purchase_date') </th>
						<th> @lang('equicare.order_date') </th>
						<th> @lang('equicare.installation_date') </th>
						<th> @lang('equicare.warranty_date') </th>
					</tr>
				</tfoot>
			</table>
		</div>
		@endif

</body>
</html>