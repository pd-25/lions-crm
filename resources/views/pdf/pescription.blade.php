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
    <link href="{{asset('pescription/css/style.css')}}" rel="stylesheet">
    <style>
        @media print {
        @page {
            size: A4 portrait;
            margin: 0.5in;
        }

        body {
            font-size: 10pt;
            color: black;
            margin: 0;
        }

   

    
    }
    </style>
</head>

<body>

    <section class="color-black">
        <div class="bg-white container" style="solid;color:#1356a7;padding:5px;">
            <div class="row" style="margin-bottom:0px;">
                <div class="span-2">
                    <img src="{{asset('pescription/images/logo.png')}}" style="width:150px;">
                </div>

                <div class="span-8 text-center">
                    <h1 style="color:#000000;font-size:30px;line-height:30px;margin-bottom:3px;color:#1356a7;">'VISION'
                        Eye Hospital</h1>
                    <p class="head-cap" style="font-size:16px;">(Day Care Unit)</p>
                    <img src="{{asset('pescription/images/logo-text.png')}}" style="margin-top:-8px;width:320px;">
                    <p style="font-size:16px;">135, Bowbazar Road, (Moti Roy Bandh), Nabadwip</p>
                    <p style="color:#000000;font-size:20px;margin-top:0px;"><strong>Donation For {{$bookingInfo?->amount}}/-</strong></p>
                </div>

                <div class="span-2 text-right">
                    <p><span style="font-weight:600;color:black;">Phone : 8250593472</span></p>
                    <p><span style="font-weight:600;color:black;"> 9800517218</span></p>
                </div>
            </div>
            <div class="row" style="border:1px #000000 solid;border-radius:30px;padding:15px 30px;color:#000000;">
                <div class="span-12">
                    <p class="three-line"><span>OPD/ORC No<strong class="line3"style="width:180px;">{{ $bookingInfo?->booking_id ?? ' ' }}</strong></span>
                        <span>Venue<strong class="line3"style="width:120px;">{{ $bookingInfo?->pescription?->venue }}</strong></span><span>Date<strong
                                class="line3" style="width:100px;">{{ \Carbon\Carbon::parse($bookingInfo?->created_at)->format('d M, Y h:i A') }}</strong></span></p>
                    <p class="single-line"><span>Pationt's Name</span><strong class="full-line2">{{ $bookingInfo?->patient->name }} </strong></p>
                    <p class="single-line"><span>Father's/Husband Name</span><strong class="full-line2"> {{ $bookingInfo?->pescription?->guardians_name ?? ' ' }}</strong></p>
                    <p class="three-line"><span>Age<strong class="line3"style="width:100px;">{{ $bookingInfo?->pescription?->age ?? '' }}</strong></span>
                        <span>Sex<strong
                                class="line3"style="width:100px;">{{ $bookingInfo?->pescription?->sex ?? '' }}</strong></span><span>Doctor/Optometrist<strong
                                class="line3" style="width:200px;">{{ $bookingInfo?->pescription?->doctor }}</strong></span></p>
                    <p class="two-line"><span>Address<strong class="line3" style="width:330px;">{{ $bookingInfo?->patient->address ?? ' ' }}</strong></span>
                        <span>Mobile<strong class="line3"style="width:150px;">{{ $bookingInfo?->patient->phone_number }}</strong></span></p>
                </div>
            </div>
            <div class="row" style="margin-top:0px;">
                <div class="span-6" style="color:#000000;">
                    <div style="border:1px #000000 solid;padding:0;text-align:center;margin-bottom:0;">
                        <p><b>Clinical Findings</b></p>
                    </div>
                    <div style="text-align:center;">
                        <p>Mat Cat <span
                                style="width: 20px;height: 22px;border: 1px #000000 solid;display: inline-block;text-align: center;margin-left: 10px;">R</span>
                        </p>
                        <p>Mat Cat <span
                                style="width: 20px;height: 22px;border: 1px #000000 solid;display: inline-block;text-align: center;margin-left: 1px;">L</span>
                        </p>
                        <p>Post + Operaiod<span
                                style="width: 20px;height: 22px;border: 1px #000000 solid;border-radius:60px;display: inline-block;text-align: center;margin-left: 10px;">R</span><span
                                style="width: 20px;height: 22px;border: 1px #000000 solid;border-radius:60px;display: inline-block;text-align: center;margin-left: 10px;">L</span>
                        </p>
                    </div>
                </div>
                <div class="span-6" style="color:#000000;">
                    <div style="border:1px #000000 solid;padding:0;text-align:center;margin-bottom:0;">
                        <p><b>Advice</b></p>
                    </div>
                    <div style="text-align:center;">
                        <p>B/S(P.P/Fasting/R)</p>
                        <p>B/P</p>
                        <p>Tonometry</p>
                        <p>SAC Text</p>
                        <p>E.C.G</p>
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
