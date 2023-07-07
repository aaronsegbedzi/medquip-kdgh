<!DOCTYPE html>
<html>

<head>
    <title>@lang('equicare.qr_sticker_generate')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/Lato/latofonts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/Lato/latostyle.css') }}">
    <style type="text/css" media="all">
        * {
            box-sizing: border-box;
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
            width: 25%;
            margin-right: 2px;
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
            font-family: 'LatoWeb' !important;
            font-style: italic !important;
            font-weight: normal !important;
            text-rendering: optimizeLegibility !important;
            line-height: 7px !important;
        }

        .logo {
            text-align: center !important;
            padding: 8px !important;
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
        <p style="text-align: center; font-size: 20px !important;">{{ $hospital->name }}</p>
        @php
            $count = 0;
            $card_count = 0;
            $page = 1;
        @endphp

        @if($equipments->count())
            @foreach ($equipments as $equipment)
                @if($count == 4 )
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
                                <!-- <td class="slogan card-header">NEVER<br>alone...<br>ALWAYS<br>by your side</td> -->
                                <td colspan="2" class="logo card-header"><img src="{{ asset('assets/1x/logo.png') }}" width="120px"></td>
                            </tr>
                            <tr>
                                <td class="card-body" colspan="2">
                                    <img class="company-logo" src="{{ asset('/uploads/qrcodes/'.$equipment->id.'.png') }}" width="130px">
                                    <p class="size20" style="margin-top: 10px;">
                                        <span style="font-family: 'LatoWebHeavy';">{{ $equipment->sr_no }}</span>
                                        <br>
                                        <span style="font-family: 'LatoWebSemibold';" class="size12">Hotline: {{ env('HOTLINE_NUMBER') }}</span>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if($page == 12)
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