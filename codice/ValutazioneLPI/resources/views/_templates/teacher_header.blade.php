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
        <link href="/resources/MDB/css/addons/datatables.min.css" rel="stylesheet">
        <link href="/resources/toastr/toastr.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />


        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <!-- Cookies JS -->
        <script src="/resources/CookieJS/js.cookie.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="/resources/MDB/js/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="/resources/MDB/js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="/resources/MDB/js/mdb.min.js"></script>
        <!-- Datatables -->
        <script type="text/javascript" src="/resources/MDB/js/addons/datatables.min.js"></script>
        <!-- Toastr notification library -->
        <script type="text/javascript" src="/resources/toastr/toastr.js"></script>
        <!-- Fontawesome -->
        <script src="https://kit.fontawesome.com/56cb13ebcf.js" crossorigin="anonymous"></script>
        <!-- Select2 select library -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

</head>
    </head>
    <body>
        @section('header')
        <header>
            <nav class="navbar fixed-top navbar-expand-lg navbar-dark light-blue lighten-2 scrolling-navbar">
            <a class="navbar-brand" href="{{ url('teacher') }}"><strong>Valutazione LPI</strong></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-flex justify-content-end" id="navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a id="homeLink" class="nav-link">Pagina iniziale</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" onclick="logout()">Logout</a>
                        </li>                       
                    </ul>
                </div>
            </nav>
        </header>
        @show

        <div class="container">
            @yield('content')
        </div>
        <script>
            $(document).ready(function() {          
                $("#homeLink").attr('href', "{{ url('teacher') }}");
            });

            /**
             * Funzione che consente di uscire dal proprio account
             */
            function logout(){
                Cookies.remove('token');
                window.location = "{{ url('') }}";
            }
        </script>
        @section('footer')
        <footer class="mt-5 page-footer light-blue lighten-2">

            <div class="footer-copyright text-center py-3 text-white">
                Valutazione LPI - 2020
            </div>
          
        </footer>
        @show
    </body>
</html>