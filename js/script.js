console.log("Your JavaScript code file is now connected to your website.");

/*
  FakeFlix script.js

  Responsibilities:
  - UI helpers (search bar toggle, login form toggle, small UI interactions)
  - Fetches TMDB data via a PHP proxy (API key stays server-side)
  - Renders Movies/TV content dynamically (home, movies, tv series, details)
  - Handles small page-specific UI logic (account settings mobile tabs)
*/

/* -------------------------------------------------------------------------- */
/* Small safety helpers (added to avoid crashes with missing TMDB fields)     */
/* -------------------------------------------------------------------------- */

/*
  Added: TMDB sometimes returns unexpected/missing fields (empty results, no videos, no images, etc.).
  These helpers keep the rest of the code readable and avoid repeating long checks everywhere.
*/
function safeArray(value) {
  return Array.isArray(value) ? value : [];
}

function safeResults(tmdbData) {
  // Added: normalize `results` for list endpoints.
  return safeArray(tmdbData && tmdbData.results);
}

function safeText(value, fallback = "") {
  // Added: normalize strings.
  return typeof value === "string" ? value : fallback;
}

function safeYear(dateString) {
  // Added: avoid "Invalid Date" crashes.
  const d = new Date(dateString);
  return Number.isFinite(d.getTime()) ? d.getFullYear() : "";
}

/* -------------------------------------------------------------------------- */
/* UI: Search bar toggle (desktop)                                             */
/* -------------------------------------------------------------------------- */

const searchBtn = document.getElementById("src-nav-button-desktop");
const searchBar = document.getElementsByClassName("search-input")[0];

if (searchBtn && searchBar) {
  searchBtn.addEventListener("click", function (event) {
    event.preventDefault(); // keep UI state, avoid navigation
    searchBar.classList.toggle("src-active");
  });
}

/* -------------------------------------------------------------------------- */
/* UI: Login form toggle (password vs sign-in code)                            */
/* -------------------------------------------------------------------------- */

const codeLoginBtn = document.getElementById("code-signin-btn");
const logInPwdInput = document.getElementById("login-pwd");
const loginLabelPwd = document.getElementById("login-pwd-label");
const invalidFeedback = document.getElementById("invalid-pwd-fdb");

if (codeLoginBtn && logInPwdInput && loginLabelPwd && invalidFeedback) {
  codeLoginBtn.addEventListener("click", function () {
    const isCodeMode = codeLoginBtn.textContent.trim() === "Use a Sign-in Code";

    if (isCodeMode) {
      codeLoginBtn.textContent = "Use password";
      if (
        !logInPwdInput.classList.contains("hide-form-element") &&
        !loginLabelPwd.classList.contains("hide-form-element")
      ) {
        logInPwdInput.classList.add("hide-form-element");
        loginLabelPwd.classList.add("hide-form-element");
        invalidFeedback.classList.add("hide-form-element");
      }
    } else {
      codeLoginBtn.textContent = "Use a Sign-in Code";
      if (
        logInPwdInput.classList.contains("hide-form-element") &&
        loginLabelPwd.classList.contains("hide-form-element")
      ) {
        logInPwdInput.classList.remove("hide-form-element");
        loginLabelPwd.classList.remove("hide-form-element");
        invalidFeedback.classList.remove("hide-form-element");
      }
    }
  });
}

/* -------------------------------------------------------------------------- */
/* Optional: Bootstrap validation demo (currently unused in this project)      */
/* -------------------------------------------------------------------------- */

const form = document.getElementsByClassName("requires-validation")[0];

if (form) {
  form.addEventListener("submit", function (event) {
    if (!form.checkValidity()) {
      event.preventDefault();
    }
    form.classList.add("was-validated");
  });
}

/* -------------------------------------------------------------------------- */
/* UI: reCAPTCHA info toggle (login page)                                      */
/* -------------------------------------------------------------------------- */

const reCaptcha = document.getElementById("recapcha-learn");

if (reCaptcha) {
  reCaptcha.addEventListener("click", function (e) {
    const captchaText = document.getElementById("recapcha-info");
    if (!captchaText) return;

    if (captchaText.classList.contains("hide-class")) {
      e.preventDefault();
      captchaText.classList.remove("hide-class");
      reCaptcha.classList.add("hide-class");
    }
  });
}

