<html>
    <head>
        <title>ValutazioneLPI - @yield('title')</title>
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <link href="/resources/MDB/css/bootstrap.min.css" rel="stylesheet">
        <link href="/resources/MDB/css/mdb.min.css" rel="stylesheet">
        <link href="/resources/style.css" rel="stylesheet">
        <link href="/resources/toastr/toastr.css" rel="stylesheet">

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <!-- Cookies JS -->
        <script src="/resources/CookieJS/js.cookie.min.js"></script>
        <!-- Validazione Frontend -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js" integrity="sha256-H7bYoAw738qgns17P+7wWt77AfnEh7yCJMQGUCNcxQA=" crossorigin="anonymous"></script>
        <!-- Toastr notification library -->
        <script type="text/javascript" src="/resources/toastr/toastr.js"></script>
</head>
    </head>
    <body>
        @section('header')
        <header>
            <nav class="navbar fixed-top navbar-expand-lg navbar-dark light-blue lighten-2 scrolling-navbar">
            <a class="navbar-brand" href="{{ url('') }}"><strong>Valutazione LPI</strong></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarLogin" aria-controls="navbarLogin" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarLogin">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('') }}">Login <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('register') }}">Registrati</a>
                        </li>                       
                    </ul>
                </div>
            </nav>
        </header>
        @show

        <div class="container">
            @yield('content')
        </div>

        @section('footer')
        <footer class="page-footer light-blue lighten-2 fixed-bottom">

            <div class="footer-copyright text-center py-3 text-white">
                Valutazione LPI - 2020
            </div>
          
        </footer>
        @show

        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="/resources/MDB/js/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="/resources/MDB/js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="/resources/MDB/js/mdb.min.js"></script>
    </body>
</html>