<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Link necessario per rendere visibili le icone <i> di Bootstrap quando le inserisco nella pagina account-settings.php: -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/favicon_io/favicon.ico" type="image/x-icon">
    <meta name="author" content="Devis Vallotto">
    <meta name="copyright" content="Copyright 2024 Devis Vallotto - All Rights Reserved">
    <meta name="description" content="<?= $description ?>">
    <title><?= $title ?></title>
</head>

<body>
    <header class="px-5 py-2 bg-transparent"> <!-- aggiungi fixed-top a style css -->
        <nav id="login-navbar" class="navbar bg-transparent login-navbar navbar-expand-lg">
            <div class="container-fluid bg-transparent d-flex justify-content-between">
                <a class="navbar-brand me-5" href="index.php">
                    <img src="img/logo.png" alt="Mindflix logo | Home">
                </a>


                <div class="flex-grow-0" id="navbarSupportedContent">
                    <ul class="navbar-nav my-lg-0 mb-2 mb-lg-0">
                        <li class="nav-item">
                        <li class="nav-item dropdown align-self-end ">
                            <button id="js-dropdown-acc-button" class="btn btn-secondary dropdown-toggle dropdown-acc-button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= isset($_SESSION['username']) ? $_SESSION['username'] : 'Account' ?>
                            </button>
                            <ul class="dropdown-menu py-1 px-3">
                                <li><a class="dropdown-item " href="<?= isset($_SESSION['username']) ? 'account-settings.php' : 'login.php' ?>"><?= isset($_SESSION['username']) ? 'Account settings' : 'Sign In' ?></a></li>
                                <li><a class="dropdown-item <?= isset($_SESSION['username']) ? '' : 'hide' ?>" href="logout.php">Log out</a></li>
                            </ul>
                        </li>
                        <!-- Se utente loggato e username salvato in Supervariabile globale di sessione: allora fammi vedere suo nome e link riporta a pagina user-page.php. 
                            Altrimenti: fammi vedere scritta Sign In e link porta a pagina login.php.  -->
                        <!-- <a class="nav-link ps-3 text-end" href="</a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>
    </header>