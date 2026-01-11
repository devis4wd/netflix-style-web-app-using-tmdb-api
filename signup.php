<?php
//Riabilitare queste due righe per vedere errori se serve fare debugging
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// session_start() va sempre all'inizio del codice PHP
session_start();

//Controlliamo se utente è già loggato. Se NON lo è: l'utente potrà vedere questa pagina dato che potrebbe aver bisogno di registrarsi.
//Se invece esiste una sessione $_SESSION['loggedin']) e il suo stato è TRUE (= se si è già loggato) non c'è ragione di farlgli vedere questa pagina
//(si è ovviamente già registrato e loggato in precedenza) e quindi redirect automatico a index.html
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE) {
    header('location: index.php');
    exit();
}

//Includo file di connessione DB
require_once('config.php');



//Inizializzo variabili da popolare con dati utente che si registra e che salveranno i dati inseriti in form
$user_name = $user_email = $user_pwd = $confirm_pwd = "";
// creo variabili per gestire errori in fase di inserimento dati in form di registrazione
$name_err = $email_err = $pwd_err = $confirm_pwd_err = $terms_err = $privacy_err = "";

/* ***NOTA BENE*** = non ho bisogno di gestire la colonna 'join_date' della tabella DB registered_users tramite codice PHP o inserendo
input "hidden" con tale valore perché nella tabella del mio DB ho già inserito come valore di default (automatico) per tale campo della tabella
il valore current_timestamp(), che aggiungerà data e ora della creazione del nuovo record automaticamente da DB SQL:)

Inizialmente avevo invece gestito una variabile contenente data/ora di registrazione direttamente da codice PHP dopo il submit dell'utente
assieme agli altri campi del form. Una gestione backend di per sé preferibile (per sicurezza) alla soluzione frontend di usare
un input "hidden". Ma alla fine ho optato per la gestione "super backend" in DB descritta sopra.
*/

