<?php
// Enable these during local debugging if needed:
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/*
TMDB API Proxy (template)

Purpose:
- Fetch TMDB data from the server side so the API key is not exposed in frontend code.
- The frontend calls this file via XHR/fetch and passes simple query flags.
- This script maps those flags to the correct TMDB endpoint and returns JSON as-is.

Setup:
- Copy this file to `api_private_request.php`
- Replace the placeholder key below with your own TMDB key.
*/

$apiAuthKey = 'api_key=YOUR_TMDB_API_KEY';

/* --- Read query flags (the value is not important, only the presence) --- */
$forMostPopularMovie      = isset($_GET['for-most-popular-movie']) ? urlencode($_GET['for-most-popular-movie']) : null;
$forMostPopularSeries     = isset($_GET['for-most-popular-series']) ? urlencode($_GET['for-most-popular-series']) : null;

$forTrendingContent       = isset($_GET['for-trending-videos']) ? urlencode($_GET['for-trending-videos']) : null;
$forTrendingMovies        = isset($_GET['for-trending-movie']) ? urlencode($_GET['for-trending-movie']) : null;
$forTrendingSeries        = isset($_GET['for-trending-series']) ? urlencode($_GET['for-trending-series']) : null;

$forRecentlyAddedMovie    = isset($_GET['for-recently-added-movie']) ? urlencode($_GET['for-recently-added-movie']) : null;
$forRecentlyAddedSeries   = isset($_GET['for-recently-added-series']) ? urlencode($_GET['for-recently-added-series']) : null;

$forScifiFantasySeries    = isset($_GET['for-scifi-fantasy-series']) ? urlencode($_GET['for-scifi-fantasy-series']) : null;

$forWesternMovies         = isset($_GET['for-western-movie']) ? urlencode($_GET['for-western-movie']) : null;

$forActionAdventureMovie  = isset($_GET['for-action-adventure-movie']) ? urlencode($_GET['for-action-adventure-movie']) : null;
$forActionAdventureSeries = isset($_GET['for-action-adventure-series']) ? urlencode($_GET['for-action-adventure-series']) : null;

$forAnimationMovie        = isset($_GET['for-animation-movie']) ? urlencode($_GET['for-animation-movie']) : null;
$forAnimationSeries       = isset($_GET['for-animation-series']) ? urlencode($_GET['for-animation-series']) : null;

$forDocumentaryMovie      = isset($_GET['for-documentary-movie']) ? urlencode($_GET['for-documentary-movie']) : null;
$forDocumentarySeries     = isset($_GET['for-documentary-series']) ? urlencode($_GET['for-documentary-series']) : null;

/* --- Details page flags --- */
$isMovie                  = isset($_GET['movie-title']) ? urlencode($_GET['movie-title']) : null;
$isTvSeries               = isset($_GET['tvseries-title']) ? urlencode($_GET['tvseries-title']) : null;
$isASuggestedVideo        = isset($_GET['with_genres']) ? urlencode($_GET['with_genres']) : null;

$contentId                = isset($_GET['content-id']) ? $_GET['content-id'] : null;

$urlForApiCall = null;

