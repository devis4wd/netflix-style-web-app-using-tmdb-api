console.log("Your JavaScript code file is now connected to your website.");


//SEARCH BAR  APPARE/SCOMPARE
let searchBtn = document.getElementById('src-nav-button-desktop');
let searchBar = document.getElementsByClassName('search-input')[0];

if (searchBtn) {
    searchBtn.addEventListener('click', function (event) {

        if (searchBar.classList.contains("src-active")) {
            searchBar.classList.remove('src-active');
            event.preventDefault(); //Altimenti: ogni volta che lo clicco la pagina si ricaricherà azzeranndo l'applicazione della classe src-active     
        }
        else {
            searchBar.classList.add('src-active');
            event.preventDefault(); // idem di quanto sopra
        }
    });
}

//Definisco costante per prendere il file style.css e che potrà essere usata da tutti i 
//blocchi di codice di questo file JS:
const MAINSTYLESHEET = document.styleSheets[1];



/* Creo codice JS per inserire dinamicamente una proprietà CSS per aumentare il pagging-bottom 
dell'header (solo nella versione mobile fino a max 990px di larghezza) per fare in modo che, quando clicco 
sul bottone Account del menù di navigazione, le opzioni che compariranno rimangano denetro all'header.
Dopodiché, quando riclicco sullo stesso bottone per chiudere il sotto-menu, farò in modo che il padding-bottom torni alla 
grandezza reale (ovvero quello applicato dalla classe Bootstrap 'py-2' applicata al tag <header>): 

const accountNavBtn = document.getElementById('js-dropdown-acc-button');

//Creo variabile per capire se selettore #flexible-header con regola CSS è stata già aggiunta a style.css o meno
//In questo modo JS sa se, quando clicco la seconda volta sul bottone 'Account' del menu, deve rimuovere tale selettore o meno da style.css:
let paddingAdded = false;

accountNavBtn.addEventListener('click', function (event) {
    console.log(MAINSTYLESHEET);
    //Specifico media query di style.css entro la quale inserire il nuovo selettore (#flexible-header)
    //con la nuova proprietà padding-bottom
    let mediaQuery = window.matchMedia('(max-width: 990px)');
    console.log(mediaQuery);
    //Codice per creare l'indice della media query di mio interesse all'interno di style.css:

    //Inizializzo variabile con valore - 1, che  significa che non è stata trovata ancora alcuna media query
    let mediaRuleIndex = -1;
    console.log(mediaRuleIndex);

    //Ciclo for per trovare indice della media query esistente (so che esiste già perché l'ho creata in style.css) 
    for (let i = 0; i < MAINSTYLESHEET.cssRules.length; i++) {
        //Se il testo di una delle media quey in style.css è uguale a quello specificato nella variabile mediaQuery
        //mediaQuery.media ci dà il valore stringa della chiave 'media' contenuta nell0oggetto JS messo in variabile mediaQuery
        if (MAINSTYLESHEET.cssRules[i].media && MAINSTYLESHEET.cssRules[i].media.mediaText === mediaQuery.media) {
            mediaRuleIndex = i;
            console.log('Media query trovata all\'indice:', mediaRuleIndex);
            break;
        } else {
            console.log('Media query non trovata');
        }
    }

    //Se media query trovata, aggiungo regola css all'interno della media query in style.css:
    if (mediaRuleIndex !== -1) {
        if (!paddingAdded) {
            MAINSTYLESHEET.cssRules[mediaRuleIndex].insertRule('#flexible-header {padding-bottom: 5.5rem !important;}', MAINSTYLESHEET.cssRules[mediaRuleIndex].cssRules.length);

            //Cambia valore di variavile paddingAdded in True così da dire a JS che ora la regola CSS è stata aggiunta in style.css:
            paddingAdded = true;
        }
        else { //Rimuovi regola CSS

            //Costante per ottenere tutte le regole css attualmente presenti in style.css e all'interno della media query 990px (che è quella con indice 
            //specificato in mediaRuleIndex):
            const rules = MAINSTYLESHEET.cssRules[mediaRuleIndex].cssRules;
            for (let j = 0; j < rules.length; j++) {
                //sS ein rules c'è la regola CSS con selettore #flexible-header, rimuovi quella regola
                if (rules[j].selectorText === '#flexible-header') {
                    MAINSTYLESHEET.cssRules[mediaRuleIndex].deleteRule(j);
                    break; // Esci dal ciclo dopo aver rimosso la regola
                }
            }
            //una volta rimossa la regola, ripristina paddingAdded a status false
            paddingAdded = false; // Imposta a false

        }
    }
});
*/

//CAMBIO LAYOUT FORM LOGIN (PWD VS SIGN-IN CODE)
const codeLoginBtn = document.getElementById('code-signin-btn');
const normalLoginBtn = document.getElementById('normal-signin-btn');
const logInEmailInput = document.getElementById('login-email');
const logInPwdInput = document.getElementById('login-pwd');
const loginLabelPwd = document.getElementById('login-pwd-label');
const invalidFeedback = document.getElementById('invalid-pwd-fdb');

if (codeLoginBtn) { //esegui solo se c'è un codeLoginBtn nella pagina corrente
    codeLoginBtn.addEventListener('click', function (e) {

        if (codeLoginBtn.textContent === "Use a Sign-in Code") {
            codeLoginBtn.textContent = "Use password";
            if (!logInPwdInput.classList.contains('hide-form-element') & !loginLabelPwd.classList.contains('hide-form-element')) {
                logInPwdInput.classList.add('hide-form-element');
                loginLabelPwd.classList.add('hide-form-element');
                invalidFeedback.classList.add('hide-form-element');
            }
        }
        else {
            codeLoginBtn.textContent = "Use a Sign-in Code";
            if (logInPwdInput.classList.contains('hide-form-element') & loginLabelPwd.classList.contains('hide-form-element')) {
                logInPwdInput.classList.remove('hide-form-element');
                loginLabelPwd.classList.remove('hide-form-element');
                invalidFeedback.classList.remove('hide-form-element');
            }
        }

    });
}



//VALIDAZIONE GRAFICA (VERDE/ROSSO) DEI CAMPI DI INPUT (codice Bootrstap)

//In realtà questo codice Bootstrap di validazione dei campi di input non è più utilizzato nelle pagine di Mindflix.
//Il preventDefault() impedivia l'invio del form e quindi i controlli custom tramite PHP che ho creato io nelle varie pagine del sito.
//Quindi ho rimosso la classe 'requires validation' dai <form> delle pagine e di fatto disattivato l'attivazione di questo codice JS.
const form = document.getElementsByClassName("requires-validation")[0];