// Validiamo i campi di input compilati dall'utente prima di aggiungerli al DB
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Valido campo input_name

    //Questa variabile solo per poter mantenere visibile nel form l'username quando è sbagliato e poterlo correggere secondo messaggi di errore:
    $input_username =  trim($_POST['signup-username']);
    if (empty($input_username)) {
        $name_err = "Please enter a username";
    } //Assicuro che l'username inserito dall'utente (senza spazi) abbia ALMENO una lettera minuscola, una maiuscola e un numero:
    elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $input_username)) {
        $name_err = "Ensure your username contains both upper and lower cases and at least a number.";
    } else {
        $user_name = $input_username;
    }

    //Valido campo input_email
    if (empty(trim($_POST['signup-email']))) {
        $email_err = "Please enter an email address";
    } //Assicuro che l'indirizzo inserito (senza spazi) abbia almeno la srtuttura tipica di un indirizzo email nome@dominio.estensione:
    elseif (!filter_var(trim($_POST['signup-email']), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address";
    } else {
        $user_email = trim($_POST['signup-email']);
    }

    //Valido campo input_pwd

    //Questa variabile solo per poter mantenere "visibile" (con i pallini) nel form la pwd quando è sbagliato e poterlo correggere secondo messaggi di errore
    //oppure quando già rispetta i requisiti settati mas ono sbagliati altri campi del form:
    $input_pwd = trim($_POST['signup-pwd']);

    if (empty($input_pwd)) {
        $pwd_err = "Please choose a password";
    } //Assicuro che pwd inserita da utente (senza spazi) abbia ALMENO una lettera maiuscola, una minuscola, un numero e un carattere sepciale:
    elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[_*#$@!]).+$/', $input_pwd)) {
        $pwd_err = "Ensure your password contains both upper and lowercase letters. Include symbols like @, _, #, * and numbers";
    } //Assicuro che pwd inserita da utente sia lunga almeno 8 caratteri:
    elseif (!strlen($input_pwd) >= 8) {
        $pwd_err = "Ensure your password is at least 8-character long";
    } else {
        $user_pwd = $input_pwd;
    }

    //Valido campo conferma password

    //Questa variabile solo per poter mantenere "visibile" (con i pallini) nel form la confirm_pwd quando è sbagliata e poterla correggere secondo 
    //messaggi di errore oppure quando è giusta ma sono sbagliati altri campi di input nel form:
    $input_confirm_pwd = trim($_POST['signup-confirm-pwd']);

    if (empty($input_confirm_pwd)) {
        $confirm_pwd_err = "Confirm your password";
    } elseif (empty($pwd_err) & $user_pwd !== $input_confirm_pwd) {
        $confirm_pwd_err = "Your confirmation password doesn't match with the password you chose";
    } else {
        $confirm_pwd = $input_confirm_pwd;
    }

    //Valido campo checkbox per Terms of Service
    //Solo controllo se spuntato o no: se non lo sono, utente non completa registrazione (non ho bisogno di salvare valore in una variabile)
    if (empty($_POST['signup-tos'])) {
        $terms_err = "You need to accept our Terms of Service";
    }

    //Valido campo checkbox per Termini Privacy
    //Solo controllo se spuntato o no: se non lo sono, utente non completa registrazione (non ho bisogno di salvare valore in una variabile)
    if (empty($_POST['signup-privacy'])) {
        $privacy_err = "You need to accept our Terms of Service";
    }


    //Una volta validati tutti i campi, prcedo con la creazione dell'utenza in DB (= registrazione vera e propria):

    //Ultimo controllo errori con condizione IF prima di prepared statement per l'invio dei dati a DB:
    if (empty($name_err) && empty($email_err) && empty($pwd_err) && empty($confirm_pwd_err) && empty($terms_err) && empty($privacy_err)) {

        //Prepare statement
        $insert_new_user = "INSERT INTO registered_users (username, email, password) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($db_conn, $insert_new_user)) {

            //Bind
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_email, $param_pwd);
            $param_name = $user_name;
            $param_email = $user_email;
            $param_pwd = password_hash($user_pwd, PASSWORD_DEFAULT); //hasho solo ora la password perchè ha senso farlo qui per minimizzare rischio errore

            //Tento esecuzione di prepared statement. Se va a buon fine significa che il nuovo utente è stato aggiunto a DB e
            //posso reindirizzarlo alla pagina login.php per il primo login:
            if (mysqli_stmt_execute($stmt)) {
                //Redirect
                header('location:login.php');
                exit();

                //Inizialmente avevo deciso di fare in modo che la registrazione fosse anche il primo login, creando in questo blocco di codice (anziché 
                //fare il redirect) le varie superglobali $_SESSION per la sessione di login. Tuttavia, generalmente parlando, questa è una pratica che espone a rischi di 
                //sicurezza, soprattutto se, come in questo caso, non creaimo un ulteriore controllo di verifica dell'indirizzo email prima di 'attivare'
                //il nuovo account (un malintenzionato protrebbe infatti creare un nuovo utente con l'email di altri: dovrebbe solo creare la sua pwd
                //e se la registrazione coincidesse con il primo login senza prima la verifica via email dell'indirizzo usato, accederebbe al nuovo
                //account creato con un'email di altri). Dato che in questo progetto non ho implementato la verifica via email, in realtà sarebeb cambiato 
                //poco fare qui il primo login oppure farlo fare nella pagina login.php, dato che comuque, senza doppio controllo, un malintenzionato farebbe
                //comunque quello che vuole avendo già un indirizzo email altrui. Ma vabbè, mi sono attenuto alla impostazione "classica" questa volta, ovvero
                //pagina di registrazione per sola registrazione e pagina login per il login. 

            } else {
                echo "Something wen wrong during your registration. Please try again.";
            }

            /* LASCIO QUI IL CODICE ORIGINARIAMENTE DA ME CREATO PER BLOCCO CODICE QUI SOPRA, SOPRATTUTTO PER FUNZIONE MYSQLI_INSERT_DB():
                
                //Faccio controllo ulteriore prima di creare $_SESSION: ovvero, se mi sono dimenticato di creare una sessione con
                //session_start() all'inizio del codice, fallo ora:
                if ((session_status() === PHP_SESSION_NONE)) {
                    session_start();
                }

                //Salva id utente appena registrato in superglobale. Funzione mysqli_insert_id($db_conn) restituisce id ultimo record inserito 
                //in tabella registered_users del DB se tale campo è contrassegnato come auto incrementale (e io l'ho impostato così)
                // (fatto a scopo di didattico, in realtà non ho bisogno di id utente per la sessione di login)
                $_SESSION['user_id'] = mysqli_insert_id($db_conn);
                $_SESSION['username'] = $user_name;
                $_SESSION['user_email'] = $user_email;
                //vai a pagina index.php dove utente loggato vedrà suo nome anzichè scritta Sign In nelmenù di navigazione
                header('location: index.php');
                exit();
                } */
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($db_conn);
}
/* Solo per debugging:
else {
    echo "Your data has not been sent. You need to fill in all the form fields.";
} */



