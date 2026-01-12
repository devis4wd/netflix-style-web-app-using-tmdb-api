<?php
// Enable these only during local debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/*
  details.php

  Purpose:
  - Protected page (requires authentication)
  - Displays details for a selected movie or TV series
  - Page content is populated client-side by script.js via TMDB proxy calls
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

/*
  SEO metadata:
  The page title is based on the query string (movie-title or tvseries-title).
  Notes:
  - Use null coalescing to avoid "undefined index" notices.
  - Escape the title to prevent HTML injection in the <title> tag.
*/
$description = "Mindflix detail page. View a selected movie or TV series, watch related clips, and explore similar titles. Personal, non-commercial project to learn web development.";

$rawTitle = $_GET['movie-title'] ?? ($_GET['tvseries-title'] ?? 'Details');
$title = htmlspecialchars($rawTitle, ENT_QUOTES, 'UTF-8') . " | Mindflix";

include("php/main-pages-header.php");
?>

<main>
    <!-- Slider (background image is set via JS on #dtl-page-slider) -->
    <section id="dtl-page-slider" class="slider slider-detail-pg position-relative" aria-label="Selected title overview">
        <article id="slider-detail-card" class="card position-absolute" aria-label="Title details">
            <div class="card-body">
                <h1 id="details-title" class="card-title my-3"></h1>
                <h2 id="details-date" class="my-3 h5"></h2>
                <p id="details-synopsis" class="card-text my-3"></p>
                <p id="details-cast" class="my-3"></p>
            </div>
        </article>
    </section>

    <!-- Details content (dynamic content injected by script.js) -->
    <section class="catalogue px-5 py-2" aria-label="Details page content">
        <section class="category category1 my-5" aria-label="Video clips">
            <h2 class="pb-3">Video Clip</h2>
            <div class="row row1 py-3 g-3 justify-content-start">
                <!-- Video iframes are injected here by script.js -->
            </div>
        </section>

        <section class="category category2 my-5" aria-label="More like this">
            <h2 class="pb-3">More Like This</h2>
            <div class="row row2 py-3 g-3 justify-content-start">
                <!-- Suggested titles are injected here by script.js -->
            </div>
        </section>
    </section>
</main>

<?php require('php/main-pages-footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>

</html>