/* -------------------------------------------------------------------------- */
/* TMDB proxy helpers                                                         */
/* -------------------------------------------------------------------------- */

function apiCallFromBackend(phpProxyPath, urlSrcKeyValue) {
  return new Promise((resolve, reject) => {
    const urlForPhpApiProxy = phpProxyPath + urlSrcKeyValue;
    console.log("URL for API call:", urlForPhpApiProxy);

    const xhr = new XMLHttpRequest();
    xhr.open("GET", urlForPhpApiProxy);

    xhr.onreadystatechange = function () {
      const DONE = 4;
      const OK = 200;

      if (xhr.readyState !== DONE) return;

      if (xhr.status === OK) {
        try {
          const jsonString = xhr.responseText;
          const jsonTurnedIntoJS = JSON.parse(jsonString);
          resolve(jsonTurnedIntoJS);
        } catch (error) {
          reject("JSON parse error. HTTP status: " + xhr.status);
        }
      } else {
        reject("Backend API returned an error. HTTP status: " + xhr.status);
      }
    };

    xhr.send();
  });
}

async function saveParsedJson(phpProxyPath, urlSrcKeyValue) {
  try {
    const parsedJson = await apiCallFromBackend(phpProxyPath, urlSrcKeyValue);
    return parsedJson;
  } catch (error) {
    console.error("Error during backend API call:", error);
    return null;
  }
}

/*
  Creates a mixed array (movies + tv series) by doing 2 calls (one for movies, one for series).
  It pushes up to 6 + 6 items, interleaved.
*/
async function fillMixedContentArray_2ApiCallsVersion(
  varForMovies,
  urlSrcKeyForMovies,
  varForTV,
  urlSrcKeyForSeries,
  phpProxyFilePath,
  arrayforMixedContent
) {
  varForMovies = await saveParsedJson(phpProxyFilePath, urlSrcKeyForMovies);
  varForTV = await saveParsedJson(phpProxyFilePath, urlSrcKeyForSeries);

  // Changed: use helper to avoid crashes if results is missing
  const movieResults = safeResults(varForMovies);
  const tvResults = safeResults(varForTV);

  if (movieResults.length === 0 && tvResults.length === 0) return;

  // Changed: avoid assuming at least 6 items exist
  const max = Math.min(6, movieResults.length, tvResults.length);
  for (let i = 0; i < max; i++) {
    if (movieResults[i]) arrayforMixedContent.push(movieResults[i]);
    if (tvResults[i]) arrayforMixedContent.push(tvResults[i]);
  }
}

/*
  Creates a mixed array (movies + tv series) using a single TMDB endpoint (already mixed).
  It pushes up to 12 items.
*/
async function fillMixedContentArray_uniqueApiCallVersion(
  varForMoviesAndTV,
  urlSrcKeyForMoviesAndTV,
  phpProxyFilePath,
  arrayforMixedContent
) {
  varForMoviesAndTV = await saveParsedJson(phpProxyFilePath, urlSrcKeyForMoviesAndTV);

  // Changed: use helper + cap by length
  const results = safeResults(varForMoviesAndTV);
  const max = Math.min(12, results.length);

  for (let i = 0; i < max; i++) {
    if (results[i]) arrayforMixedContent.push(results[i]);
  }
}

/*
  Detects movie vs tv series from TMDB object keys and injects the correct card/link.
  - Movies: title
  - TV series: name
*/
function tellMovieVsSeriesAndInject(referenceInfoContainer, arrayObject, rowToFill) {
  if (!referenceInfoContainer || referenceInfoContainer.length === 0) return;
  if (!arrayObject || !rowToFill) return;

  const posterCover = arrayObject.poster_path;
  const contentId = arrayObject.id;
  const movieTitle = arrayObject.title;
  const tvTitle = arrayObject.name;

  if (!posterCover || !contentId) return;

  // Changed: avoid undefined alt text
  const safeMovieTitle = safeText(movieTitle, "Movie");
  const safeTvTitle = safeText(tvTitle, "TV Series");

  if (movieTitle) {
    rowToFill.innerHTML += `
      <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2">
        <a href="details.php?content-id=${contentId}&movie-title=${encodeURIComponent(safeMovieTitle)}">
          <img src="https://image.tmdb.org/t/p/w500${posterCover}" alt="${safeMovieTitle}">
        </a>
      </div>`;
  } else {
    rowToFill.innerHTML += `
      <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2">
        <a href="details.php?content-id=${contentId}&tvseries-title=${encodeURIComponent(safeTvTitle)}">
          <img src="https://image.tmdb.org/t/p/w500${posterCover}" alt="${safeTvTitle}">
        </a>
      </div>`;
  }
}