//Per header pagina + SEO dinamico titolo e descrizione pagina in header
$description = "Mindflix Sign Up page. Just a personal, non-commercial project to learn web dev";
$title = "Sign Up | Mindflix";
include("php/service-pages-header.php");
?>


<div class="main  d-flex align-items-center justify-content-center">
    <div class="form-container mx-auto  p-4">
        <!-- Attributo novalidate serve a disattivare i controlli standard del browser sul form, che potrebbero attivarsi prima dei controlli custom e quindi
            prevenire la loro corretta visualizzazione. I controlli custom del browser impediscono il submit del form se manca qualche dato contrassegnato
            come REQUIRED, e dal momento che i messaggi di errore custom che abbiamo creato in PHP  si vedono solo DOPO che il form è stato inviato con POST e il
            nostro codice PHP verifica che alcuni campi non sono stati compilati, se non aggiungiamo 'novalidate' il nostro controllo in PHP non funzionerà -->
        <form class="mx-auto" action="http://<?= $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ?>" method="post" novalidate>
            <h3>Sign Up</h3>
            <div class="mb-3 form-floating">
                <input type="text" class="form-control <?= (!empty($name_err)) ? 'is-invalid' : ''; ?>" id="signup-username" name="signup-username"
                    placeholder="Choose your username" value="<?= $input_username; ?>" required>
                <label for="signup-username" class="form-label">Choose your username</label>
                <div class="invalid-feedback">
                    <?= $name_err; ?>
                </div>
            </div>
            <div class="mb-3 form-floating">
                <input type="email" class="form-control <?= (!empty($email_err)) ? 'is-invalid' : ''; ?>" id="signup-email" name="signup-email"
                    aria-describedby="emailHelp" placeholder="Your email here" value="<?= $user_email; ?>" required>
                <label for="signup-email" class="form-label">Email address</label>
                <div class="invalid-feedback">
                    <?= $email_err; ?>
                </div>
            </div>
            <div class="mb-3 form-floating">
                <input type="password" class="form-control <?= (!empty($pwd_err)) ? 'is-invalid' : ''; ?>" id="signup-pwd" name="signup-pwd"
                    placeholder="Your password here" value="<?= $input_pwd; ?>" minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                <label id="signup-pwd-label" for="signup-pwd" class="form-label">Password</label>
                <div class="invalid-feedback">
                    <?= $pwd_err; ?>
                </div>
            </div>
            <div class="mb-3 form-floating">
                <input type="password" class="form-control <?= (!empty($confirm_pwd_err)) ? 'is-invalid' : ''; ?>" id="signup-confirm-pwd" name="signup-confirm-pwd"
                    placeholder="Confirm your password here" value="<?= $input_confirm_pwd; ?>" minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                <label id="signup-pwd-label" for="signup-pwd" class="form-label">Confirm password</label>
                <div class="invalid-feedback">
                    <?= $confirm_pwd_err; ?>
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input <?= (!empty($terms_err)) ? 'is-invalid' : ''; ?>" id="signup-tos" name="signup-tos" value='Accepted'> <!-- value=accepted per check registrazione con php -->
                <label class="form-check-label" for="signup-tos">I accept the <a class="terms-link" href="#">Terms of Service</a></label>
                <div class="invalid-feedback">
                    <?= $terms_err; ?>
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input <?= (!empty($privacy_err)) ? 'is-invalid' : ''; ?>" id="signup-privacy" name="signup-privacy" value='Accepted'> <!-- value=accepted per check registrazione con php -->
                <label class="form-check-label" for="signup-privacy">I accept the <a class="terms-link" href="#">Privacy Policy</a></label>
                <div class="invalid-feedback">
                    <?= $privacy_err; ?>
                </div>
            </div>

            <button id="normal-signin-btn" type="submit"
                class="btn btn-primary d-block my-2 mx-auto">Complete registration</button>
        </form>
    </div>
</div>

<!-- Footer -->
<?php
require('php/service-pages-footer.php');
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>

</html>