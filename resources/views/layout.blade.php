<head>
    <title>Index</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/icon_manage.png">
    <link href="/css/external/bootstrap-5.0.1/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!--<link rel="stylesheet" href="/css/external/font-awesome.min.css">-->
    <link rel="stylesheet" href="/css/external/jquery-ui.css">
    <link href="/css/layout.css" rel="stylesheet" >
    <script src="/js/external/popper.min.js" ></script>
    <script src="/js/external/bootstrap-5.0.1/bootstrap.min.js"></script>
    <script src="/js/external/jquery-3.5.1.min.js"></script>
    <script src="/js/external/jquery-ui.js"></script>
    <script src="/js/external/pagination.min.js"></script>
    <script src="/js/index.js" ></script>
    <script src="/js/autocomplete.js"></script>
    <script src="/js/search.js"></script>
    <script src="/js/pagination.js"></script>

</head>
<body>

    @section('navbar')
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/search">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/list">Listas</a>
                    </li>  
                    <li class="nav-item">
                        <a class="nav-link" href="/index/reset">Resetar</a>
                    </li>   
                     <li class="nav-item">
                        <a class="nav-link" href="/document/insert">Criar Documento</a>
                    </li>   
                </ul>
            </div>
        </nav>
    @show

    <div class='container'>
	   @yield('content-body')
    </div>

    <div class='container'>
       @yield('content-list')
    </div>

    <div class='container'>
       @yield('content-modal')
    </div>
</body>




