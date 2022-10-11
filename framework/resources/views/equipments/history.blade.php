@extends('layouts.app')
@section('body-title')
@lang('equicare.equipment_history')
@endsection
@section('title')
| @lang('equicare.equipment_history')
@endsection
@section('breadcrumb')
<li class="active">@lang('equicare.equipment_history')</li>
@endsection

@section('content')
<style>
   .bg-kdgh {
      background-color: hsl(30deg 71% 35%) !important;
      color: white !important;
   }
</style>
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="text-center">
            <img style="padding-right: 10px;" src="{{ asset('assets/1x/logo.png') }}" height="60px" alt="" />
            <h2 style="color: white !important;">@lang('equicare.equipment_history')</h2>
         </div>
         <br />
         <div class="box">
            <div class="box-header with-border">
               <h4 class="box-title" style="float:left;">
                  <b>@lang('equicare.name')</b> : {{$equipment->name}}
               </h4>

            </div>

            <div class="box-body">
               <div class="row">
                  @include('equipments.equipment')
               </div>
            </div>
            <div class="box-footer text-right">
               @unlessrole('Customer')
                  <a href="{{ route('equipments.edit',$equipment->id) }}" class="h4" title="@lang('equicare.edit')"><i class="fa fa-edit"></i> @lang('equicare.edit')</a>
               @endunlessrole
            </div>
         </div>

         <div class="col-md-12">
            <!-- The time line -->
            <ul class="timeline">

               @if($data->count() > 0)
               @foreach($data as $d)
               <!-- timeline time label -->
               <li class="time-label">
                  <span class="bg-kdgh">
                     {{date('D, d-M-Y',strtotime($d['created_at']))}}
                  </span>
               </li>
               <!-- /.timeline-label -->
               <!-- timeline item -->
               <li>
                  @if($d['type'] == 'Call')
                  <i class="fa fa-phone bg-blue"></i>
                  @elseif($d['type'] == 'Calibration')
                  <i class="fa fa-balance-scale bg-red"></i>
                  @else
                  <i class="fa fa-truck bg-green"></i>
                  @endif

                  <div class="timeline-item">
                     <span class="time">
                        <i class="fa fa-clock-o"></i> {{date('h:i A',strtotime($d['created_at']))}}
                     </span>
                     <h3 class="timeline-header">
                        <b>{{$d['type']}}
                           @if($d['type'] == 'Call')
                           - {{ucwords($d['call_type'])}}
                           @endif
                        </b>
                     </h3>
                     <div class="timeline-body">
                        <div class="row">
                           @if($d['type'] == 'Call')
                              @include('equipments.call')
                           @elseif($d['type'] == 'Calibration')
                              @include('equipments.calibration')
                           @else
                              @include('equipments.movement')
                           @endif
                        </div>
                     </div>
                     <div class="timeline-footer text-right">
                        @unlessrole('Customer')
                        <span class="time">
                           @if($d['type'] == 'Call' && $d['call_type'] == 'breakdown')
                              <a href="{{ route('breakdown_maintenance.edit',$d['id']) }}" title="@lang('equicare.edit')" class="h4"><i class="fa fa-edit"></i> @lang('equicare.edit') </a>
                           @elseif($d['type'] == 'Call' && $d['call_type'] == 'preventive')
                              <a href="{{ route('preventive_maintenance.edit',$d['id']) }}" title="@lang('equicare.edit')" class="h4"><i class="fa fa-edit"></i> @lang('equicare.edit') </a>
                           @elseif($d['type'] == 'Calibration')
                              <a href="{{ route('calibration.edit',$d['id']) }}" title="@lang('equicare.edit')" class="h4"><i class="fa fa-edit"></i> @lang('equicare.edit') </a>
                           @else
                              &nbsp;
                           @endif
                        </span>
                        @endunlessrole
                     </div>
                  </div>
               </li>
               @endforeach
               @else
               <!-- timeline item -->
               <li>
                  <i class="fa fa-circle bg-green"></i>

                  <div class="timeline-item">
                     <h3 class="timeline-header">
                        No History Found for this Equipment.
                     </h3>

                     <div class="timeline-body">

                     </div>
                  </div>
               </li>
               @endif
               <li>

                  <i class="fa fa-clock-o bg-kdgh"></i>
               </li>
            </ul>
         </div>

      </div>
   </div>
</div>
@endsection