if (form) { //esegui solo se c'è un form che richiede validazione nella pagina
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
        }

        form.classList.add('was-validated');
    });
}


/*DETTAGLI RECAPCHA IN PAGINA LOGIN CHE COMPAIONO/SCOMPAIONO*/
const reCaptcha = document.getElementById('recapcha-learn');

if (reCaptcha) {//execute this code block only if there's a reCaptcha in the current page
    reCaptcha.addEventListener('click', function (e) {

        const captchaText = document.getElementById('recapcha-info');

        if (captchaText.classList.contains('hide-class')) {
            e.preventDefault();
            captchaText.classList.remove('hide-class');
            reCaptcha.classList.add('hide-class');
        }
    })
}


/* CODICE PER CHIAMATE API A TMDB CHE SERVONO PER MOSTRARE CATALOGO IN HOMEPAGE E POPOLARE LA PAGINA DETAILS 
Struttura un pò complessa del codice è dovuta principalmente a questi fattori:
1) dalla struttura delle chiamate API stabilita da TMDB (url diversi in base al tipo di info richieste)
2) dal fatto che spesso le info per film/serie possiamo ottenerle solo con chiamate API diverse per queste due categorie di contenuti, e che ciò nonostante
   c'è bisogni di creare liste che siano un mix di entrambe (almeno nella Homepage)
3) dal fatto che ho voluto rendere il catalogo dei titoli nella Homepage "dinamico", ovvero variabile in base alle varie categorie e classifiche definite in TMDB   
   il file JSOn con la lista dei titoli 
4) dal fatto che le chiamate API le ho volute far fare in backend e non qui in JS per rendere non visibile la API KEY da front-end (console browser)
5) dal fatto che ho cercato di creare in primis una serie di funzioni che standardizzassero il più possibile la struttura ricorrente delle chiamate API pur nella loro varietà. */


//FUNZIONI PER CHIAMATE API DA BACKEND ED ELABORARE LE INFO IN JS IN MODO IL PIUÌ UNIFORME POSSIBILE NELLE VARIE SEZIONI: 
//per non esporre Key API, chiamo il file PHP ("proxy PHP"), che a sua volta fa la chiamata API da backend e poi restituisce JSON al codice JS di frontend.

/* Funzione unica per tutti i diversi casi in cui il sito necessita di fare chiamate API xhr e ottenere un JSON con le informazioni richieste 
   Ha 2 argomenti:  
   1)percorso file "proxy" php che farà la chiamata API in backend 
   2)valori query string da passare al proxy, affinché questo possa determinare l'url corretto in base alla chiamata API da fare richiesta dal codice frontend JS
   Contiene, inoltre, una PROMISE per poter poi gestire correttamente l'output della funzione nonostante l'asincronia della chiamata API  */

function apiCallFromBackend(phpProxyPath, urlSrcKeyValue) {
    // creo una promise
    return new Promise((resolve, reject) => {
        // Compongo URL per chiamare il file'api_private_request.php' contenente il "proxy php" che farà chiamata API vera e propria
        let urlForPhpApiProxy = phpProxyPath + urlSrcKeyValue;
        console.log("url for API call is: " + urlForPhpApiProxy);
        let xhr = new XMLHttpRequest();
        xhr.open('GET', urlForPhpApiProxy);
        xhr.onreadystatechange = function () {
            const DONE = 4; // completed request 
            const OK = 200; // server answered correctly

            if (xhr.readyState === DONE) {
                if (xhr.status === OK) {
                    try {
                        let jsonString = xhr.responseText; //salva qui la stringa JSON di TMDB recuperata dalla chiamata API in backend 
                        console.log(jsonString);
                        let jsonTurnedIntoJS = JSON.parse(jsonString); //trasformala  in oggetto JS utilizzabile 
                        console.log(jsonTurnedIntoJS);
                        resolve(jsonTurnedIntoJS); // risolvi la promise con il JSON parsato
                    } catch (error) {
                        reject("Backend API call returned the following error: " + xhr.status);
                    }
                }
                else {
                    console.error('Backend API didn\'t return a valid JSON file:', xhr.status);
                }
            }
        }
        xhr.send(); //invia richiesta api per ogni titolo che verrà ciclato più avanti con forEach()
    })

}

/*Definisco funzione asincrona (async) per salvare il risultato di apiCallFromBackend solo una volta che questa ha terminato tutte le chiamate API asincrone
  e quindi ottenuto e salvato tutti i dati richiesti prima di poter procedere con l'esecuzione del resto del codice in questo file.
  In pratica, questa funzione contiene ed invoca la apiCallFromBackend, senza bisogno di invocarla separatamente, e ne gestisce poi direttamente l'output (il file JSON parsato in oggetto JS), salvandolo 
  e rendendolo utilizzabile anche al di fuori della funzione apiCallFromBackend. E' per questo motivo che questa funzione richiede gli stessi argomenti di cui necessita apiCallFromBackend().
  Il contenuto del JSON parsato e salvato in parsedJason verrà poi utilizzato da due altre funzioni (in base ai casi) definite più avanti: fillMixedContentArray_2ApiCallsVersion e fillMixedContentArray_uniqueApiCallVersion    */

async function saveParsedJson(phpProxyPath, urlSrcKeyValue) {
    try {
        //prendi il jsonTurnedintoJS risolto da apiCallFromBackend una volta che le chiamate API sono terminate e mettilo dentro a questa variabile
        let parsedJson = await apiCallFromBackend(phpProxyPath, urlSrcKeyValue);
        console.log(parsedJson);
        // Se non usassi return, non mi sarebbe possibile salvare il parsed JSON ottenuto con la chiamata API in una variabile esterna a questa funzione async
        return parsedJson;
    }
    catch (error) {
        console.error("Errore nella chiamata API: ", error)
    }
}

/* Definisco ora la funzione per salvare in variabili esterne le liste di movies e serie tv contenute nei due rispettivi (e diversi) JSON e creare un array con un mix di entrambi per popolare le 
sezioni di contenuti in Homepage. A tal fine, la funzione fa quanto segue:
- salva l'output delle 2 chiamate API (per Movies e tv series, fatte tramite le funzioni saveParsedJson e apiCallFromBackend richiamate della nuova funzione) in 2 nuove variabili (una per salvare il 
JSON parsato con la lista dei Movies e le loro info, l'altra per salvare il JSON parsato con le serie TV)
- popola un array(passato come argomente in quanto creato prima di onvocare la dunzione) con un mix di entrambi i tipi di contenuti ciclando le 2 variabili appena create, e che poi verrà usato come base per
  popolare le sezioni della homepage con un mix di movies e serie tv.
- nel popolare tale array, ho impostato un massimo di 12 elementi (6 movies e 6 tv series) in quanto ogni sezione della Homepage conterrà al massimo 12 locandine.*/

