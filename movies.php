<?php
// Enable these only during local debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/*
  movies.php

  Purpose:
  - Protected page (requires authentication)
  - Movies catalogue is rendered client-side by script.js via TMDB proxy calls
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
$description = "Mindflix movies page. Personal, non-commercial project to learn web development.";
$title = "Movies | Mindflix";
include("php/main-pages-header.php");
?>

<main>
    <!-- Slider (background image is set via JS on #dtl-page-slider) -->
    <section id="dtl-page-slider" class="slider slider-detail-pg position-relative" aria-label="Featured movie">
        <article id="slider-detail-card" class="card position-absolute" aria-label="Featured movie details">
            <div class="card-body">
                <h1 id="details-title" class="card-title my-3"></h1>
                <h2 id="details-date" class="my-3 h5"></h2>
                <p id="details-synopsis" class="card-text my-3"></p>
                <p id="details-cast" class="my-3"></p>
            </div>
        </article>
    </section>

    <!-- Catalogue (dynamic content injected by script.js) -->
    <section class="catalogue px-5 py-2" aria-label="Movies catalogue sections">

        <section class="category category2 my-5" aria-label="Most popular movies">
            <h2 class="pb-3">Most Popular</h2>
            <div class="row row_for_api most-popular row2 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <!-- Trending (mix of sections is handled by script.js) -->
        <section class="category category1 my-5" aria-label="Trending movies">
            <h2 class="pb-3">Trending now</h2>
            <div class="row row_for_api trending row1 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <section class="category category2 my-5" aria-label="Recently added movies">
            <h2 class="pb-3">Recently Added</h2>
            <div class="row row_for_api recently-added row2 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <section class="category category3 my-5" aria-label="Western movies">
            <h2 class="pb-3">Movies Western</h2>
            <div class="row row_for_api western row2 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <section class="category category4 my-5" aria-label="Action and adventure movies">
            <h2 class="pb-3">Movies Action and Adventure</h2>
            <div class="row row_for_api action-adventure row3 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <section class="category category5 my-5" aria-label="Animation movies">
            <h2 class="pb-3">Movies Animation</h2>
            <div class="row row_for_api animation row4 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <section class="category category6 my-5" aria-label="Documentary movies">
            <h2 class="pb-3">Movies Documentaries</h2>
            <div class="row row_for_api documentary row5 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <!-- Note:
          The "Most popular" row exists on index.php as a mixed (movies + tv) section.
          On this page, script.js currently fetches movie-only rows (trending, recently added, western, etc.).
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