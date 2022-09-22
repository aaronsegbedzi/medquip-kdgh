<!DOCTYPE html>
<html>

<head>
    <title>@lang('equicare.qr_sticker_generate')</title>
    <style type="text/css" media="all">
        * {
            box-sizing: border-box;
        }

        html * {
            font-family: Arial !important;
        }

        div {
            break-inside: avoid !important;
        }

        .container:after {
            content: "";
            display: table;
            clear: both;
            width: 3508px;
        }

        .card {
            float: left;
            width: 33.33%;
        }

        .card>span {
            line-height: 1.5;
            font-size: 12px;
        }

        .page-break {
            page-break-after: always;
        }

        .card-header {
            background: #FF8039 !important;
        }

        table {
            width: 100%;
            border: none;
        }

        .slogan {
            text-align: left !important;
            font-weight: 800;
            color: #FFF;
            vertical-align: middle;
            font-size: 8px;
            padding: 8px;
        }

        .logo {
            text-align: right !important;
            padding-right: 20px !important;
            
        }

        img {
            vertical-align: middle;
        }

        .card-body {
            text-align: center !important;
        }

        .company-logo {
            margin-top: 20px !important;
        }
    </style>
</head>

<body>
    <div class="container">
        @php
            $count = 0;
            $card_count = 0;
            $page = 1;
        @endphp

        @if($equipments->count())
            @foreach ($equipments as $equipment)
                @if($count == 3 )
                    @php
                        $count = 0;
                    @endphp
                    <div style="clear: both;"></div>
                @endif
                @php
                    $count++;
                @endphp
                <div class="card">
                    <table cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr class="card-header">
                                <td class="slogan card-header">NEVER<br>alone...<br>ALWAYS<br>by your side</td>
                                <td class="logo card-header"><img src="{{ asset('assets/1x/logo.png') }}" width="130px"></td>
                            </tr>
                            <tr>
                                <td class="card-body" colspan="2">
                                    <img class="company-logo" src="{{ asset('/uploads/qrcodes/'.$equipment->id.'.png') }}" width="130px">
                                    <p style="font-size: 12px;">{{ $equipment->sr_no }} <br> {{ $equipment->name }} <br> ({{ $equipment->model }})</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if($page == 9)
                    <div class="page-break"></div>
                    @php($page = 0)
                @endif
                @php($page++)
            @endforeach
        @else
        <div style="text-align: center;"><strong><span>No @lang('equicare.equipments')</span></strong></div>
        @endif
    </div>
</body>
</html>