<?php
//Riabilitare queste due righe per vedere errori se serve fare debugging
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// session_start() va sempre all'inizio del codice PHP
session_start();

//Controlliamo se utente è già loggato. Se NON lo è: l'utente NON potrà vedere questa pagina ma dovrà prima loggarsi.
//Quindi redirect a pagina login.php
//Se invece esiste una sessione $_SESSION['loggedin']) e il suo stato è TRUE (= se si è già loggato) allora riuscirà a vedere pagina movies.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
    header('location: login.php');
    exit();
}

//Includo file di connessione DB
require_once('config.php');


//Per header pagina + SEO dinamico titolo e descrizione pagina in header
$description = "Mindflix homepages, all the movies and TV series you can think about. Just a personal, non-commercial project to learn web dev";
$title = "TV Shows | Mindflix";
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


<!-- NOTE: il codice commentato qui sotto verrà sostituito in modo dinamico tramite JS e chiamate API -->
<div class="catalogue px-5 py-2">
    <div class="category category1 my-5">
        <h2 class="pb-3">Most popular</h2>
        <div class="row row_for_api most-popular row1 py-3 g-3">

            <!--  Esempio di uno dei diversi div che verrà innestato tramite JS e chiamate API in backend:
            
            <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2"><a href="#"><img
                            src="img/13-reasons-why.png" alt=""></a></div>
            -->

        </div>
    </div>
    <div class="category category2 my-5">
        <h2 class="pb-3">Trending now</h2>
        <div class="row row_for_api trending row1 py-3 g-3">

            <!--  Esempio di uno dei diversi div che verrà innestato tramite JS e chiamate API in backend:
            
            <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2"><a href="#"><img
                            src="img/13-reasons-why.png" alt=""></a></div>
            -->

        </div>
    </div>
    <div class="category category3 my-5">
        <h2 class="pb-3">Recently Added</h2>
        <div class="row row_for_api recently-added row2 py-3 g-3">

            <!--  Esempio di uno dei diversi div che verrà innestato tramite JS e chiamate API in backend:
            
            <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2"><a href="#"><img
                            src="img/13-reasons-why.png" alt=""></a></div>
            -->

        </div>
    </div>
    <div class="category category3 my-5">
        <h2 class="pb-3">TV Sci-Fi & Fantasy</h2>
        <div class="row row_for_api scifi-and-fantasy row2 py-3 g-3">

            <!--  Esempio di uno dei diversi div che verrà innestato tramite JS e chiamate API in backend:
            
            <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2"><a href="#"><img
                            src="img/13-reasons-why.png" alt=""></a></div>
            -->

        </div>
    </div>
    <div class="category category4 my-5">
        <h2 class="pb-3">TV Action and Adventure</h2>
        <div class="row row_for_api action-adventure row3 py-3 g-3">

            <!--  Esempio di uno dei diversi div che verrà innestato tramite JS e chiamate API in backend:
            
                <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2"><a href="#"><img
                            src="img/13-reasons-why.png" alt=""></a></div>
                -->

        </div>
    </div>
    <div class="category category5 my-5">
        <h2 class="pb-3">TV Animation</h2>
        <div class="row row_for_api animation row4 py-3 g-3">

            <!--  Esempio di uno dei diversi div che verrà innestato tramite JS e chiamate API in backend:
            
                <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2"><a href="#"><img
                            src="img/13-reasons-why.png" alt=""></a></div>
                -->

        </div>
    </div>
    <div class="category category6 my-5">
        <h2 class="pb-3">TV Documentaries</h2>

        <div class="row row_for_api documentary row5 py-3 g-3">

            <!--  Esempio di uno dei diversi div che verrà innestato tramite JS e chiamate API in backend:
            
                <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2"><a href="#"><img
                            src="img/13-reasons-why.png" alt=""></a></div>
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