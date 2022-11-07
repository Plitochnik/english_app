<!DOCTYPE html>
<html style="font-size: 16px;" lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Business Center">
    <meta name="description" content="">
    <title>English app</title>
    <link rel="stylesheet" href="{{ asset('nicepage_layout/css/nicepage.css') }}" media="screen">
{{--    <link rel="stylesheet" href="{{ asset('nicepage_layout/css/Главная.css') }}" media="screen">--}}
    <script class="u-script" type="text/javascript" src="{{ asset('jquery.js') }}"></script>
    <script class="u-script" type="text/javascript" src="{{ asset('nicepage.js') }}"></script>
    <meta name="generator" content="Nicepage 4.17.10, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <link id="u-page-google-font" rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Mulish:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite('resources/css/app.css')


    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": ""
}


    </script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Главная">
    <meta property="og:type" content="website">


</head>
{{--<body class="u-body u-xl-mode" data-lang="ru">--}}

{{--<header class="u-custom-color-1 u-header" id="sec-0683" data-animation-name="" data-animation-duration="0"--}}
{{--        data-animation-delay="0" data-animation-direction="">--}}
{{--    <div class="u-align-left u-clearfix u-sheet u-sheet-1">--}}
{{--        <a href="{{ route('test') }}"--}}
{{--           class="u-btn u-btn-round u-button-style u-custom-font u-hover-palette-1-light-1 u-palette-1-base u-radius-50 u-btn-1">--}}
{{--            Start test</a>--}}
{{--        <a href="{{ route('share') }}"--}}
{{--           class="u-border-2 u-border-hover-palette-1-base u-border-palette-1-base u-btn u-btn-round u-button-style u-hover-palette-1-base u-none u-radius-50 u-btn-2">Share</a>--}}
{{--    </div>--}}
{{--</header>--}}


    @yield('form')



<div id="app">

    @yield('header')
</div>



