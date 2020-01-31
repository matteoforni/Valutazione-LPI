<html>
    <head>
        <title>ValutazioneLPI - @yield('title')</title>
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <link href="/resources/MDB/css/bootstrap.min.css" rel="stylesheet">
        <link href="/resources/MDB/css/mdb.min.css" rel="stylesheet">
</head>
    </head>
    <body>
        @section('header')
            This is the header
        @show

        <div class="container">
            @yield('content')
        </div>

        @section('footer')
            This is the footer.
        @show


        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="/resources/MDB/js/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="/resources/MDB/js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="/resources/MDB/js/mdb.min.js"></script>
    </body>
</html>