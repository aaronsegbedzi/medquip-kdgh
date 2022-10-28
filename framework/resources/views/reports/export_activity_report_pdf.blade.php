<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @page {
            margin-top: 100px;
            margin-left: 50px;
            margin-right: 50px;
            margin-bottom: 50px;
        }

        body {
            font-size: 13px;
        }

        #header {
            position: fixed;
            left: 0px;
            top: -90px;
            right: 65px;
        }

        #footer {
            position: fixed;
            left: 0px;
            bottom: 25px;
            right: 0px;
        }

        #footer .page:after {
            content: counter(page);
        }

        .page-break {
            page-break-after: always;
        }

        /* Header CSS */
        .heading {
            color: red !important;
        }

        .header table {
            border: none;
        }

        .header td {
            border: none;
        }

        .header th {
            border: none;
        }

        /* Contenct CSS */
        .content table {
            border: 1px solid black;
        }

        .content th {
            border: 1px solid black;
        }

        .content td {
            border: 1px solid black;
        }

        table,
        th,
        td {
            padding: 5px;
            border-collapse: collapse;
        }



        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .v-middle {
            vertical-align: middle !important;
        }

        .bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }

        .sign-section {
            padding: none !important;
        }
    </style>

<body>
    <div id="header">
        <table class="header" width="100%" cellspacing="0px">
            <tbody>
                <tr>
                    <td class="text-left" width="20%">
                        @if(isset($hospital->logo))
                        <img src="data:{{ $hospital->mime }};base64,{{ $hospital->logo }}" width="250px" />
                        @endif
                    </td>
                    <td class="text-center" width="60%">
                        <p class="v-middle bold" style="font-size: 16px !important;">PLANNED MAINTENANCE REPORT ({{ date("d M Y", strtotime($from_date) )}} - {{ date("d M Y", strtotime($to_date) )}})</p>
                    </td>
                    <td class=" text-right" width="20%">
                            <img src="{{ asset('assets/1x/logo_bck.png') }}" width="180px" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="footer">
        <p class="page text-center bold">Page </p>
    </div>
    <div id="content">
        <table class="content" width="100%">
            <thead>
                <tr>
                    <th class="text-center heading">NO.</th>
                    <th class="text-center heading">EQUIPMENT</th>
                    <th class="text-center heading">DEPT/UNIT</th>
                    <th class="text-center heading">MODEL</th>
                    <th class="text-center heading">S. NUMBER</th>
                    <th class="text-center heading">SERVICE</th>
                    <th class="text-center heading">ACTION TAKEN</th>
                    <th class="text-center heading">REMARKS</th>
                    <th class="text-center heading">MAINTENANCE DATE</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = 1;
                @endphp
                @foreach($calls as $call)
                <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td>{{ $call->ename }}</td>
                    <td>{{ $call->dname }}</td>
                    <td class="text-center">{{ $call->model }}</td>
                    <td class="text-center">{{ $call->sr_no }}</td>
                    <td class="text-center">
                        @php
                            switch ($call->type) {
                                case 'breakdown':
                        @endphp
                                    @lang('equicare.breakdown')
                        @php
                                break;
                                default:
                        @endphp
                                    @lang('equicare.preventive')
                        @php
                                break;
                                }
                        @endphp
                    </td>
                    <td>{{ $call->remarks }}</td>
                    <td class="text-center">Complete</td>
                    <td class="text-center">{{ date("d.m.y", strtotime($call->call_complete_date_time)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- <div class="page-break"></div> -->
        <table width="100%">
            <thead>
                <tr>
                    <td width="50%">
                        <p class="bold underline">TECHNICAL TEAM-KDGH</p>
                    </td>
                    <td width="50%">
                        <p class="bold underline">FACILITY REPRESENTATIVE</p>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="sign-section">
                        <p>NAME: <span class="bold">{{ strtoupper(Auth::user()->name) }}</span></p>
                    </td>
                    <td class="sign-section">
                        <p>NAME:</p>
                    </td>
                </tr>
                <tr>
                    <td class="sign-section">
                        <p>POSITION: <span class="bold">{{ strtoupper(Auth::user()->role->name) }}</span></p>
                    </td>
                    <td class="sign-section">
                        <p>POSITION:</p>
                    </td>
                </tr>
                <tr>
                    <td class="sign-section">
                        <p>SIGN:</p>
                    </td>
                    <td class="sign-section">
                        <p>SIGN:</p>
                    </td>
                </tr>
                <tr>
                    <td class="sign-section">
                        <p>DATE: <span class="bold">{{ date("d/m/Y") }}</span></p>
                    </td>
                    <td class="sign-section">
                        <p>DATE:</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>