async function fillMixedContentArray_2ApiCallsVersion(varForMovies, urlSrcKeyForMovies, varForTV, urlSrcKeyForSeries, phpProxyFilePath, arrayforMixedContent,) {
    varForMovies = await saveParsedJson(phpProxyFilePath, urlSrcKeyForMovies);
    varForTV = await saveParsedJson(phpProxyFilePath, urlSrcKeyForSeries);

    for (let i = 0; i < 6; i++) {
        arrayforMixedContent.push(varForMovies.results[i]);
        arrayforMixedContent.push(varForTV.results[i]);
    }
}

/* Seconda funzione asincrona per fare la stessa cosa della funzione precedente, ma per le sezioni con contenuti che TMDB ci permette di ottenere (con mix di movies e serie tv) con una singola chiamata API anziché due.
Le differenze di questa funzione con quella precedente sono quindi semplici: meno argomenti, crea una variabile anziché due, la creazione di un array di per sè superflua ma che ci serve per poter ciclare poi 
in modo uguale in tutte le sezioni la funzione successiva tellMovieVsSeriesAndInject e, ovviamente, il limite di elementi nel ciclo for è 12 anziché 6 (x2), perché l'unica variabile creata contiene già un mix 
di movies e serie tv*/

async function fillMixedContentArray_uniqueApiCallVersion(varForMoviesAndTV, urlSrcKeyForMoviesAndTV, phpProxyFilePath, arrayforMixedContent) {
    varForMoviesAndTV = await saveParsedJson(phpProxyFilePath, urlSrcKeyForMoviesAndTV);

    for (let i = 0; i < 12; i++) {
        arrayforMixedContent.push(varForMoviesAndTV.results[i]);
    }
}

/*Definisco, infine, una funzione che:
  - prende l'array creato con una delle due funzioni precedenti (cioè oggetti movies e tv series mixati insieme)
  - crea variabili con le info chiave:valore contenute nell'array 
  - cicla ciascun oggetto contenuto nell'array e dando alle variabili create il contenuto corrispondente alle chiavi:valore per ciascun oggetto
  - per ciascun ciclo, inietta il codice html nella homepage (in pratica: la locandina di ciascun movie o serie ciclata con questa funzione e contenuta nell'array di riferiemento)
  - nel fare ciò, tiene conto della diversità delle chiavi di valore diverse per movies e serie tv usate da TMDB, prevedendo due blocchi di codice html diverso per movies e tv series.
  Questa funzione, per come è strutturata, presuppone un utilizzo in coppia con forEach() (vedi es. di tmdbVideoData.forEach(contentObject) nel codice per la pagina index.php 
  
  //N.B. il codice che segue avrebbe potuto essere ridotto di molto usando operatore ?? per dara a variabile conentnete il titolo un contenuto diversi in basse alla chiave trovata (title vs name), e
    conseguentemente avrei potuto usare un unico blocco di codice HTML da iniettare anziché due. PERCHE' NON L'HO FATTO? Perchè ho bisogno che la query string nell'href sia diversa per movies e tv series
    (&movie-title vs &tvseeries-title), perché su questa differenza si basa poi tutto l'impianto di chiamate API diverse al momento di caricare i dettagli del contenuto nella pagina details. php
  */

function tellMovieVsSeriesAndInject(referenceInfoContainer, arrayObject, rowToFill) {

    //se array di riferimento (referenceInfoContainer) non è vuoto, allora procedi
    if (referenceInfoContainer.length > 0) {

        let posterCover = arrayObject.poster_path; // poster_path è chiave per immagine di copertina 
        let contentId = arrayObject.id; //id del contenuto per inserirlo nell'url del link (servirà per pagina details.php)
        let movieTitle = arrayObject.title; //per titoli movie chiave JSON è title
        let tvTitle = arrayObject.name; //per titoli tv series chiave JSON è, invece, name

        //Se c'è un'immagine di copertina
        if (posterCover) {
            //Se è un movie (se in JSON la chiave del titolo è 'title'), inietta questo html 
            if (movieTitle) {
                rowToFill.innerHTML += `
                    <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2">
                        <a href="details.php?content-id=${contentId}&movie-title=${movieTitle}">
                            <img src="https://image.tmdb.org/t/p/w500${posterCover}" alt="${movieTitle}">
                        </a>
                    </div>`;
            }
            //Se invece è una serie tv (se in JSON la chiave del titolo è 'name'), inietta questo html 
            else {
                rowToFill.innerHTML += `
                    <div class="col mx-auto py-2 py-md-0 col-6 col-md-4 col-lg-2">
                        <a href="details.php?content-id=${contentId}&tvseries-title=${tvTitle}">
                            <img src="https://image.tmdb.org/t/p/w500${posterCover}" alt="${tvTitle}">
                        </a>
                    </div>`;
            }
        }
    }
}


// Una volta definite le funzioni qui sopra, dico a JS cosa fare nel momento in cui si carica la pagina, distinguendo tra pagina index.php e details.php

/*Codice preliminare: pulisco url per estrarre solo nome pagina (salvandola in currentUrl) e rendere più gestibile il codice che segue */
const currentUrl = window.location.pathname.replace('/mindflix_api_last/', ''); //cambia percorso se main folder ha nome diverso
console.log("Current page: " + currentUrl);

//Event listener per avviare codice al caricamento della pagina
//Rendo asincrona la funzione dell'addEvetListener così da poter invocare al suo interno, tramite 'await', le funzioni asincrone definite sopra ed evitare che il codice JS 
//successivo alla loro invocazione continui ad essere eseguito prima che tali funzioni abbiano avuto il tempo di restituire i dati richiesti (asincronia chiamate API)

