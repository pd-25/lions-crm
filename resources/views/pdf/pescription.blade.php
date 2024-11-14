<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lion's Club</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <link rel="shortcut icon" type="image/png" href="">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link href="{{ asset('pescription/css/style.css') }}" rel="stylesheet">
    {{-- <style>
        @media print {
            @page {
                size: A4;
                margin: 1in;
            }

            body {
                font-size: 12pt;
                color: black;
            }

            .no-print {
                display: none;
            }
        }
    </style> --}}
</head>

<body>

    <section class="color-black">
        <div class="bg-white container" style="solid;color:#1356a7;padding:5px;">
            <div class="row" style="margin-bottom:30px;">
                <div class="span-2">
                    <img src="{{ asset('pescription/images/logo.png') }}">
                </div>

                <div class="span-8 text-center">
                    <h1 style="color:#000000;font-size:50px;margin-bottom:10px;color:#1356a7;">'VISION' Eye Hospital
                    </h1>
                    <p class="head-cap">(Day Care Unit)</p>
                    <img src="{{ asset('pescription/images/logo-text.png') }}" style="margin-top:-30px;">
                    <p>135, Bowbazar Road, (Moti Roy Bandh), Nabadwip</p>
                    <p style="color:#000000;font-size:30px;margin-top:10px;"><strong>Donation For
                            {{ $bookingInfo?->amount }}/-</strong></p>
                </div>

                <div class="span-2 text-right">
                    <p><span style="font-weight:600;color:black;">Phone : 9732830564</span></p>
                    <p><span style="font-weight:600;color:black;"> 9800517218</span></p>
                </div>
            </div>
            <div class="row" style="border:1px #000000 solid;border-radius:30px;padding:30px;color:#000000;">
                <div class="span-12">
                    <p class="three-line"><span>OPD/ORC No<strong
                                class="line3"style="width:600px;">{{ $bookingInfo?->booking_id ?? ' ' }}</strong></span>
                        <span>Venue<strong
                                class="line3">{{ $bookingInfo?->pescription?->venue }}</strong></span><span>Date<strong
                                class="line3"
                                style="width:170px;">{{ \Carbon\Carbon::parse($bookingInfo?->created_at)->format('d M, Y h:i A') }}</strong></span>
                    </p>
                    <p class="single-line">Pationt's Name<strong class="full-line2">{{ $bookingInfo?->patient->name }}
                        </strong></p>
                    <p class="single-line">Father's/Husband Name<strong class="full-line2">
                            {{ $bookingInfo?->pescription?->guardians_name ?? ' ' }}</strong></p>
                    <p class="three-line"><span>Age<strong
                                class="line3">{{ $bookingInfo?->pescription?->age ?? '' }}</strong></span>
                        <span>Sex<strong
                                class="line3">{{ $bookingInfo?->pescription?->sex ?? '' }}</strong></span><span>Doctor/Optometrist<strong
                                class="line3"
                                style="width:538px;">{{ $bookingInfo?->pescription?->doctor }}</strong></span>
                    </p>
                    <p class="two-line"><span>Address<strong class="line3"
                                style="width:854px;">{{ $bookingInfo?->patient->address ?? ' ' }}</strong></span>
                        <span>Mobile<strong class="line3">{{ $bookingInfo?->patient->phone_number }}</strong></span>
                    </p>
                </div>
            </div>
            <div class="row" style="margin-top:30px;">
                <div class="span-6" style="color:#000000;">
                    <div style="border:1px #000000 solid;padding:15px;text-align:center;margin-bottom:20px;">
                        <p>Clinical Findings</p>
                    </div>
                    <div style="text-align:center;">
                        @if (!empty($bookingInfo?->pescription?->clinical_findings))
                            @foreach (json_decode($bookingInfo?->pescription?->clinical_findings) as $finding)
                                <p>{{ $finding }}
                                </p>
                            @endforeach
                        @endif
                        {{-- <p>Mat Cat <span
                                style="width: 20px;height: 22px;border: 1px #000000 solid;display: inline-block;text-align: center;margin-left: 1px;">L</span>
                        </p>
                        <p>Post + Operaiod<span
                                style="width: 20px;height: 22px;border: 1px #000000 solid;border-radius:60px;display: inline-block;text-align: center;margin-left: 10px;">R</span><span
                                style="width: 20px;height: 22px;border: 1px #000000 solid;border-radius:60px;display: inline-block;text-align: center;margin-left: 10px;">L</span>
                        </p> --}}
                    </div>
                </div>
                <div class="span-6" style="color:#000000;">
                    <div style="border:1px #000000 solid;padding:15px;text-align:center;margin-bottom:20px;">
                        <p>Advice</p>
                    </div>
                    <div style="text-align:center;">
                        @if (!empty($bookingInfo?->pescription?->advice))
                            @foreach (json_decode($bookingInfo?->pescription?->advice) as $advice)
                                <p>{{ $advice }}</p>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
