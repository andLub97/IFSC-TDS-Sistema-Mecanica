<!doctype html>
<html lang="pt-BR">

<head>
    <title>Sistema de Mecânica</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="./css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="./css/fontawesome/fontawesome.min.css" rel="stylesheet">
    <link href="./css/fontawesome/brands.min.css" rel="stylesheet">
    <link href="./css/fontawesome/solid.min.css" rel="stylesheet">
    <link href="./css/sistema/landpage.css" rel="stylesheet">
</head>

<body>
    <header id="topo">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Mecânica</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php"><i class="fas fa-home"></i>&nbsp;Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php"><i class="fas fa-id-card"></i>&nbsp;Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <!-- Carrossel de itens -->
        <div id="carrossel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carrossel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carrossel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carrossel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <rect width="100%" height="100%" fill="#777" />
                    </svg>

                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1>Cadastro de Materiais</h1>
                            <p>Controle os materiais do modelo</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <rect width="100%" height="100%" fill="#777" />
                    </svg>

                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Eletrodos</h1>
                            <p>Eletrodos associados ao material</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <rect width="100%" height="100%" fill="#777" />
                    </svg>

                    <div class="container">
                        <div class="carousel-caption text-end">
                            <h1>Pontos</h1>
                            <p>Pontos do gráfico</p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carrossel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carrossel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="visually-hidden">Próximo</span>
            </button>
        </div>
        <!-- Fim carrossel de itens -->
        <!-- ================================================== -->
        <!-- Conteúdo da página -->
        <div class="container marketing">
            <!-- Três colunas complementares com os dados do carrossel -->
            <div class="row">
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Cadastro de Materiais</title>
                        <rect width="100%" height="100%" fill="#00FF00" />
                    </svg>
                    <h2>Cadastro de Materiais</h2>
                    <p>Controle os materiais do modelo</p>
                </div>
                <!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Eletrodos</title>
                        <rect width="100%" height="100%" fill="#FFFF00" />
                    </svg>
                    <h2>Eletrodos</h2>
                    <p>Eletrodos associados ao material</p>
                </div>
                <!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Pontos</title>
                        <rect width="100%" height="100%" fill="#FF0000" />
                    </svg>

                    <h2>Pontos</h2>
                    <p>Pontos do gráfico</p>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- Fim três colunas -->

            <hr class="featurette-divider">

            <!-- Restante conteúdo -->
            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading">
                        Um novo sistema, <span class="text-muted">para o controle de simulação de usinagem.</span>
                    </h2>
                    <p class="lead">Controle a simulação de forma efetiva!</p>
                </div>
                <div class="col-md-5">
                    <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Sysconel</title>
                        <rect width="100%" height="100%" fill="#eee" />
                        <text x="50%" y="50%" fill="#aaa" dy=".3em">Sysconel</text>
                    </svg>
                </div>
            </div>
            <!-- Fim restante conteúdo -->
        </div>
        <!-- Fim conteúdo da página -->
    </main>
    <footer class="container">
        <hr class="featurette-divider">
        <p class="float-end">
            <a href="#topo">Voltar ao topo</a>
        </p>
        <p>
            &copy; 2021–<script>
                document.write(new Date().getFullYear())
            </script>
            | Sysconel - O Seu Sistema de Simulação
        </p>
        <div class="text-center">
            <p>
                <img src="./imagens/cc-by-nc_icon_100.svg.png" title="Creative Commons" />
            </p>
        </div>
    </footer>

    <script src="./js/jquery/jquery.min.js"></script>
    <script src="./js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="./js/fontawesome/fontawesome.min.js"></script>
</body>

</html>