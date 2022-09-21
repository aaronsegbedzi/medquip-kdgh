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

        @media print {
            div {
                break-inside: avoid;
            }
        }

        .container:after {
            content: "";
            display: table;
            clear: both;
        }

        .card {
            float: left;
            width: 33.33%;
            padding: 10px;
            /* Should be removed. Only for demonstration */
        }

        .card>span {
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
        @php
        $count = 0;
        $card_count = 0;
        $page = 1;
        $t_page = 12;
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
            <table style="width: 100%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr style="background: rgb(255 128 57);">
                        <td style="text-align: left !important; font-weight: 600; color: #FFF; vertical-align: middle; font-size: 8px; padding: 8px;">NEVER<br>alone...<br>ALWAYS<br>by your side</td>
                        <td style="text-align: right !important; padding-right: 10px !important;"><img style="vertical-align: middle;" src="{{ asset('assets/1x/logo.png') }}" width="100px"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center !important; padding: 20px;">
                            <img src="{{ asset('/uploads/qrcodes/'.$equipment->id.'.png') }}" width="120px">
                            <h5>{{ $equipment->sr_no }} <br> {{ $equipment->name }} <br> ({{ $equipment->model }})</h5>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @if($page % 12 == 0)
        <div class="page-break"></div>
        @endif
        @php($page = 0)
        @php($page++)
        @endforeach
        @else
        <div style="text-align: center;"><strong><span>No equipments</span></strong>
        </div>
        @endif
    </div>
</body>

</html>