<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Skillmate - Your IT Services Hub</title>
    <link rel="icon" href="{{ asset('assets/icons/skillmate-logo.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white">
    @yield('app-content')
</body>

</html>
