<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LIONS CLUB CRM</title>

    <!-- Styles -->
    <style>
        body {
            background-image: url("{{ asset('lions.jpg') }}");
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .buttons a,
        .buttons button {
            background-color: #fff;
            color: #333;
            padding: 1rem 2rem;
            text-decoration: none;
            border-radius: 0.5rem;
            font-size: 1.2rem;
            font-weight: bold;
            transition: background-color 0.3s ease;
            display: flex;
        }

        .buttons a:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="buttons">


        @if (auth()->guard('admin')->check())
            <button type="button" onclick="window.location='{{ route('admin.dashboard') }}'">Go to admin
                panel</button>
        @elseif(auth()->check())
            <button type="button" onclick="window.location='{{ route('employee.register-bookings.index') }}'">Go to
                employee
                panel</button>
        @else
            <a href="{{ route('admin.showlogin') }}">Admin Login</a>
            <a href="{{ route('login') }}">Employee Login</a>
        @endif
    </div>

</body>

</html>
