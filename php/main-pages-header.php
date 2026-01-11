<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Attivazione di Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/favicon_io/favicon.ico" type="image/x-icon">
    <meta name="author" content="Devis Vallotto">
    <meta name="copyright" content="Copyright 2024 Devis Vallotto - All Rights Reserved">
    <meta name="description" content="<?= $description ?>">
    <title><?= $title ?></title>
</head>

<body>
    <header id="flexible-header" class="px-5 py-2"> <!-- aggiungi fixed-top a style css -->

        <!--     Desktop navbar -->
        <nav id="desktop-navbar" class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand me-5" href="index.php">
                    <img src="img/logo.png" alt="Mindflix logo | Home">
                </a>
                <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button> -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav my-4 my-lg-0 me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active ps-4 text-end" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-4 text-end" href="tvseries.php">TV Shows</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-4 text-end" href="movies.php">Movies</a>
                        </li>
                        <li class="nav-item"> <!-- Nascosto in breakpoint medium per non incasinate navbar -->
                            <a class="nav-link ps-4 text-end " href="#">Latest</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-4 text-end" href="#">My List</a>
                        </li>
                    </ul>
                    <form class="d-flex my-4 my-lg-0 search-bar-desktop justify-content-end" role="search">
                        <input class="form-control me-2 search-input" type="search" placeholder="Search movie or tv series"
                            aria-label="Search">
                        <button id="src-nav-button-desktop" class="btn p-auto" type="submit"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg></button>
                    </form>
                    <ul class="navbar-nav my-4 my-lg-0 mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link bell-link active ps-4 text-end" aria-current="page" href="#"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-bell-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />
                                </svg>
                            </a>
                        </li>
                        <li class="nav-item">
                        <li class="nav-item dropdown position-relative">
                            <button id="js-dropdown-acc-button" class="btn btn-secondary dropdown-toggle dropdown-acc-button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= isset($_SESSION['username']) ? $_SESSION['username'] : 'Account' ?>
                            </button>
                            <ul class="dropdown-menu py-1 px-3">
                                <li><a class="dropdown-item " href="<?= isset($_SESSION['username']) ? 'account-settings.php' : 'login.php' ?>"><?= isset($_SESSION['username']) ? 'Settings' : 'Sign In' ?></a></li>
                                <li><a class="dropdown-item <?= isset($_SESSION['username']) ? '' : 'hide' ?>" href="logout.php">Log out</a></li>
                            </ul>
                        </li>
                        <!-- Se utente loggato e username salvato in Supervariabile globale di sessione: allora fammi vedere suo nome e link riporta a pagina account-settings.php. 
                            Altrimenti: fammi vedere scritta Sign In e link porta a pagina login.php.  -->
                        <!-- <a class="nav-link ps-3 text-end" href="</a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>

        <!--Mobile navbar  -->
        <nav id="mobile-navbar" class="navbar navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand me-5" href="index.php">
                    <img src="img/logo.png" alt="Mindflix logo | Home">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <!-- <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dark offcanvas</h5> -->
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="tvseries.php">TV Shows</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="movies.php">Movies</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Latest</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">My List</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= isset($_SESSION['username']) ? $_SESSION['username'] : 'Account' ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item " href="<?= isset($_SESSION['username']) ? 'account-settings.php' : 'login.php' ?>"><?= isset($_SESSION['username']) ? 'Settings' : 'Sign In' ?></a></li>
                                    <li><a class="dropdown-item <?= isset($_SESSION['username']) ? '' : 'hide' ?>" href="logout.php">Log out</a></li>
                                    <!-- <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                                </ul>
                            </li>
                        </ul>
                        <form class="d-flex mt-3 search-bar-mobile" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button id="search-btn-mobile" class="btn btn-success" type="submit"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                </svg></button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>