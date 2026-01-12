<?php
// Enable these only during local debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/*
  tvseries.php

  Purpose:
  - Protected page (requires authentication)
  - TV series catalogue is rendered client-side by script.js via TMDB proxy calls
  - The hero/slider section is populated dynamically (title, year/genres, synopsis, cast, background image)
*/

session_start();

/*
  Access control:
  If the user is not logged in, redirect to login.php.
*/
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

// DB connection is required here mainly because the header/navbar may show user state.
require_once('config.php');

// Page SEO metadata
$description = "Mindflix TV shows page. Personal, non-commercial project to learn web development.";
$title = "TV Shows | Mindflix";
include("php/main-pages-header.php");
?>

<main>
    <!-- Slider (background image is set via JS on #dtl-page-slider) -->
    <section id="dtl-page-slider" class="slider slider-detail-pg position-relative" aria-label="Featured TV show">
        <article id="slider-detail-card" class="card position-absolute" aria-label="Featured TV show details">
            <div class="card-body">
                <h1 id="details-title" class="card-title my-3"></h1>
                <h2 id="details-date" class="my-3 h5"></h2>
                <p id="details-synopsis" class="card-text my-3"></p>
                <p id="details-cast" class="my-3"></p>
            </div>
        </article>
    </section>

    <!-- Catalogue (dynamic content injected by script.js) -->
    <section class="catalogue px-5 py-2" aria-label="TV shows catalogue sections">

        <section class="category category1 my-5" aria-label="Most popular TV shows">
            <h2 class="pb-3">Most Popular</h2>
            <div class="row row_for_api most-popular row1 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <section class="category category1 my-5" aria-label="Trending TV shows">
            <h2 class="pb-3">Trending now</h2>
            <div class="row row_for_api trending row1 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <section class="category category2 my-5" aria-label="Recently added TV shows">
            <h2 class="pb-3">Recently Added</h2>
            <div class="row row_for_api recently-added row2 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <section class="category category3 my-5" aria-label="TV sci-fi and fantasy">
            <h2 class="pb-3">TV Sci-Fi &amp; Fantasy</h2>
            <div class="row row_for_api scifi-and-fantasy row2 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <section class="category category4 my-5" aria-label="TV action and adventure">
            <h2 class="pb-3">TV Action and Adventure</h2>
            <div class="row row_for_api action-adventure row3 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <section class="category category5 my-5" aria-label="TV animation">
            <h2 class="pb-3">TV Animation</h2>
            <div class="row row_for_api animation row4 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <section class="category category6 my-5" aria-label="TV documentaries">
            <h2 class="pb-3">TV Documentaries</h2>
            <div class="row row_for_api documentary row5 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <!-- Note:
          The "Most popular" row exists on index.php as a mixed (movies + tv) section.
          On this page, script.js currently fetches TV-only rows (trending, recently added, sci-fi/fantasy, etc.).
        -->
    </section>
</main>

<?php require('php/main-pages-footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>

</html>