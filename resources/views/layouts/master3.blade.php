<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <!-- META DATA -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="keywords" content="web app admin, admin panel">
        @include('layouts.head')
    </head>

    <body class="login-img" style="background-color: #fff">
        @yield('content')
        @include('layouts.footer-scripts')
    </body>
</html>