/* --- Home sections --- */
if ($forMostPopularMovie) {
    $urlForApiCall = "https://api.themoviedb.org/3/movie/popular?$apiAuthKey&language=en-US&page=1";
} elseif ($forMostPopularSeries) {
    $urlForApiCall = "https://api.themoviedb.org/3/tv/popular?$apiAuthKey&language=en-US&page=1";
} elseif ($forTrendingContent) {
    $urlForApiCall = "https://api.themoviedb.org/3/trending/all/week?$apiAuthKey&language=en-US";
} elseif ($forRecentlyAddedMovie) {
    $urlForApiCall = "https://api.themoviedb.org/3/movie/now_playing?$apiAuthKey&language=en-US&page=1";
} elseif ($forRecentlyAddedSeries) {
    $urlForApiCall = "https://api.themoviedb.org/3/tv/airing_today?$apiAuthKey&language=en-US&page=1";
} elseif ($forScifiFantasySeries) {
    $urlForApiCall = "https://api.themoviedb.org/3/discover/tv?$apiAuthKey&include_adult=false&include_null_first_air_dates=false&language=en-US&page=1&sort_by=vote_count.desc&with_genres=10765";
} elseif ($forActionAdventureMovie) {
    $urlForApiCall = "https://api.themoviedb.org/3/discover/movie?$apiAuthKey&include_adult=false&include_video=false&language=en-US&page=1&sort_by=vote_count.desc&with_genres=28%2C12";
} elseif ($forActionAdventureSeries) {
    $urlForApiCall = "https://api.themoviedb.org/3/discover/tv?$apiAuthKey&include_adult=false&include_null_first_air_dates=false&language=en-US&page=1&sort_by=vote_count.desc&with_genres=10759";
} elseif ($forAnimationMovie) {
    $urlForApiCall = "https://api.themoviedb.org/3/discover/movie?$apiAuthKey&include_adult=false&include_video=false&language=en-US&page=1&sort_by=vote_count.desc&with_genres=16";
} elseif ($forAnimationSeries) {
    $urlForApiCall = "https://api.themoviedb.org/3/discover/tv?$apiAuthKey&include_adult=false&include_null_first_air_dates=false&language=en-US&page=1&sort_by=vote_count.desc&with_genres=35";
} elseif ($forDocumentaryMovie) {
    $urlForApiCall = "https://api.themoviedb.org/3/discover/movie?$apiAuthKey&include_adult=false&include_video=false&language=en-US&page=1&sort_by=vote_count.desc&with_genres=99";
} elseif ($forDocumentarySeries) {
    $urlForApiCall = "https://api.themoviedb.org/3/discover/tv?$apiAuthKey&include_adult=false&include_null_first_air_dates=false&language=en-US&page=1&sort_by=vote_count.desc&with_genres=99";
}

/* --- Details page --- */
elseif ($isMovie) {
    // Suggested movies by genre (used on details.php)
    if ($isASuggestedVideo) {
        $urlForApiCall = "https://api.themoviedb.org/3/discover/movie?$apiAuthKey&with_genres=$isASuggestedVideo";
    }
    // Selected movie details (+ credits/images/videos)
    if ($contentId) {
        $urlForApiCall = "https://api.themoviedb.org/3/movie/$contentId?$apiAuthKey&append_to_response=credits,images,videos";
    }
} elseif ($isTvSeries) {
    // Suggested TV series by genre (used on details.php)
    if ($isASuggestedVideo) {
        $urlForApiCall = "https://api.themoviedb.org/3/discover/tv?$apiAuthKey&with_genres=$isASuggestedVideo";
    }
    // Selected TV series details (+ credits/images/videos)
    if ($contentId) {
        $urlForApiCall = "https://api.themoviedb.org/3/tv/$contentId?$apiAuthKey&append_to_response=credits,images,videos";
    }
}

/* --- Movies / TV pages (extra endpoints) --- */
elseif ($forWesternMovies) {
    $urlForApiCall = "https://api.themoviedb.org/3/discover/movie?$apiAuthKey&include_adult=false&include_null_first_air_dates=false&language=en-US&page=1&sort_by=vote_count.desc&with_genres=37";
} elseif ($forTrendingMovies) {
    $urlForApiCall = "https://api.themoviedb.org/3/trending/movie/week?$apiAuthKey&language=en-US";
} elseif ($forTrendingSeries) {
    $urlForApiCall = "https://api.themoviedb.org/3/trending/tv/week?$apiAuthKey&language=en-US";
} else {
    echo "Invalid request: missing or unknown query parameters.";
    exit;
}

/* --- Call TMDB and return JSON --- */
$tmdbResponse = file_get_contents($urlForApiCall);

if ($tmdbResponse === false) {
    echo "TMDB request failed.";
    exit;
}

header('Content-Type: application/json');
echo $tmdbResponse;
