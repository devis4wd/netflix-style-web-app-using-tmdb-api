<?php
//Riabilitare queste due righe per vedere errori se serve fare debugging
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// session_start() va sempre all'inizio del codice PHP
session_start();

//Per connessione a DB e gestione login utenti
require_once('config.php');


//Per header pagina + SEO dinamico titolo e descrizione pagina in header
$description = "Mindflix homepages, all the movies and TV series you can think about. Just a personal, non-commercial project to learn web dev";
$title = "Homepage | Mindflix";
include("php/main-pages-header.php");
?>



<div class="slider position-relative">
    <div class="card position-absolute">
        <img src="img/the-batman.png" class="card-img-top" alt="The Batman Logo">
        <div class="card-body">
            <h1 class="card-title">The Batman</h1>
            <p class="card-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
        </div>
    </div>
    <!-- Possibile alternativa a iframe youtube per video in slider:

        <video autoplay muted controls>
                <source src="video/slider-preview-video.mp4" type="video/mp4">
            </video> -->

    <iframe width="100%" height="100%"
        src="https://www.youtube-nocookie.com/embed/mqqft2x_Aa4?si=98cddx8kIs7Xcps-"
        title="YouTube video player" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
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
        <h2 class="pb-3">TV Sci-fi & Fantasy</h2>
        <div class="row row_for_api scifi-and-fantasy row2 py-3 g-3">

            <!--  Esempio di uno dei diversi div che verrà innestato tramite JS e chiamate API in backend:
            
            <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2"><a href="#"><img
                            src="img/13-reasons-why.png" alt=""></a></div>
            -->

        </div>
    </div>
    <div class="category category4 my-5">
        <h2 class="pb-3">TV and Movies Action and Adventure</h2>
        <div class="row row_for_api action-adventure row3 py-3 g-3">

            <!--  Esempio di uno dei diversi div che verrà innestato tramite JS e chiamate API in backend:
            
                <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2"><a href="#"><img
                            src="img/13-reasons-why.png" alt=""></a></div>
                -->

        </div>
    </div>
    <div class="category category5 my-5">
        <h2 class="pb-3">TV and Movies Animation</h2>
        <div class="row row_for_api animation row4 py-3 g-3">

            <!--  Esempio di uno dei diversi div che verrà innestato tramite JS e chiamate API in backend:
            
                <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2"><a href="#"><img
                            src="img/13-reasons-why.png" alt=""></a></div>
                -->

        </div>
    </div>
    <div class="category category6 my-5">
        <h2 class="pb-3">TV and Movies Documentaries</h2>

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