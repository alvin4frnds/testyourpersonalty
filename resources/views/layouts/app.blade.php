<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Test Your Personality</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    @if(isset($record))
        <meta property="og:title" content="What do you think about '{{ $record->name }}'" />
    @else
        <meta property="og:title" content="Know your personalty." />
    @endif
    <meta property="og:description" content="How well do you know {{ isset($record) ? $record->name : "your personalty" }}? Take this simple quiz and find out. Know yourself.">
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ asset('og-image.png') }}"/>
    <meta property="og:site_name" content="{{ env("APP_NAME") }}"/>

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/scrolling-nav.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/loading-spinner.css') }}">

    <style>
        body {
            height: 100%;
        }

        .col-md-12.col-lg-12.col-md-offset-1.col-lg-offset-1 {
            margin-top: 30px;
            margin-bottom: 30px;
        }
    </style>
</head>

<body id="page-top">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="{{ url('/') }}">Test Your Personalty</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<br><br><br>
@yield('content')
<br><br><br>

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2017</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Plugin JavaScript -->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom JavaScript for this theme -->
<script src="{{ asset('js/scrolling-nav.js') }}"></script>

</body>

</html>
