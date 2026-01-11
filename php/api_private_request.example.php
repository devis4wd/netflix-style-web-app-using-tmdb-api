<?php
/**
 * TMDB API Proxy (Example)
 *
 * This file acts as a backend proxy for TMDB API calls.
 * It prevents exposing the API key to the frontend.
 *
 * Copy this file to `api_private_request.php` and insert your TMDB API key.
 */

// Your TMDB API key (keep this private!)
$apiAuthKey = 'api_key=YOUR_TMDB_API_KEY';

// Read query parameters
$forMostPopularMovie    = $_GET['for-most-popular-movie']    ?? null;
$forMostPopularSeries  = $_GET['for-most-popular-series']   ?? null;
$forTrendingContent    = $_GET['for-trending-videos']       ?? null;
$forTrendingMovies     = $_GET['for-trending-movie']        ?? null;
$forTrendingSeries     = $_GET['for-trending-series']       ?? null;
$forRecentlyAddedMovie = $_GET['for-recently-added-movie']  ?? null;
$forRecentlyAddedSeries= $_GET['for-recently-added-series'] ?? null;
$forScifiFantasySeries = $_GET['for-scifi-fantasy-series']   ?? null;
$forWesternMovies      = $_GET['for-western-movie']         ?? null;

$isMovie       = $_GET['movie-title']    ?? null;
$isTvSeries    = $_GET['tvseries-title'] ?? null;
$isASuggested  = $_GET['with_genres']    ?? null;
$contentId     = $_GET['content-id']     ?? null;

$urlForApiCall = null;

/* --- Homepage sections --- */
if ($forMostPopularMovie) {
    $urlForApiCall = "https://api.themoviedb.org/3/movie/popular?$apiAuthKey";
} elseif ($forMostPopularSeries) {
    $urlForApiCall = "https://api.themoviedb.org/3/tv/popular?$apiAuthKey";
} elseif ($forTrendingContent) {
    $urlForApiCall = "https://api.themoviedb.org/3/trending/all/week?$apiAuthKey";
}

/* --- Details page --- */
elseif ($isMovie && $contentId) {
    $urlForApiCall = "https://api.themoviedb.org/3/movie/$contentId?$apiAuthKey&append_to_response=credits,images,videos";
}
elseif ($isTvSeries && $contentId) {
    $urlForApiCall = "https://api.themoviedb.org/3/tv/$contentId?$apiAuthKey&append_to_response=credits,images,videos";
}

if (!$urlForApiCall) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

// Call TMDB
$response = file_get_contents($urlForApiCall);

if ($response === false) {
    http_response_code(500);
    echo json_encode(["error" => "TMDB API request failed"]);
    exit;
}

header("Content-Type: application/json");
echo $response;
