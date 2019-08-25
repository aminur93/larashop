<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page')</title>

    <!-- Bootstrap core CSS -->
    <link href="/front/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/front/css/heroic-features.css" rel="stylesheet">

    @stack('css')

</head>

<body>
@include('front.layouts.navbar')


<!-- Page Content -->
<div class="container">
    @yield('content')
</div>
<!-- /.container -->


<!-- Bootstrap core JavaScript -->
<script src="/front/vendor/jquery/jquery.min.js"></script>
<script src="/front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

@stack('js')

</body>

</html>
