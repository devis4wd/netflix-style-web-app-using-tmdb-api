<?php
// Enable these only during local debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/*
  index.php (Home)

  Purpose:
  - Public landing page (no login required)
  - UI structure is hydrated by script.js via TMDB proxy calls
*/

session_start();

// DB connection is required here mainly because the header/navbar may show user state (logged in / logged out).
require_once('config.php');

// Page SEO metadata
$description = "Mindflix homepage. Movies and TV series browsing powered by TMDB. Personal, non-commercial project to learn web development.";
$title = "Homepage | Mindflix";
include("php/main-pages-header.php");
?>

<main>
    <!-- Hero / Slider -->
    <section class="slider position-relative" aria-label="Featured title">
        <article class="card position-absolute" aria-label="Featured content card">
            <img src="img/the-batman.png" class="card-img-top" alt="The Batman logo">
            <div class="card-body">
                <h1 class="card-title">The Batman</h1>
                <p class="card-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
            </div>
        </article>

        <!-- Optional alternative to the YouTube iframe:
          <video autoplay muted controls>
            <source src="video/slider-preview-video.mp4" type="video/mp4">
          </video>
        -->

        <iframe
            width="100%"
            height="100%"
            src="https://www.youtube-nocookie.com/embed/mqqft2x_Aa4?si=98cddx8kIs7Xcps-"
            title="The Batman trailer"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin"
            allowfullscreen></iframe>
    </section>

    <!-- Catalogue (dynamic content injected by script.js) -->
    <section class="catalogue px-5 py-2" aria-label="Catalogue sections">

        <!-- Most popular -->
        <section class="category category1 my-5" aria-label="Most popular">
            <h2 class="pb-3">Most popular</h2>
            <div class="row row_for_api most-popular row1 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <!-- Trending now -->
        <section class="category category2 my-5" aria-label="Trending now">
            <h2 class="pb-3">Trending now</h2>
            <div class="row row_for_api trending row1 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <!-- Recently added -->
        <section class="category category3 my-5" aria-label="Recently added">
            <h2 class="pb-3">Recently Added</h2>
            <div class="row row_for_api recently-added row2 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <!-- TV Sci-fi & Fantasy -->
        <section class="category category3 my-5" aria-label="TV sci-fi and fantasy">
            <h2 class="pb-3">TV Sci-fi &amp; Fantasy</h2>
            <div class="row row_for_api scifi-and-fantasy row2 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <!-- Action and Adventure -->
        <section class="category category4 my-5" aria-label="Action and adventure">
            <h2 class="pb-3">TV and Movies Action and Adventure</h2>
            <div class="row row_for_api action-adventure row3 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <!-- Animation -->
        <section class="category category5 my-5" aria-label="Animation">
            <h2 class="pb-3">TV and Movies Animation</h2>
            <div class="row row_for_api animation row4 py-3 g-3">
                <!-- Cards are injected here by script.js -->
            </div>
        </section>

        <!-- Documentaries -->
        <section class="category category6 my-5" aria-label="Documentaries">
            <h2 class="pb-3">TV and Movies Documentaries</h2>
            <div class="row row_for_api documentary row5 py-3 g-3">
                <!-- Cards are injected here by script.js -->
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