/* -------------------------------------------------------------------------- */
/* Routing: detect current page                                                */
/* -------------------------------------------------------------------------- */

const currentUrl = window.location.pathname.split("/").pop();
console.log("Current page:", currentUrl);

/* -------------------------------------------------------------------------- */
/* Main                                                                        */
/* -------------------------------------------------------------------------- */

window.addEventListener("load", async function () {
  const phpProxyFilePath = "./php/api_private_request.php";

  /* ---------------------------------------------------------------------- */
  /* HOME (index.php)                                                        */
  /* ---------------------------------------------------------------------- */

  if (currentUrl === "index.php" || currentUrl === "") {
    const catalogRows = document.querySelectorAll(".row_for_api");
    catalogRows.forEach((row) => {
      row.innerHTML = " ";
    });

    const mostPopularRow = document.querySelector(".most-popular");
    const mostPopularArray = [];
    await fillMixedContentArray_2ApiCallsVersion(
      null,
      "?for-most-popular-movie=yes",
      null,
      "?for-most-popular-series=yes",
      phpProxyFilePath,
      mostPopularArray
    );
    mostPopularArray.forEach((obj) => tellMovieVsSeriesAndInject(mostPopularArray, obj, mostPopularRow));

    const trendingRow = document.querySelector(".trending");
    const trendingContentsArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(
      null,
      "?for-trending-videos=yes",
      phpProxyFilePath,
      trendingContentsArray
    );
    trendingContentsArray.forEach((obj) => tellMovieVsSeriesAndInject(trendingContentsArray, obj, trendingRow));

    const recAddRow = document.querySelector(".recently-added");
    const recAddArray = [];
    await fillMixedContentArray_2ApiCallsVersion(
      null,
      "?for-recently-added-movie=yes",
      null,
      "?for-recently-added-series=yes",
      phpProxyFilePath,
      recAddArray
    );
    recAddArray.forEach((obj) => tellMovieVsSeriesAndInject(recAddArray, obj, recAddRow));

    const scifiFantasyRow = document.querySelector(".scifi-and-fantasy");
    const scifiFantasyArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(
      null,
      "?for-scifi-fantasy-series=yes",
      phpProxyFilePath,
      scifiFantasyArray
    );
    scifiFantasyArray.forEach((obj) => tellMovieVsSeriesAndInject(scifiFantasyArray, obj, scifiFantasyRow));

    const actionAdventureRow = document.querySelector(".action-adventure");
    const actAdventArray = [];
    await fillMixedContentArray_2ApiCallsVersion(
      null,
      "?for-action-adventure-movie=yes",
      null,
      "?for-action-adventure-series=yes",
      phpProxyFilePath,
      actAdventArray
    );
    actAdventArray.forEach((obj) => tellMovieVsSeriesAndInject(actAdventArray, obj, actionAdventureRow));

    const animationRow = document.querySelector(".animation");
    const animationArray = [];
    await fillMixedContentArray_2ApiCallsVersion(
      null,
      "?for-animation-movie=yes",
      null,
      "?for-animation-series=yes",
      phpProxyFilePath,
      animationArray
    );
    animationArray.forEach((obj) => tellMovieVsSeriesAndInject(animationArray, obj, animationRow));

    const documentaryRow = document.querySelector(".documentary");
    const documentaryArray = [];
    await fillMixedContentArray_2ApiCallsVersion(
      null,
      "?for-documentary-movie=yes",
      null,
      "?for-documentary-series=yes",
      phpProxyFilePath,
      documentaryArray
    );
    documentaryArray.forEach((obj) => tellMovieVsSeriesAndInject(documentaryArray, obj, documentaryRow));
  }

  /* ---------------------------------------------------------------------- */
  /* DETAILS (details.php)                                                    */
  /* ---------------------------------------------------------------------- */

  else if (currentUrl === "details.php") {
    const urlParams = new URLSearchParams(window.location.search);
    const urlIdValue = urlParams.get("content-id");
    const urlMovieValue = urlParams.get("movie-title");
    const urlTvValue = urlParams.get("tvseries-title");

    const detailTitle = document.getElementById("details-title");
    const detailReleaseDate = document.getElementById("details-date");
    const synopsis = document.getElementById("details-synopsis");
    const detailCast = document.getElementById("details-cast");
    const rowDetail1 = document.querySelector(".row1");
    const videoClipSection = document.querySelector(".category1");
    const rowDetail2 = document.querySelector(".row2");
    const sliderEl = document.querySelector("#dtl-page-slider");

    if (!urlIdValue) return;

    let urlSrcKeyValue = "";
    if (urlMovieValue) {
      urlSrcKeyValue = `?movie-title=${encodeURIComponent(urlMovieValue)}&content-id=${urlIdValue}`;
    } else {
      urlSrcKeyValue = `?tvseries-title=${encodeURIComponent(urlTvValue)}&content-id=${urlIdValue}`;
    }

    const tmdbVideoData = await saveParsedJson(phpProxyFilePath, urlSrcKeyValue);
    if (!tmdbVideoData) return;

    if (parseInt(urlIdValue, 10) === tmdbVideoData.id) {
      if (detailTitle) {
        detailTitle.innerText = tmdbVideoData.title ?? tmdbVideoData.name ?? "Title not available";
      }

      if (detailReleaseDate) {
        // Changed: safeYear + safeArray to avoid crashes
        const year = safeYear(tmdbVideoData.release_date ?? tmdbVideoData.first_air_date);
        const genresArr = safeArray(tmdbVideoData.genres);
        const genres = genresArr.slice(0, 3).map((g) => g.name).join(", ");
        detailReleaseDate.innerText = `${year} | ${genres}`;
      }

      if (synopsis) {
        const overview = safeText(tmdbVideoData.overview);
        synopsis.innerText = overview.length ? overview.substring(0, 240) + "..." : "";
      }

      if (detailCast) {
        // Changed: safe array access
        const castArr = safeArray(tmdbVideoData.credits && tmdbVideoData.credits.cast);
        const cast = castArr.slice(0, 3).map((a) => a.name).join(", ");
        detailCast.innerHTML = cast ? "<span>Starring: </span>" + cast : "";
      }

      if (sliderEl && tmdbVideoData.images) {
        const backdrops = safeArray(tmdbVideoData.images.backdrops);
        const posters = safeArray(tmdbVideoData.images.posters);

        const customBackground =
          backdrops.length > 0 ? backdrops[0].file_path : posters.length > 0 ? posters[0].file_path : null;

        if (customBackground) {
          sliderEl.style.backgroundImage = `url("https://image.tmdb.org/t/p/original${customBackground}")`;
        } else {
          console.log("No background image available for the slider.");
        }
      }
    }

    // YouTube clips
    const videoResults = safeArray(tmdbVideoData.videos && tmdbVideoData.videos.results);
    if (videoResults.length > 0 && rowDetail1) {
      const videoSelection = videoResults.slice(0, 5);
      rowDetail1.innerHTML = " ";

      for (let i = 0; i < videoSelection.length; i++) {
        const sampleVideo = videoSelection[i].key;
        if (!sampleVideo) continue;

        rowDetail1.innerHTML += `
          <div class="col py-2 py-md-0 col-6 col-md-4 col-lg-2">
            <iframe
              width="100%"
              height="auto"
              src="https://www.youtube-nocookie.com/embed/${sampleVideo}"
              title="YouTube video player"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              referrerpolicy="strict-origin-when-cross-origin"
              allowfullscreen>
            </iframe>
          </div>`;
      }
    } else {
      if (videoClipSection) videoClipSection.innerHTML = " ";
    }

    // Similar content suggestions (by genres)
    if (rowDetail2) rowDetail2.innerHTML = " ";

    const alreadySuggested = new Set();
    const genresArr = safeArray(tmdbVideoData.genres);

    if (genresArr.length > 0) {
      const maxGenres = Math.min(4, genresArr.length);

      for (let i = 0; i < maxGenres; i++) {
        const videoSuggestion = genresArr[i].id;
        if (!videoSuggestion) continue;

        if (urlMovieValue) {
          urlSrcKeyValue = `?movie-title=${encodeURIComponent(urlMovieValue)}&with_genres=${videoSuggestion}`;
        } else {
          urlSrcKeyValue = `?tvseries-title=${encodeURIComponent(urlTvValue)}&with_genres=${videoSuggestion}`;
        }

        const suggestionsData = await saveParsedJson(phpProxyFilePath, urlSrcKeyValue);
        const results = safeResults(suggestionsData);
        if (results.length === 0) continue;

        for (let j = 0; j < Math.min(4, results.length); j++) {
          const item = results[j];
          if (!item) continue;

          const suggestedVideoId = item.id;
          const suggestedVideoTitle = item.original_title ?? item.name;
          const suggestedVideoImg = item.poster_path;

          if (!suggestedVideoId || !suggestedVideoTitle || !suggestedVideoImg) continue;
          if (alreadySuggested.has(suggestedVideoTitle)) continue;

          alreadySuggested.add(suggestedVideoTitle);

          if (item.original_title) {
            rowDetail2.innerHTML += `
              <div class="col py-2 py-md-0 col-6 col-md-4 col-lg-2">
                <a href="details.php?content-id=${suggestedVideoId}&movie-title=${encodeURIComponent(suggestedVideoTitle)}">
                  <img src="https://image.tmdb.org/t/p/w200${suggestedVideoImg}" alt="${suggestedVideoTitle}">
                </a>
              </div>`;
          } else {
            rowDetail2.innerHTML += `
              <div class="col py-2 py-md-0 col-6 col-md-4 col-lg-2">
                <a href="details.php?content-id=${suggestedVideoId}&tvseries-title=${encodeURIComponent(suggestedVideoTitle)}">
                  <img src="https://image.tmdb.org/t/p/w200${suggestedVideoImg}" alt="${suggestedVideoTitle}">
                </a>
              </div>`;
          }
        }
      }
    }
  }

  /* ---------------------------------------------------------------------- */
  /* MOVIES (movies.php)                                                      */
  /* ---------------------------------------------------------------------- */

  else if (currentUrl === "movies.php") {
    const detailTitle = document.getElementById("details-title");
    const detailReleaseDate = document.getElementById("details-date");
    const synopsis = document.getElementById("details-synopsis");
    const detailCast = document.getElementById("details-cast");
    const sliderEl = document.querySelector("#dtl-page-slider");

    const sliderPick = await saveParsedJson(phpProxyFilePath, "?for-recently-added-movie=yes");
    const pickResults = safeResults(sliderPick);

    if (pickResults[0]) {
      const first = pickResults[0];
      const firstTitle = safeText(first.title);

      const sliderVideoData = await saveParsedJson(
        phpProxyFilePath,
        `?movie-title=${encodeURIComponent(firstTitle)}&content-id=${first.id}`
      );

      if (sliderVideoData) {
        if (detailTitle) detailTitle.innerText = sliderVideoData.title ? sliderVideoData.title : "Title not available";

        if (detailReleaseDate) {
          const year = safeYear(sliderVideoData.release_date);
          const genresArr = safeArray(sliderVideoData.genres);
          const genres = genresArr.slice(0, 3).map((g) => g.name).join(", ");
          detailReleaseDate.innerText = `${year} | ${genres}`;
        }

        if (synopsis) {
          const overview = safeText(sliderVideoData.overview);
          synopsis.innerText = overview.length ? overview.substring(0, 240) + "..." : "";
        }

        if (detailCast) {
          const castArr = safeArray(sliderVideoData.credits && sliderVideoData.credits.cast);
          const cast = castArr.slice(0, 3).map((a) => a.name).join(", ");
          detailCast.innerHTML = cast ? "<span>Starring: </span>" + cast : "";
        }

        if (sliderEl && sliderVideoData.images) {
          const backdrops = safeArray(sliderVideoData.images.backdrops);
          const posters = safeArray(sliderVideoData.images.posters);
          const customBackground =
            backdrops.length > 0 ? backdrops[0].file_path : posters.length > 0 ? posters[0].file_path : null;

          if (customBackground) {
            sliderEl.style.backgroundImage = `url("https://image.tmdb.org/t/p/original${customBackground}")`;
          } else {
            console.log("No background image available for the slider.");
          }
        }
      }
    }

    const mostPopularRow = document.querySelector(".most-popular");
    const mostPopularMoviesArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-most-popular-movie=yes", phpProxyFilePath, mostPopularMoviesArray);
    mostPopularMoviesArray.forEach((obj) => tellMovieVsSeriesAndInject(mostPopularMoviesArray, obj, mostPopularRow));

    const trendingRow = document.querySelector(".trending");
    const trendingMoviesArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-trending-movie=yes", phpProxyFilePath, trendingMoviesArray);
    trendingMoviesArray.forEach((obj) => tellMovieVsSeriesAndInject(trendingMoviesArray, obj, trendingRow));

    const recAddRow = document.querySelector(".recently-added");
    const recAddArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-recently-added-movie=yes", phpProxyFilePath, recAddArray);
    recAddArray.forEach((obj) => tellMovieVsSeriesAndInject(recAddArray, obj, recAddRow));

    const westernRow = document.querySelector(".western");
    const westernArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-western-movie=yes", phpProxyFilePath, westernArray);
    westernArray.forEach((obj) => tellMovieVsSeriesAndInject(westernArray, obj, westernRow));

    const actionAdventureRow = document.querySelector(".action-adventure");
    const actAdventArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-action-adventure-movie=yes", phpProxyFilePath, actAdventArray);
    actAdventArray.forEach((obj) => tellMovieVsSeriesAndInject(actAdventArray, obj, actionAdventureRow));

    const animationRow = document.querySelector(".animation");
    const animationArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-animation-movie=yes", phpProxyFilePath, animationArray);
    animationArray.forEach((obj) => tellMovieVsSeriesAndInject(animationArray, obj, animationRow));

    const documentaryRow = document.querySelector(".documentary");
    const documentaryArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-documentary-movie=yes", phpProxyFilePath, documentaryArray);
    documentaryArray.forEach((obj) => tellMovieVsSeriesAndInject(documentaryArray, obj, documentaryRow));
  }

  /* ---------------------------------------------------------------------- */
  /* TV SERIES (tvseries.php)                                                 */
  /* ---------------------------------------------------------------------- */

  else if (currentUrl === "tvseries.php") {
    const detailTitle = document.getElementById("details-title");
    const detailReleaseDate = document.getElementById("details-date");
    const synopsis = document.getElementById("details-synopsis");
    const detailCast = document.getElementById("details-cast");
    const sliderEl = document.querySelector("#dtl-page-slider");

    const sliderPick = await saveParsedJson(phpProxyFilePath, "?for-recently-added-series=yes");
    const pickResults = safeResults(sliderPick);

    if (pickResults[0]) {
      const first = pickResults[0];
      const firstName = safeText(first.name);

      const sliderVideoData = await saveParsedJson(
        phpProxyFilePath,
        `?tvseries-title=${encodeURIComponent(firstName)}&content-id=${first.id}`
      );

      if (sliderVideoData) {
        if (detailTitle) detailTitle.innerText = sliderVideoData.name ? sliderVideoData.name : "Title not available";

        if (detailReleaseDate) {
          const year = safeYear(sliderVideoData.first_air_date);
          const genresArr = safeArray(sliderVideoData.genres);
          const genres = genresArr.slice(0, 3).map((g) => g.name).join(", ");
          detailReleaseDate.innerText = `${year} | ${genres}`;
        }

        if (synopsis) {
          const overview = safeText(sliderVideoData.overview);
          synopsis.innerText = overview.length ? overview.substring(0, 240) + "..." : "";
        }

        if (detailCast) {
          const castArr = safeArray(sliderVideoData.credits && sliderVideoData.credits.cast);
          const cast = castArr.slice(0, 3).map((a) => a.name).join(", ");
          detailCast.innerHTML = cast ? "<span>Starring: </span>" + cast : "";
        }

        if (sliderEl && sliderVideoData.images) {
          const backdrops = safeArray(sliderVideoData.images.backdrops);
          const posters = safeArray(sliderVideoData.images.posters);
          const customBackground =
            backdrops.length > 0 ? backdrops[0].file_path : posters.length > 0 ? posters[0].file_path : null;

          if (customBackground) {
            sliderEl.style.backgroundImage = `url("https://image.tmdb.org/t/p/original${customBackground}")`;
          } else {
            console.log("No background image available for the slider.");
          }
        }
      }
    }

    const mostPopularRow = document.querySelector(".most-popular");
    const mostPopularSeriesArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-most-popular-series=yes", phpProxyFilePath, mostPopularSeriesArray);
    mostPopularSeriesArray.forEach((obj) => tellMovieVsSeriesAndInject(mostPopularSeriesArray, obj, mostPopularRow));

    const trendingRow = document.querySelector(".trending");
    const trendingSeriesArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-trending-series=yes", phpProxyFilePath, trendingSeriesArray);
    trendingSeriesArray.forEach((obj) => tellMovieVsSeriesAndInject(trendingSeriesArray, obj, trendingRow));

    const recAddRow = document.querySelector(".recently-added");
    const recAddArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-recently-added-series=yes", phpProxyFilePath, recAddArray);
    recAddArray.forEach((obj) => tellMovieVsSeriesAndInject(recAddArray, obj, recAddRow));

    const scifiFantasyRow = document.querySelector(".scifi-and-fantasy");
    const scifiFantasyArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-scifi-fantasy-series=yes", phpProxyFilePath, scifiFantasyArray);
    scifiFantasyArray.forEach((obj) => tellMovieVsSeriesAndInject(scifiFantasyArray, obj, scifiFantasyRow));

    const actionAdventureRow = document.querySelector(".action-adventure");
    const actAdventArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-action-adventure-series=yes", phpProxyFilePath, actAdventArray);
    actAdventArray.forEach((obj) => tellMovieVsSeriesAndInject(actAdventArray, obj, actionAdventureRow));

    const animationRow = document.querySelector(".animation");
    const animationArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-animation-series=yes", phpProxyFilePath, animationArray);
    animationArray.forEach((obj) => tellMovieVsSeriesAndInject(animationArray, obj, animationRow));

    const documentaryRow = document.querySelector(".documentary");
    const documentaryArray = [];
    await fillMixedContentArray_uniqueApiCallVersion(null, "?for-documentary-series=yes", phpProxyFilePath, documentaryArray);
    documentaryArray.forEach((obj) => tellMovieVsSeriesAndInject(documentaryArray, obj, documentaryRow));
  }

  /* ---------------------------------------------------------------------- */
  /* ACCOUNT SETTINGS (account-settings.php)                                  */
  /* ---------------------------------------------------------------------- */

  else if (currentUrl === "account-settings.php") {
    const settingsLeftTabs = document.querySelector(".nav-pills");
    const settingsRightContent = document.querySelector(".tab-content");
    const settingsTabs = document.querySelectorAll(".interactive-tab");
    const arrowIcons = document.querySelectorAll(".bi-arrow-left-circle");

    if (settingsLeftTabs && settingsRightContent && settingsTabs.length > 0) {
      settingsTabs.forEach((tab) => {
        tab.addEventListener("click", function () {
          if (tab.classList.contains("active")) {
            settingsLeftTabs.classList.add("hidden");
            settingsRightContent.classList.add("grow");
          }
        });
      });
    }

    if (arrowIcons.length > 0 && settingsLeftTabs && settingsRightContent) {
      arrowIcons.forEach((icon) => {
        icon.addEventListener("click", function () {
          if (settingsLeftTabs.classList.contains("hidden")) {
            settingsLeftTabs.classList.remove("hidden");
            settingsRightContent.classList.remove("grow");
          }
        });
      });
    }
  }
});
