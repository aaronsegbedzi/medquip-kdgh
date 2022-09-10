<div class="col-md-4">
   <b>@lang('equicare.user') : </b> {{ucwords($d['user']['name']) ?? '' }}
</div>

<div class="col-md-4">
   <b>@lang('equicare.call_handle') : </b> {{ucwords($d['call_handle'])}}
</div>

<div class="col-md-4">
   <b>@lang('equicare.working_status') : </b>
   @php
      switch ($d['working_status']) {
         case 'working':
            echo '<label class="label label-success">'.ucwords($d['working_status']).'</label>';
            break;
         case 'not working':
            echo '<label class="label label-danger">'.ucwords($d['working_status']).'</label>';
            break;
         default:
            echo '<label class="label label-default">'.ucwords($d['working_status']).'</label>';
            break;
      }
   @endphp
</div>

<div class="col-md-4">
   <b>@lang('equicare.report_number') : </b> {{$d['report_no']}}
</div>

<div class="col-md-4">
   <b>@lang('equicare.next_due_date') : </b> {{$d['next_due_date']}}
</div>

<div class="col-md-4">
   <b>@lang('equicare.call_registration_date_time') : </b> {{date('Y-m-d h:i A',strtotime($d['call_register_date_time'])) ?? '-'}}
</div>

<div class="col-md-4">
   <b>@lang('equicare.attended_by') : </b> {{ucwords($d['user_attended_fn']['name']) ?? ''}}
</div>

<div class="col-md-4">
   <b>@lang('equicare.first_attended_on') : </b> {{$d['user_attended_fn']?date('Y-m-d h:i A',strtotime($d['call_attend_date_time'])):'-'}}
</div>

<div class="col-md-4">
   <b>@lang('equicare.completed_on') : </b> {{!is_null($d['call_complete_date_time'])?date('Y-m-d h:i A',strtotime($d['call_complete_date_time'])) : '-'}}
</div>