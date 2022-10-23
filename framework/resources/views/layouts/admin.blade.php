<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ isset(App\Setting::first()->company) ? App\Setting::first()->company : config('app.name') }} @yield('title')</title>
  <link rel="icon" type="img/png" sizes="32x32" href="{{ asset('assets/1x/favicon.png') }}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/_all-skins.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">

  <!-- Full Calender JS -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}">

  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  {{-- PNotify  --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pnotify.custom.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->

  <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/demo.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  @yield('styles')
  <style type="text/css">
    .logo-lg img {
      height: 42px;
      @php($settings=App\Setting::first()) @if ($settings !=null) @endif
      /*    width: 184px;*/
      padding-top: 6px;

    }
  </style>
</head>

<body class="hold-transition skin-yellow sidebar-dark-blue sidebar-mini fixed sidebar-collapse">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <!-- logo for regular state and mobile devices -->
        @php($settings = App\Setting::first())
        @if ($settings != null)
        <span class="logo-mini">
          <img class="" alt="Medical Logo" width="70%" src="{{ asset('assets/1x/favicon.png') }}"></img>
        </span>
        <span class="logo-lg">
          @if($settings->logo != null)
          <img class="" alt="Medical Logo" src="{{ asset('uploads/'.$settings->logo) }}"></img>
          @elseif($settings->company != null)
          <span class="logo-lg"><b>{{ $settings->company }}</b></span>
          @else
          <span class="logo-lg"><img src="{{ asset('assets/1x/logo.png') }}"></span>
          @endif
        </span>
        @else
        <span class="logo-lg"><img src="{{ asset('assets/1x/logo.png') }}"></span>
        @endif
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">@lang('equicare.toggle_navigation')</span>
        </a>
        <!-- <form class="navbar-form navbar-left" role="search" action="" method="GET">
          <div class="form-group">
            <input type="text" class="form-control" style="background-color: white;" id="navbar-search-input" placeholder="Search Serial Number">
          </div>
        </form> -->
        <ul class="nav navbar-nav collapse navbar-collapse">
          <li><a href="#" class="text-bold app-title">@lang('equicare.app_title')</a></li>
        </ul>
        <div class="navbar-custom-menu" style="color: black !important;">
          <ul class="nav navbar-nav pull-right">
            @unlessrole('Customer')
            <li class="dropdown nav-item">
              <a href="#" class="nav-link familyfont" data-toggle="dropdown" area-expanded="false">
                <i class="fa fa-info-circle"></i>&nbsp;
                <span class="hidden-xs">@lang('equicare.help')</span>
              </a>
              <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ url('/framework/public/KDGH_MEMS_USER_GUIDE_V120.pdf') }}">
                      <i class="fa fa-book"></i>&nbsp;
                      @lang('equicare.user_guide')
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="https://kb.kdglobalhealthcare.com" target="_blank">
                      <i class="fa fa-book"></i>&nbsp;
                      @lang('equicare.kb')
                    </a>
                </li>
              </ul>
            </li>
            @endunlessrole
            <li class="nav-item dropdown">
              <a href="#" class="nav-link familyfont" data-toggle="dropdown" area-expanded="false">
                <i class="fa fa-user"></i>
                <span class="hidden-xs">&nbsp;&nbsp;{{ ucfirst(Auth::user()->name) ?? 'No User' }}</span>
              </a>
              <ul class="dropdown-menu">
                <li class="{{ $page=='Change Password'?'active':'' }}">
                  <a class="dropdown-item" href="{{ route('change-password') }}">
                    <i class="fa fa-lock"></i>&nbsp;
                    @lang('equicare.change_password')
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>&nbsp;
                    @lang('equicare.logout')

                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="none-display;">
                    {{ csrf_field() }}
                  </form>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          @unlessrole('Customer')
          <li class="{{ $page=='/home'?'active':'' }}">
            <a href="{{ url('/admin/dashboard') }}">
              <i class="fa fa-dashboard"></i> <span>@lang('equicare.dashboard')</span>
            </a>
          </li>
          @endunlessrole

          @can('View Hospitals')
          <li class="{{ $page=='hospitals'?'active':'' }}">
            <a href="{{ url('/admin/hospitals') }}">
              <i class="fa fa-hospital-o"></i> <span>@lang('equicare.hospital')</span>
            </a>
          </li>
          @endcan

          @can('View Departments')
          <li class="{{ $page=='departments'?'active':'' }}">
            <a href="{{ url('/admin/departments') }}">
              <i class="fa fa-building-o"></i> <span>@lang('equicare.departments')</span>
            </a>
          </li>
          @endcan

          @can('View Equipments')
            @unlessrole('Customer')
            <li class="{{ $page=='equipments'?'active':'' }}">
              <a href="{{ url('/admin/equipments') }}">
                <i class="fa fa-heartbeat"></i> <span>@lang('equicare.equipments')</span>
              </a>
            </li>
            @endunlessrole
          @endcan

          @if($page == "breakdown_maintenance" || $page == "preventive_maintenance")
            @php($class="treeview menu-open")
            @php($active = "active")
            @php($menu="style=display:block;")
          @else
            @php($class="treeview")
            @php($active = "")
            @php($menu="")
          @endif

          @can('View Preventive Maintenance')
          <li class="{{ $class }} {{ $active }}">
            <a href="#" class="">
              <i class="fa fa-phone"></i> <span>@lang('equicare.call_entries')</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" {{ $menu }}>
              <li class="{{ $page=='breakdown_maintenance'?'active':'' }}">
                <a href="{{ url('admin/call/breakdown_maintenance') }}">
                  <i class="fa fa-wrench"></i> @lang('equicare.breakdown_maintenance')
                </a>
              </li>
              <li class="{{ $page=='preventive_maintenance'?'active':'' }}">
                <a href="{{ url('admin/call/preventive_maintenance') }}">
                  <i class="fa fa-life-buoy"></i> @lang('equicare.preventive_maintenance')
                </a>
              </li>
            </ul>
          </li>
          @endcan

          @can('View Calibrations')
          <li class="{{ $page=='calibrations'?'active':'' }}">
            <a href="{{ url('admin/calibration') }}">
              <i class="fa fa-balance-scale"></i> <span>@lang('equicare.calibrations')</span>
            </a>
          </li>
          @endcan

          @can('View Maintenance Cost')
          <li class="{{ $page=='maintenance_cost'?'active':'' }}">
            <a href="{{ url('admin/maintenance_cost') }}">
              <i class="fa fa-money"></i> <span>@lang('equicare.maintenance_cost')</span>
            </a>
          </li>
          @endcan

          @if($page == "reports/time_indicator" || $page == "reports/equipments" || $page == "reports/activity")
          @php($class="treeview menu-open")
          @php($active = "active")
          @php($menu="style=display:block;")
          @else
          @php($class="treeview")
          @php($active = "")
          @php($menu="")
          @endif

          @can('View Time Indicator Report')
          <li class="{{ $class }} {{ $active }}">
            <a href="#" class="">
              <i class="fa fa-th"></i> <span>@lang('equicare.reports')</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" {{ $menu }}>
              <li class="{{ $page=='reports/time_indicator'?'active':'' }}">
                <a href="{{ url('admin/reports/time_indicator') }}">
                  <i class="fa fa-file"></i> <span>@lang('equicare.time_indicator')</span>
                </a>
              </li>
              <li class="{{ $page=='reports/equipments'?'active':'' }}">
                <a href="{{ url('admin/reports/equipments') }}">
                  <i class="fa fa-file"></i> <span>@lang('equicare.equipment_report')</span>
                </a>
              </li>
              <li class="{{ $page=='reports/activity'?'active':'' }}">
                <a href="{{ url('admin/reports/activity_report') }}">
                  <i class="fa fa-file"></i> <span>@lang('equicare.report_activity')</span>
                </a>
              </li>
            </ul>
          </li>
          @endcan
          
          @php($date = date('Y-m-d',strtotime('+14 days')))
          @php($preventive_reminder_count = \App\CallEntry::where('call_type','preventive')->where('next_due_date','<=',$date)->count())
            @php($calibrations_reminder_count = \App\Calibration::where('due_date','<=',$date)->count())
              @if($page == "preventive_maintenance_reminder" || $page == "calibrations_reminder")
              @php($class="treeview menu-open")
              @php($active = "active")
              @php($menu="style=display:block;")
              @else
              @php($class="treeview")
              @php($active = "")
              @php($menu="")
              @endif

              @can('View Preventive Maintenance')
              <li class="{{ $class }} {{ $active }}">
                <a href="#" class="">
                  <i class="fa fa-clock-o"></i> <span>@lang('equicare.reminder')</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu" {{ $menu }}>
                  <li class="{{ $page=='preventive_maintenance_reminder'?'active':'' }}">
                    <a href="{{ url('admin/reminder/preventive_maintenance') }}">
                      <i class="fa fa-barcode"></i> <span>@lang('equicare.preventive_reminder')</span>
                      @if($preventive_reminder_count > 0)
                      <span class="badge label-danger">{{ $preventive_reminder_count }}</span>
                      @endif
                    </a>
                  </li>
                  <li class="{{ $page=='calibrations_reminder'?'active':'' }}">
                    <a href="{{ url('admin/reminder/calibration') }}">
                      <i class="fa fa-balance-scale"></i> <span>@lang('equicare.calibrations_reminder')</span>
                      @if($calibrations_reminder_count > 0)
                      <span class="badge label-danger">{{ $calibrations_reminder_count }}</span>
                      @endif
                    </a>
                  </li>
                </ul>
              </li>
              @endcan

              @can('View Calibrations')
              <li class="{{ $page=='calibrations_sticker'?'active':'' }}">
                <a href="{{ url('admin/calibrations_sticker') }}">
                  <i class="fa fa-tags"></i> <span>@lang('equicare.calibrations_sticker')</span>
                </a>
              </li>
              @endcan

              @role('Admin')
              <li class="{{ $page=='settings'?'active':'' }}">
                <a href="{{ url('admin/settings') }}">
                  <i class="fa fa-cog"></i> <span>@lang('equicare.settings')</span>
                </a>
              </li>

              @if($page == "users" || $page == "roles" || $page == "permissions")
              @php($class="treeview menu-open")
              @php($active = "active")
              @php($menu="style=display:block;")
              @else
              @php($class="treeview")
              @php($active = "")
              @php($menu="")
              @endif

              <li class="{{ $class }} {{ $active }}">
                <a href="#" class="">
                  <i class="fa fa-users"></i> <span>@lang('equicare.user_permission')</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu" {{ $menu }}>
                  <li class="{{ $page=='users'?'active':'' }}">
                    <a href="{{ url('admin/users') }}">
                      <i class="fa fa-user"></i> @lang('equicare.users')
                    </a>
                  </li>
                  <li class="{{ $page=='roles'?'active':'' }}">
                    <a href="{{ url('admin/roles') }}">
                      <i class="fa fa-unlock-alt"></i> @lang('equicare.roles')
                    </a>
                  </li>
                </ul>
              </li>
              @endrole
              @role('Customer')
              <li class="{{ $page=='my_hospitals'?'active':'' }}">
                <a href="{{ url('/customer/hospital/'.Auth::user()->hospital_id) }}">
                  <i class="fa fa-hospital-o"></i> <span>@lang('equicare.hospital')</span>
                </a>
              </li>
              <li class="{{ $page=='my_departments'?'active':'' }}">
                <a href="{{ url('/customer/departments') }}">
                  <i class="fa fa-building-o"></i> <span>@lang('equicare.department')</span>
                </a>
              </li>
              <!-- <li class="{{ $class }} {{ $active }}">
                <a href="#" class="">
                  <i class="fa fa-pie-chart"></i> <span>@lang('equicare.reports')</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu" {{ $menu }}>
                  <li class="{{ $page=='my_reports'?'active':'' }}">
                    <a href="#">
                      <i class="fa fa-file"></i> @lang('equicare.report_activity')
                    </a>
                  </li>
                </ul>
              </li> -->
              @endrole
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header pt-0">

        @if(url()->current() == url('/'))
        <h1>
          @lang('equicare.dashboard')
        </h1>
        @else
        <h1>@yield('body-title')</h1>
        @endif
        <ol class="breadcrumb">
          <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> @lang('equicare.home')</a></li>
          @yield('breadcrumb')
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        @yield('content')
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.2.0
      </div>
      <strong>@lang('equicare.copyright') &copy; 2019-{{ date('Y') }} <a href="https://kdglobalhealthcare.com" target="_blank">KD Global Ltd</a>.</strong> @lang('equicare.all_rights_reserved').
    </footer>


    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('assets/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

  <!-- daterangepicker -->
  <script src="{{ asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  <!-- datepicker -->
  <script src="{{ asset('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <!-- Slimscroll -->
  <script src="{{ asset('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('assets/bower_components/fastclick/lib/fastclick.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>

  <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
  {{-- PNotify --}}
  <script src="{{ asset('assets/js/pnotify.custom.min.js') }}" type="text/javascript"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>
  <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_minimal-blue',
        // increaseArea: '20%' /* optional */
      });
    });
  </script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('assets/js/demo.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      @if(session('flash_message'))
      new PNotify({
        title: ' Success!',
        text: "{{ session('flash_message') }}",
        type: 'success',
        delay: 3000,
        nonblock: {
          nonblock: true
        }
      });
      @endif
      @if(session('flash_message_error'))
      new PNotify({
        title: ' Warning!',
        text: "{{ session('flash_message_error') }}",
        type: 'warning',
        delay: 3000,
        nonblock: {
          nonblock: true
        }
      });
      @endif
    });
  </script>
  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
  var Tawk_API = Tawk_API || {},
    Tawk_LoadStart = new Date();
  (function() {
    var s1 = document.createElement("script"),
      s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = 'https://embed.tawk.to/634c89efb0d6371309c9d825/1gfhflkgj';
    s1.charset = 'UTF-8';
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
  })();
  </script>
  <!--End of Tawk.to Script-->
  @yield('scripts')
</body>

</html>