window.addEventListener('load', async function () {

    //Definisco costante con percorso del file 'proxy PHP' per chiamate API in backend, uguale per tutte le chiamate API che andremo a fare tramite funzione apiCallFromBackend
    //N.B. = modificare se nome file proxy o suo percorso cambiano.
    const phpProxyFilePath = "./php/api_private_request.php";

    /* HOMEPAGE (intero catalogo Mindflix):
       1) svuoto contentuo dei div con classe .row_for_api nel container .catalogue della homepage
       2) per ciascuna sezione del catalogo in Homepage (Most Popular, Trending, etc), definisco variabili con nomi ad hoc e le uso come argomenti da 
          passare alle varie funzioni definite in precedenza e che invocheremo qui per ciascuna sezione per effettuare le chimaate API necessarie a ottenere 
          le info dei contenuti e iniettare il codice HTML per rendere le locandine visibili e cliccabili.
    */

    if (currentUrl === 'index.php' || currentUrl === '') {
        let mindflixCatalogues = document.querySelectorAll('.row_for_api'); // creo array con tutti div .row in pagina index
        mindflixCatalogues.forEach((mindflixCatalogue) => { mindflixCatalogue.innerHTML = " " }); // svuoto tutto il contenuto di ogni .row_for_api

        //Riempi sezione Most Popular 
        let mostPopularRow = document.querySelector('.most-popular');
        let urlSrcKeyPopMovies = `?for-most-popular-movie=yes`;
        let urlSrcKeyPopSeries = `?for-most-popular-series=yes`;
        let mostPopularArray = []; //inizializzo variabile che conterrà array mix di most popular movies e most popular series
        let mostPopularMovies; // creo una variabile non inizializzata che conterrà json con dei most popular movies dopo aver invocato la funzione MixedContentArray_2ApiCallsVersion
        let mostPopularSeries; // creo una variabile non inizializzata che conterrà json dei most popular tv series dopo aver invocato la funzione MixedContentArray_2ApiCallsVersion

        //Invoco funzione per salvare JSON di Movies e serie TV in due variabili definite sopra e salvare un mix di titoli (6 movies e 6 Serie TV) nell'array che poi verrà ciclato da tellMovieVsSeriesAndInject
        //per iniettare lHTML con le informazioni ottenute dalle chiamate API nella Homepage
        await fillMixedContentArray_2ApiCallsVersion(mostPopularMovies, urlSrcKeyPopMovies, mostPopularSeries, urlSrcKeyPopSeries, phpProxyFilePath, mostPopularArray);

        console.log(mostPopularArray);

        //Inietto HTML con funzione tellMovieVsSeriesAndInject attingendo con ciclo forEach dai blocchi di informazioni in mostPopularArray relativo a Movies e Serie TV
        mostPopularArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(mostPopularArray, contentObject, mostPopularRow);
        });


        //Riempi sezione Trending
        let trendingRow = document.querySelector('.trending');
        let urlSrcKeyTrendingAll = `?for-trending-videos=yes`;
        let trendingContentsJson;
        let trendingContentsArray = []; //inizializzo variabile che conterrà il json con tutti i movie E serie TV del momento 

        //In questa sezione posso invocare fillMixedContentArray_uniqueApiCallVersion anziché la funzione fillMixedContentArray_2ApiCallsVersion dal momento che, per i titoli di tendenza (trending),
        //TMDB consente di fare una chiamata UNICA per movies e tv serie
        await fillMixedContentArray_uniqueApiCallVersion(trendingContentsJson, urlSrcKeyTrendingAll, phpProxyFilePath, trendingContentsArray);

        //Inietto HTML con funzione tellMovieVsSeriesAndInject attingendo con ciclo forEach dai blocchi di informazioni in trendingContentsArray relativo a Movies e Serie TV
        trendingContentsArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(trendingContentsArray, contentObject, trendingRow);
        });


        //Riempi sezione Recently Added 
        let recAddRow = document.querySelector('.recently-added');
        let urlSrcKeyRecAddMovies = `?for-recently-added-movie=yes`;
        let urlSrcKeyRecAddSeries = `?for-recently-added-series=yes`;
        let recAddArray = [];
        let recAddMovies;
        let recAddSeries;

        await fillMixedContentArray_2ApiCallsVersion(recAddMovies, urlSrcKeyRecAddMovies, recAddSeries, urlSrcKeyRecAddSeries, phpProxyFilePath, recAddArray);

        console.log(recAddArray);

        recAddArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(recAddArray, contentObject, recAddRow);
        });


        //Riempi sezione TV Sci-Fi & Fantasy
        let scifiFantasyRow = document.querySelector('.scifi-and-fantasy');
        let urlSrcKeyScifiFantasySeries = `?for-scifi-fantasy-series=yes`;
        let scifiFantasyArray = [];
        let scifiFantasySeries;

        await fillMixedContentArray_uniqueApiCallVersion(scifiFantasySeries, urlSrcKeyScifiFantasySeries, phpProxyFilePath, scifiFantasyArray);

        scifiFantasyArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(scifiFantasyArray, contentObject, scifiFantasyRow);
        });


        //Riempi sezione Actione & Adventure
        let actionAdventureRow = document.querySelector('.action-adventure');
        let urlSrcKeyActAdventMovies = `?for-action-adventure-movie=yes`;
        let urlSrcKeyActAdventSeries = `?for-action-adventure-series=yes`;
        let actAdventArray = [];
        let actAdventMovies;
        let actAdventSeries;

        await fillMixedContentArray_2ApiCallsVersion(actAdventMovies, urlSrcKeyActAdventMovies, actAdventSeries, urlSrcKeyActAdventSeries, phpProxyFilePath, actAdventArray);

        console.log(actAdventArray);

        actAdventArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(actAdventArray, contentObject, actionAdventureRow);
        });


        //Riempi sezione Animation
        let animationRow = document.querySelector('.animation');
        let urlSrcKeyAnimationMovies = `?for-animation-movie=yes`;
        let urlSrcKeyAnimationSeries = `?for-animation-series=yes`;
        let animationArray = [];
        let animationMovies;
        let animationSeries;

        await fillMixedContentArray_2ApiCallsVersion(animationMovies, urlSrcKeyAnimationMovies, animationSeries, urlSrcKeyAnimationSeries, phpProxyFilePath, animationArray);

        console.log(animationArray);

        animationArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(animationArray, contentObject, animationRow);
        });


        //Riempi sezione Documentary
        let documentaryRow = document.querySelector('.documentary');
        let urlSrcKeyDocumentaryMovies = `?for-documentary-movie=yes`;
        let urlSrcKeyDocumentarySeries = `?for-documentary-series=yes`;
        let documentaryArray = [];
        let documentaryMovies;
        let documentarySeries;

        await fillMixedContentArray_2ApiCallsVersion(documentaryMovies, urlSrcKeyDocumentaryMovies, documentarySeries, urlSrcKeyDocumentarySeries, phpProxyFilePath, documentaryArray);

        console.log(documentaryArray);

        documentaryArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(documentaryArray, contentObject, documentaryRow);
        });
    }

    /* DETAILS PAGE
       Faremo due chiamate API in questa pagina, sempre in backend e sempre tramite funzione apiCallFromBackend: 
       1) una per popolare tutti i campi relativi al film/serie TV che abbiamo scelto nella Homepage e che ora vogliamo vedere in questa pagina (inclusi video
          Youtube, se i relativi indirizzi sono presenti nel JSON)
       2) una per i suggerimenti di film/serie appartenenti agli stessi generi del film/serie che abbiamo selezionato (faremo chiamate API per i primi 3 generi
          ai quale appartiente il film secondo la catalogazione TMDB, suggerendo max 2 video per genere settando dei limiti nel ciclo forEach creato a tale scopo).
          Per questo punto 2 ho usato un nuovo strumento di JS che non conoscevo - Set() - per evitare doppioni tra i titoli suggeriti.
       Se il file JSON relativo al film/serie visualizzato in questa pagina non contiene link a video Youtube (es. trailer etc.) o non ci sono generi indicati, e quindi
       non siamo in grado di recuperare tali elementi/suggerimenti, le rispettive sezioni della pagina verranno nascoste anziché essere mostrate senza contenuti.
       Infine, il tutto verrà fatto tenendo conto delle differenze relative alle keyword nei file JSON per film e serie TV.
    */
    else if (currentUrl == 'details.php') {

        /* 
        Creo variabili per estrarre valori contenuti nelle query string dell'url della pagina details, 
        a sua volta definito dai blocchi di codice HTML iniettati tramite il codice JS definito per la Homepage: 
        */

        const urlParams = new URLSearchParams(window.location.search); //prendi contenuto della barra URL del browser
        const urlIdValue = urlParams.get('content-id'); //estrapola valore del parametro 'content-id' da url
        console.log(typeof (urlIdValue));
        const urlMovieValue = urlParams.get('movie-title'); //estrapola valore del parametro 'movie-title' da url (se presente)
        const urlTvValue = urlParams.get('tvseries-title'); //estrapola valore del parametro 'tvseries-title' da url (se presente)

        console.log('Parametro id contenuto nell\'url: ' + urlIdValue);
        console.log('Parametro titolo movie (undefined se non movie) nell\'url: ' + urlMovieValue);
        console.log('Parametro titolo serie TV (undefined se non serie TV) nell\'url: ' + urlTvValue);

        //Creo variabili per selezionare gli elementi html della pagina details.php che riempiremo poi in modo dinamico con chiamata API
        //Slider:
        let detailTitle = document.getElementById('details-title');
        console.log(typeof (detailTitle));
        let detailReleaseDate = document.getElementById('details-date');
        let synopsis = document.getElementById('details-synopsis');
        let detailCast = document.getElementById('details-cast');
        //Youtube section:
        let rowDetail1 = document.querySelector('.row1');
        let videoClipSection = document.querySelector('.category1');
        //Similar content section:            
        let rowDetail2 = document.querySelector('.row2');



        //Distinguo se nella pagina details ho caricato un film o una serie in base alle diverse query string presenti nell'url della pagina details.php.
        //Ci servirà per passare i parametri giusti al file proxy php affinché possa usare l'url corretto per la chiamate API in backend
        if (urlMovieValue) {
            var urlSrcKeyValue = `?movie-title=${encodeURIComponent(urlMovieValue)}&content-id=${urlIdValue}`;
        }
        else {
            var urlSrcKeyValue = `?tvseries-title=${encodeURIComponent(urlTvValue)}&content-id=${urlIdValue}`;
        }


        //Istanzio variabile tmdbVideoData attribuendogli come valore l'output di saveParsedJson(), ovvero il parsed JSON conenente tutti i dati del movie (o serie tv) visualzzato in details.php
        let tmdbVideoData = await saveParsedJson(phpProxyFilePath, urlSrcKeyValue);

        console.log("This is tmdbVideoData content for detail page: " + tmdbVideoData);
        console.log(tmdbVideoData);

        // Controllo: se id nell'url = id del video specificato nel JSON di tmdbVideoData, allora riempi campi nello slider della pagina details con i dati salvati in tmdbVideoData
        if (parseInt(urlIdValue) === tmdbVideoData.id) {
            // operatore di coalescenza in base alla struttura del json salvato in tmdbVideoData ('title' se si tratta di movie, 'name' se si tratta di tv series):
            detailTitle.innerText = tmdbVideoData.title ?? tmdbVideoData.name ?? "Title not available";

            /* 
            Popolo il campo per l'anno di uscita | generi del film/serie nello slider:
            - data: combo data da new Date() + getFullYear() per estrapolare solo anno da formato data contenuto in JSON
            - generi: slice() per considerare max prime 3 chiavi 'genres' (o meno, se non ce ne sono 3, senza generare errori); poi prendi i valori di 'name' all'interno delle 3 chiavi genres disponibili, mettili 
              in un array 'genre' creato con la funzione map(), poi metti i 3 valori di quell'array dentro un unica stringa con join() separandoli con ',' e inietta questa stringa in html:
            */
            detailReleaseDate.innerText = new Date(tmdbVideoData.release_date ?? tmdbVideoData.first_air_date).getFullYear() + " | " + tmdbVideoData.genres.slice(0, 3).map(genre => genre.name).join(', ');
            console.log(tmdbVideoData.genres.slice(0, 3));

            //Popolo sezione della sinossi nello slider:
            synopsis.innerText = tmdbVideoData.overview.substring(0, 240) + "...";

            /*Popolo lo spazio per i (max) 3 attori principali del film:
            - considera al massimo le prime 3 chiavi 'cast' all'interno di credits (o meno, se non ce ne sono 3); 
            - poi prendi i  valori di 'name' all'interno delle 3 chiavi 'cast' disponibili, mettili in un array 'actor' creato con la funzione map(), 
            - poi metti i 3 valori di quell'array dentro un unica stringa con join() separandoli con ',' e inietta questa stringa in html:
            */
            detailCast.innerHTML = "<span>Starring: </span>" + tmdbVideoData.credits.cast.slice(0, 3).map(actor => actor.name).join(', ');

            //Aggiungo background image a slider modificando la proprietà background-image del selettore css in style.css:
            if (MAINSTYLESHEET) {
                //Per evitare errori di caricamento pagina nel caso in cui la sezione backdrops del JSON (quella che ha le immagini di riferimento per lo slider) il contenuto della
                //alla variabile customBackground viene definito da un operatore ternario: se sezione backdropps contiene qualcosa, prendi immagine del primo risultato. Altrimenti 
                //prendi prima immagine della sezione JSON (la sezione posters) che viene immediatamente dopo a backdrops (opzione di fallback):
                let customBackground = tmdbVideoData.images.backdrops.length > 0 ? tmdbVideoData.images.backdrops[0].file_path : tmdbVideoData.images.posters[0].file_path;
                if (customBackground) {
                    console.log("My custom background: " + customBackground);
                    document.querySelector("#dtl-page-slider").style.backgroundImage = `url("https://image.tmdb.org/t/p/original${customBackground}")`;
                } else {
                    console.log("No background image availabel for the slider section. TMDB didn't provide it.")
                }
            }
        }

        //Se in JSON ci sono chiavi per video Youtube (trailer, etc.), suggeriscine max 5 e iniettane il codice HTML nella relativa sezione della pagina:
        if (tmdbVideoData.videos.results.length > 0) {

            let videoSelection = tmdbVideoData.videos.results.slice(0, 5);
            rowDetail1.innerHTML = " ";

            for (let i = 0; i < videoSelection.length; i++) {
                let sampleVideo = videoSelection[i].key;
                console.log(sampleVideo);
                rowDetail1.innerHTML += `
                                    <div class="col py-2 py-md-0 col-6 col-md-4 col-lg-2">
                                         <iframe width="100%" height="auto" src="https://www.youtube-nocookie.com/embed/${sampleVideo}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                         </div>
                                    `;
            }
        }
        else { // altrimenti nascondi tutta sezione Video Clip della pagina per i suggerimenti Youtube
            videoClipSection.innerHTML = " ";
        }

        //Se nel JSON ci sono i generi del film/serie, prendi i gli id identificativi dei primi 4 generi e, tramite cicli forEach,
        //fai chiamata API per ottenere il JSON con la lista di titoli di ciascuno dei 4 generi e restituisci max 2 titoli di suggerimento per ciascun genere:
        if (tmdbVideoData.genres.length > 0)
            rowDetail2.innerHTML = " ";

        /* 
        Creo variabile alreadySuggested contenente un Set() che conterrà i titolo dei film già suggeriti per evitare di suggerire due volte lo stesso film se
        il suo titolo appare in più generi di film (vedi ciclo for più sotto).
        Questa variabile deve essere posizionata PRIMA del ciclo forEach() e del ciclo for(), altrimenti il controllo dei titoli doppi verrebbe fatto solo entro 
        un singolo genere di film e non tra i risultati di tutti i generi selezionati:
        */
        var alreadySuggested = new Set();

        console.log("Fin qui tutto bene 1");

        // Considera solo primi 4 generi (max) elencati in genres:
        for (i = 0; i < Math.min(4, tmdbVideoData.genres.length); i++) {

            let videoSuggestion = tmdbVideoData.genres[i].id;

            //Anche qui, dobbiamo distingiere se nella pagina details abbiamo caricato un film o una serie, perché
            // dovremo passare i parametri giusti al proxy php in modo che possa usare l'url corretto per queste chiamate:
            if (videoSuggestion) {
                // se la pagina details in cui ci troviamo è quella relativa a un movie:
                if (urlMovieValue) {
                    urlSrcKeyValue = `?movie-title=${urlMovieValue}&with_genres=${videoSuggestion}`;
                }
                //se invece la pagina details caricata è quella relativa a una serie tv:
                else {
                    urlSrcKeyValue = `?tvseries-title=${urlTvValue}&with_genres=${videoSuggestion}`;
                }

                console.log("Fin qui tutto bene 2");

                let tmdbVideoData = await saveParsedJson(phpProxyFilePath, urlSrcKeyValue);

                console.log("Fin qui tutto bene 3");

                if (tmdbVideoData.results.length > 0) {
                    for (let i = 0; i < 4; i++) {// max 4 suggerimenti per genere (quindi max 6 suggerimenti di film in questa sezione della pagina)
                        let suggestedVideoId = tmdbVideoData.results[i].id;
                        //Operatore coalescente ('??') per trovare il titolo a seconda che il JSON ricevuto sia riferito a MOVIE ('title') o SERIE TV ('name')
                        let suggestedVideoTitle = tmdbVideoData.results[i].original_title ?? tmdbVideoData.results[i].name;
                        let suggestedVideoImg = tmdbVideoData.results[i].poster_path;

                        /* se il titolo del film/serie da suggerire appena trovato è già stato precedentmente aggiunto al Set() di alreadySuggested oppure se
                           nel file json non viene trovata ALCUNA immagine di copertina (suggestedVideoImg), allora non fare più niente (cioè, non inserire la 
                           string template qui sotto alla pagina html) e passa direttamente (continue) al prossimo elemento da ciclare con for:
                        */
                        if (alreadySuggested.has(suggestedVideoTitle) || suggestedVideoImg == null) {
                            continue;
                        }

                        /*
                        Se invece il titolo del film/serie trovato e da suggerire non è ancora stato aggiunto al Set() di alreadySuggested,
                        allora aggiungilo al Set() e poi inietta il codice HTML nella pagina:
                        */
                        alreadySuggested.add(suggestedVideoTitle);

                        console.log("Fin qui tutto bene 4");

                        if (tmdbVideoData.results[i].original_title) {
                            rowDetail2.innerHTML += `
                                                        <div class="col py-2 py-md-0 col-6 col-md-4 col-lg-2">
                                                            <a href="details.php?content-id=${suggestedVideoId}&movie-title=${suggestedVideoTitle}">
                                                                <img src="https://image.tmdb.org/t/p/w200${suggestedVideoImg}" alt="${suggestedVideoTitle}">
                                                            </a>
                                                        </div>`;
                        }
                        // se invece è una serie tv (campo name anziché original_title nel JSON):
                        else {
                            rowDetail2.innerHTML += `
                                             <div class="col py-2 py-md-0 col-6 col-md-4 col-lg-2">
                                                 <a href="details.php?content-id=${suggestedVideoId}&tvseries-title=${suggestedVideoTitle}">
                                                     <img src="https://image.tmdb.org/t/p/w200${suggestedVideoImg}" alt="${suggestedVideoTitle}">
                                                 </a>
                                             </div>`;
                        }
                    }
                }
            }
        }
    }
    else if (currentUrl == 'movies.php') {

        //SLIDER
        let detailTitle = document.getElementById('details-title');
        let detailReleaseDate = document.getElementById('details-date');
        let synopsis = document.getElementById('details-synopsis');
        let detailCast = document.getElementById('details-cast');
        let MAINSTYLESHEET = document.styleSheets[0];

        //Ricavo dinamicamente il titolo del primo film della list dei film recenti in TMDB
        let urlSrcKeyRecentMovieForSlider = `?for-recently-added-movie=yes`;
        let sliderVideoPick = await saveParsedJson(phpProxyFilePath, urlSrcKeyRecentMovieForSlider);

        //Una volta estratto il titolo, faccio chiamata specifica per quel film e per prendermi tutti i dettagli
        if (sliderVideoPick) {
            var urlSrcKeyValueForMovieSlider = `?movie-title=${sliderVideoPick.results[0].title}&content-id=${sliderVideoPick.results[0].id}`;
            let sliderVideoData = await saveParsedJson(phpProxyFilePath, urlSrcKeyValueForMovieSlider);

            //A questo punto, popolo le parti dello slider con i dati del film 
            if (sliderVideoData) {
                detailTitle.innerText = sliderVideoData.title ? sliderVideoData.title : "Title not available";
                detailReleaseDate.innerText = new Date(sliderVideoData.release_date).getFullYear() + " | " + sliderVideoData.genres.slice(0, 3).map(genre => genre.name).join(', ');
                console.log(sliderVideoData.genres.slice(0, 3));
                synopsis.innerText = sliderVideoData.overview.substring(0, 240) + "...";
                detailCast.innerHTML = "<span>Starring: </span>" + sliderVideoData.credits.cast.slice(0, 3).map(actor => actor.name).join(', ');

                //Aggiungo background image a slider modificando la proprietà background-image del selettore css in style.css:
                if (MAINSTYLESHEET) {
                    let customBackground = sliderVideoData.images.backdrops.length > 0 ? sliderVideoData.images.backdrops[0].file_path : sliderVideoData.images.posters[0].file_path;
                    if (customBackground) {
                        console.log("My custom background: " + customBackground);
                        document.querySelector("#dtl-page-slider").style.backgroundImage = `url("https://image.tmdb.org/t/p/original${customBackground}")`;
                    } else {
                        console.log("No background image availabel for the slider section. TMDB didn't provide it.")
                    }
                }
            }
        }

        //POPOLO SEZIONI DEI VARI GENERI DI FILM (per comodità uso stesse categorie di Homepage, per soli movies, ad eccezione della sezione Western)
        //Riempi sezione Trending
        let trendingRow = document.querySelector('.trending');
        let urlSrcKeyTrendingMovies = `?for-trending-movie=yes`;
        let trendingMoviesJson;
        let trendingMoviesArray = [];

        await fillMixedContentArray_uniqueApiCallVersion(trendingMoviesJson, urlSrcKeyTrendingMovies, phpProxyFilePath, trendingMoviesArray);

        //Inietto HTML con funzione tellMovieVsSeriesAndInject attingendo con ciclo forEach dai blocchi di informazioni in trendingContentsArray relativo a Movies e Serie TV
        trendingMoviesArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(trendingMoviesArray, contentObject, trendingRow);
        });


        //Riempi sezione Movies Recently Added 
        let recAddRow = document.querySelector('.recently-added');
        let urlSrcKeyRecAddMovies = `?for-recently-added-movie=yes`;
        let recAddArray = [];
        let recAddMovies;

        await fillMixedContentArray_uniqueApiCallVersion(recAddMovies, urlSrcKeyRecAddMovies, phpProxyFilePath, recAddArray);

        console.log(recAddArray);

        recAddArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(recAddArray, contentObject, recAddRow);
        });


        //Riempi sezione Movies Western
        let scifiWesternRow = document.querySelector('.western');
        let urlSrcKeyWesternMovies = `?for-western-movie=yes`;
        let westernArray = [];
        let westernMovies;

        await fillMixedContentArray_uniqueApiCallVersion(westernMovies, urlSrcKeyWesternMovies, phpProxyFilePath, westernArray);

        westernArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(westernArray, contentObject, scifiWesternRow);
        });


        //Riempi sezione Movies Actione & Adventure
        let actionAdventureRow = document.querySelector('.action-adventure');
        let urlSrcKeyActAdventMovies = `?for-action-adventure-movie=yes`;
        let actAdventArray = [];
        let actAdventMovies;

        await fillMixedContentArray_uniqueApiCallVersion(actAdventMovies, urlSrcKeyActAdventMovies, phpProxyFilePath, actAdventArray);

        console.log(actAdventArray);

        actAdventArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(actAdventArray, contentObject, actionAdventureRow);
        });


        //Riempi sezione Movies Animation
        let animationRow = document.querySelector('.animation');
        let urlSrcKeyAnimationMovies = `?for-animation-movie=yes`;
        let animationArray = [];
        let animationMovies;

        await fillMixedContentArray_uniqueApiCallVersion(animationMovies, urlSrcKeyAnimationMovies, phpProxyFilePath, animationArray);

        console.log(animationArray);

        animationArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(animationArray, contentObject, animationRow);
        });


        //Riempi sezione Movies Documentary
        let documentaryRow = document.querySelector('.documentary');
        let urlSrcKeyDocumentaryMovies = `?for-documentary-movie=yes`;
        let documentaryArray = [];
        let documentaryMovies;

        await fillMixedContentArray_uniqueApiCallVersion(documentaryMovies, urlSrcKeyDocumentaryMovies, phpProxyFilePath, documentaryArray);

        console.log(documentaryArray);

        documentaryArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(documentaryArray, contentObject, documentaryRow);
        });

    }

    else if (currentUrl == 'tvseries.php') {

        //SLIDER
        let detailTitle = document.getElementById('details-title');
        let detailReleaseDate = document.getElementById('details-date');
        let synopsis = document.getElementById('details-synopsis');
        let detailCast = document.getElementById('details-cast');

        //Ricavo dinamicamente il titolo della prima serie TV della lista delle serie tv recenti in TMDB
        let urlSrcKeyRecentTVForSlider = `?for-recently-added-series=yes`;
        let sliderVideoPick = await saveParsedJson(phpProxyFilePath, urlSrcKeyRecentTVForSlider);

        //Una volta estratto il titolo, faccio chiamata specifica per quella serie tv e per prendermi tutti i dettagli
        if (sliderVideoPick) {
            var urlSrcKeyValueForSeriesSlider = `?tvseries-title=${sliderVideoPick.results[0].name}&content-id=${sliderVideoPick.results[0].id}`;
            let sliderVideoData = await saveParsedJson(phpProxyFilePath, urlSrcKeyValueForSeriesSlider);

            //A questo punto, popolo le parti dello slider con i dati del film 
            if (sliderVideoData) {
                detailTitle.innerText = sliderVideoData.name ? sliderVideoData.name : "Title not available";
                detailReleaseDate.innerText = new Date(sliderVideoData.first_air_date).getFullYear() + " | " + sliderVideoData.genres.slice(0, 3).map(genre => genre.name).join(', ');
                console.log(sliderVideoData.genres.slice(0, 3));
                synopsis.innerText = sliderVideoData.overview.substring(0, 240) + "...";
                detailCast.innerHTML = "<span>Starring: </span>" + sliderVideoData.credits.cast.slice(0, 3).map(actor => actor.name).join(', ');

                //Aggiungo background image a slider modificando la proprietà background-image del selettore css in style.css:
                if (MAINSTYLESHEET) {
                    let customBackground = sliderVideoData.images.backdrops.length > 0 ? sliderVideoData.images.backdrops[0].file_path : sliderVideoData.images.posters[0].file_path;
                    if (customBackground) {
                        console.log("My custom background: " + customBackground);
                        document.querySelector("#dtl-page-slider").style.backgroundImage = `url("https://image.tmdb.org/t/p/original${customBackground}")`;
                    } else {
                        console.log("No background image availabel for the slider section. TMDB didn't provide it.")
                    }
                }
            }
        }


        //POPOLO SEZIONI DEI VARI GENERI DI SERIE TV (per comodità uso stesse categorie di Homepage, per sole serie tv)

        //Riempi sezione TV Trending
        let trendingRow = document.querySelector('.trending');
        let urlSrcKeyTrendingSeries = `?for-trending-series=yes`;
        let trendingSeriesJson;
        let trendingSeriesArray = [];

        await fillMixedContentArray_uniqueApiCallVersion(trendingSeriesJson, urlSrcKeyTrendingSeries, phpProxyFilePath, trendingSeriesArray);

        trendingSeriesArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(trendingSeriesArray, contentObject, trendingRow);
        });


        //Riempi sezione TV Recently Added 
        let recAddRow = document.querySelector('.recently-added');
        let urlSrcKeyRecAddSeries = `?for-recently-added-series=yes`;
        let recAddArray = [];
        let recAddSeries;

        await fillMixedContentArray_uniqueApiCallVersion(recAddSeries, urlSrcKeyRecAddSeries, phpProxyFilePath, recAddArray);

        console.log(recAddArray);

        recAddArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(recAddArray, contentObject, recAddRow);
        });


        //Riempi sezione TV Sci-Fi & Fantasy
        let scifiWesternRow = document.querySelector('.scifi-and-fantasy');
        let urlSrcKeyWesternSeries = `?for-scifi-fantasy-series=yes`;
        let westernArray = [];
        let westernSeries;

        await fillMixedContentArray_uniqueApiCallVersion(westernSeries, urlSrcKeyWesternSeries, phpProxyFilePath, westernArray);

        westernArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(westernArray, contentObject, scifiWesternRow);
        });


        //Riempi sezione TV Actione & Adventure
        let actionAdventureRow = document.querySelector('.action-adventure');
        let urlSrcKeyActAdventSeries = `?for-action-adventure-series=yes`;
        let actAdventArray = [];
        let actAdventSeries;

        await fillMixedContentArray_uniqueApiCallVersion(actAdventSeries, urlSrcKeyActAdventSeries, phpProxyFilePath, actAdventArray);

        console.log(actAdventArray);

        actAdventArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(actAdventArray, contentObject, actionAdventureRow);
        });


        //Riempi sezione TV Animation
        let animationRow = document.querySelector('.animation');
        let urlSrcKeyAnimationSeries = `?for-animation-series=yes`;
        let animationArray = [];
        let animationSeries;

        await fillMixedContentArray_uniqueApiCallVersion(animationSeries, urlSrcKeyAnimationSeries, phpProxyFilePath, animationArray);

        console.log(animationArray);

        animationArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(animationArray, contentObject, animationRow);
        });


        //Riempi sezione TV Documentary
        let documentaryRow = document.querySelector('.documentary');
        let urlSrcKeyDocumentarySeries = `?for-documentary-series=yes`;
        let documentaryArray = [];
        let documentarySeries;

        await fillMixedContentArray_uniqueApiCallVersion(documentarySeries, urlSrcKeyDocumentarySeries, phpProxyFilePath, documentaryArray);

        console.log(documentaryArray);

        documentaryArray.forEach((contentObject) => {
            tellMovieVsSeriesAndInject(documentaryArray, contentObject, documentaryRow);
        });

    }

    /*IMPROVE - PAGINA ACCOUNT SETTINGS - USATO ELSE IF ANCHE QUI X MIGLIORARE LE PRESTAZIONI MA VALUTA CODE SPLITTING */
    else if (currentUrl === 'account-settings.php') {

        const settingsLeftTabs = document.querySelector('.nav-pills');
        const settingsRighContent = document.querySelector('.tab-content');
        const settingsTab = document.querySelectorAll('.interactive-tab');
        const settingsContent = document.querySelectorAll('.tab-pane');
        const arrowIcon = document.querySelectorAll('.bi-arrow-left-circle');

        //Se uso querySelectorAll per seelzionare tutti i tag con una certa classe, la variabile che creo
        //non contenite un singolo nodo del DOM, bensì un array con tutti i nodi che hanno quella classe.
        //Ecco perché qui sotto devo usare forEach se voglio far funzionare l'addEventListener: deve
        //iterare tutti gli elementi dell'array per capire a quele è stata affiunta la classe 'active' indicata nella
        //condizione if:
        settingsTab.forEach((tab) => { //per ogni elemento .interactive-tab contenuto in settingsTab
            tab.addEventListener('click', function () {
                if (tab.classList.contains('active') ) {
                    settingsLeftTabs.classList.add('hidden');
                    settingsRighContent.classList.add('grow');
                }

            })
        })

        //Stesse considerazioni riportate sopra per quanto riguarda l'uso di forEach:
        arrowIcon.forEach(icon => {
            icon.addEventListener('click', function () {
                if (settingsLeftTabs.classList.contains('hidden')) {
                    settingsLeftTabs.classList.remove('hidden');
                    settingsRighContent.classList.remove('grow');
                }

            })
        })

    }

})


/*PAGINA  */