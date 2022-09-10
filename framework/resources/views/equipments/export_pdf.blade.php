<!DOCTYPE html>
<html>
<head>
	<title>@lang('equicare.equipment_pdf')</title>
	<style type="text/css">
	html{
width: 100%;
height: 100%;
padding: 0;
margin: 10px;
}
	.table ,td,th{
		border:1px solid;
		text-align: center;
		font-size: 14px;
	}
	td,th{
		padding: 2px 5px 2px 5px;
	}
	.table{
		border-collapse: collapse;
		overflow: scroll;
	}

	.table-responsive{
		width: 90%;
	}
	.page-break{
		page-break-after: always;
	}
	.container-fluid{
		width:100%;
	}
}

</style>
</head>
<body>
	<div class="container-fluid">
		<h2>@lang('equicare.equipments') </h2>
		@php($c= 0)
		@if(isset($equipments) && $equipments->count())
		@php($equipments_chunk = $equipments->chunk(10))
		@foreach ($equipments_chunk as $k => $chunk)
		@php($c = $c + 10)
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead class="thead-inverse">
					<tr>
						<th class="text-center"> # </th>
						<th> @lang('equicare.name') </th>
						<th> @lang('equicare.short_name') </th>
						<!-- <th> @lang('equicare.user') </th> -->
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
					@foreach ($chunk as $key => $equipment)
					<tr>
						<td> {{ $key+1 }} </td>
						<td> {{ ucfirst($equipment->name) }} </td>
						<td>{{ $equipment->short_name }}</td>
						<!-- <td>{{ $equipment->user?ucfirst($equipment->user->name):'-' }}</td> -->
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
						<!-- <th> @lang('equicare.user') </th> -->
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
		@if($c % 10 == 0 && !($loop->last == $equipments_chunk[$k]))
			<div class="page-break"></div>
		@endif
		@php($c = 0)
		@endforeach
		@endif
	</div>
</body>
</html>