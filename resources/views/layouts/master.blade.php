<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>

        <!-- META DATA -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="This is business site">
        <meta name="author" content="dgt.vifense.com">
        <meta name="keywords" content="web app admin template, bootstrap admin panel, bootstrap admin template, bootstrap dashboard, bootstrap panel, Application dashboard design, dashboard design template, dashboard jquery clean html, dashboard template theme, dashboard responsive ui, html admin backend template ui kit, html flat dashboard template, it admin dashboard ui">
        @include('layouts.head')
    </head>

    <body class="app sidebar-mini">
        <!-- GLOBAL-LOADER -->
        <div id="global-loader">
            <img src="{{URL::asset('assets/images/loader.svg')}}" class="loader-img" alt="Loader">
        </div>
        <!-- /GLOBAL-LOADER -->
        <!-- PAGE -->
         <div class="page">
         <div class="page-main">
            @include('layouts.app-sidebar')
            @include('layouts.mobile-header')
        <div class="app-content">
        <div class="side-app">
        <div class="page-header">
            @yield('page-header')
            @include('layouts.notification')
        </div>
            @yield('content')
            @include('layouts.sidebar')
            @include('layouts.footer')
        </div>
        </div>
            @include('layouts.footer-scripts')
    </body>
</html>
