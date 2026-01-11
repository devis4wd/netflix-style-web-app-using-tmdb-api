<?php

//Riabilitare queste due righe per vedere errori se serve fare debugging
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// session_start() va sempre all'inizio del codice PHP
session_start();

//Controlliamo se utente è già loggato. Se NON lo è: l'utente NON potrà vedere questa pagina ma dovrà prima loggarsi.
//Quindi redirect a pagina login.php
//Se invece esiste una sessione $_SESSION['loggedin']) e il suo stato è TRUE (= se si è già loggato) allora riuscirà a vedere pagina details.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
    header('location: login.php');
    exit();
}

//Includo file di connessione DB
require_once('config.php');


//Per header pagina + SEO dinamico titolo e descrizione pagina in header
$description = "Mindflix detail page, where you can watch your favorite movie or TV series and see all its details. Just a personal, non-commercial project to learn web dev";
//Titolo della pagina determinato da operatore ternario in base a query string presente in url
$title = $_GET['movie-title'] ? $_GET['movie-title'] : $_GET['tvseries-title'] . " | Mindflix";

/* $title = ($_GET['if-tvseries-title'] ?? "") !== "undefined" ? $_GET['if-tvseries-title'] : ($_GET['if-movie-title'] ?? "") . " | Mindflix";  */
include("php/main-pages-header.php");
?>

<div id="dtl-page-slider" class="slider slider-detail-pg position-relative">
    <div id="slider-detail-card" class="card position-absolute">
        <div class="card-body">
            <h1 id="details-title" class="card-title my-3"></h1>
            <h5 id="details-date" class="my-3"></h5>
            <p id="details-synopsis" class="card-text my-3"></p>
            <p id="details-cast" class="my-3"></p>
        </div>
    </div>
</div>

<div class="catalogue px-5 py-2">
    <div class="category category1 my-5">
        <h2 class="pb-3">Video Clip</h2>
        <div class="row row1 py-3 g-3 justify-content-start">

            <!--  Esempio di uno dei diversi div che verrà innestato tramite JS e chiamate API in backend:
            
                <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2">
                    <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/6EZCBSsBxko?si=My37GpMT9i20d7uj" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>

                            
               -->
        </div>
    </div>
    <div class="category category2 my-5">
        <h2 class="pb-3">More Like This</h2>
        <div class="row row2 py-3 g-3 justify-content-start">

            <!-- Esempio di uno dei diversi div che verrà innestato tramite JS e chiamate API in backend:
            
                <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2">
                    <a href="#"><img src="img/hawaii-five.png"alt=""></a>
                </div>
               -->

        </div>
    </div>
</div>

<!-- Footer -->
<?php
require('php/main-pages-footer.php');
?>


</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="js/script.js"></script>

</html>