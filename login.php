<?php
//Riabilitare queste due righe per vedere errori se serve fare debugging
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// session_start() va sempre all'inizio del codice PHP
session_start();

//Controlliamo se utente è già loggato. Se NON lo è: l'utente potrà vedere questa pagina dato che potrebbe aver bisogno di loggarsi.
//Se invece esiste una sessione $_SESSION['loggedin']) e il suo stato è TRUE (= se si è già loggato) non c'è ragione di farlgli vedere questa pagina
//(si è ovviamente già loggato in precedenza) e quindi redirect automatico a index.html
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE) {
    header('location: index.php');
    exit();
}

//Includo file di connessione DB
require_once('config.php');

//Inizializzo variabili da popolare con dati utente l'utente dovrà inserire per loggarsi
$user_email = $user_pwd = "";
// creo variabili per gestire errori in fase di inserimento dati in form di registrazione
$email_err = $pwd_err = $login_err = "";

//Valido i campi input compilati nel form una volta che sono stati inviati con metodo POST dall'utente cliccando su Submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //valido campo email
    $input_email = trim($_POST['login-email']);
    if (empty($input_email)) {
        $email_err = "Please enter an email address";
    } else {
        $user_email = $input_email;
    }

    //valido campo password
    $input_pwd = trim($_POST['login-pwd']);
    if (empty($input_pwd)) {
        $pwd_err = "Please enter your password.";
    } else {
        $user_pwd = $input_pwd;
    }

    //Se controllo username e pwd non presentano errori, allora prepared statement per verificare se utente esiste già in DB:
    if (empty($email_err) && empty($pwd_err)) {

        //Prepared statement (l'ordine dei nomi delle colonne deve rispettare quello effettivo del DB altrimenti ci saranno problemi)
        $check_if_usr_exists = "SELECT id, username, email, password FROM registered_users WHERE email = ?";

        if ($check_user = mysqli_prepare($db_conn, $check_if_usr_exists)) {

            //Bind della query select
            mysqli_stmt_bind_param($check_user, "s", $param_email);
            $param_email = $user_email;

            //Tento esecuzione $check_user:
            if (mysqli_stmt_execute($check_user)) {

                //Se esecuzione statement va a buon fine, salva risultati query:
                mysqli_stmt_store_result($check_user);

                //Controllo se query eseguita ha restituito SOLO una riga (= no più utenti con quell'email in DB). Se è vero, procedi con secondo bind
                if (mysqli_stmt_num_rows($check_user) == 1) {

                    //Secondo bind delle colonne del record restituito dalla query alle seguenti variabili passate a questa funzione, per permettere in seguito a 
                    //mysqli_stmt_fetch() di attribuire a tali variabili i valori della riga corrente restituita dalla query, verificando che il record restituito 
                    //contenga effettivamente TUTTI i valori salvati in $id, $username, $hashed_password (quest'ultima è la password hashata già salvata in DB)
                    //e poi confrontarne i valori con quelle delle variabili $input_email o $input_pwd che contengono i dati inseriti dall'utente nel form di log-in.
                    //In realtà mi servirà solo verificare il match di email e password, gli altri valori in DB li ho recuperati per fare eventualmente altre cose:
                    mysqli_stmt_bind_result($check_user, $db_id, $db_username, $db_email, $db_hashed_password);

                    //mysqli_stmt_fetch() viene utilizzata per recuperare la riga del record generato dalla query, le cui colonne (e valori recuperati) sono già
                    //stati associati alle variabili appena definite qui sopra. Se i valori richiesti con la query sono tutti presenti nella riga del record recuperato
                    //allora mysqli_stmt_fetch() restituirà TRUE. Altrimenti FALSE:
                    if (mysqli_stmt_fetch($check_user)) {

                        //Se i dati da confrontare ci sono tutti (mysqli_stmt_fetch controlla proprio questo), procedi al controllo del
                        //match dei valori che ti interessanto (in questo caso, solo la pwd dato che l'esistenza dell'email in db l'abbiamo
                        //già verificata con la query di interrogazione e verificando che abbia restituito effettivamente una riga):
                            var_dump($user_pwd, $db_id, $db_username, $db_email, $db_hashed_password);
                        if (password_verify($user_pwd, $db_hashed_password)) {

                            //Se email e pwd inseriti da utente corrispondo a quelle create in sede di registrazion, crea superglobali
                            //di sessione per completare il login (verificando prima, per sicurezza, di aver già incluso a inzio codice
                            //un session_start() e, in caso contrario, facendolo ora):
                            if (session_status() === PHP_SESSION_NONE) {
                                session_start();
                            }

                            //Creo superglobali di sessione per completare login e permettere i controlli di avvenuto login all'inizio di 
                            //ogni pagina del sito:
                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $db_id;
                            $_SESSION['username'] = $db_username;

                            //Reindirizza utente loggato a Homepage:
                            header('location: index.php');
                        } else {
                            $pwd_err = "Incorrect password for $user_email. Please, try again or reset your password.";
                        }
                    }
                } else { //se DB non restituisce alcuna riga, significa che non c'è alcun record con utenti già registrati che hanno la stessa email inserita nel form Log In
                    $email_err = "No registered user found with this email. Please enter a valid email to log in.";
                }
            } else {
                echo "Connection to DB failed.";
            }

            //Close statement
            mysqli_stmt_close($check_user);
        }
    }
}

//Per header pagina + SEO dinamico titolo e descrizione pagina in header
$description = "Mindflix Sign In page. Just a personal, non-commercial project to learn web dev";
$title = "Sign In | Mindflix";
include("php/service-pages-header.php");
?>



<div class="main  d-flex align-items-center justify-content-center">
    <div class="form-container mx-auto  p-4">
        <form class="mx-auto" action="http://<?= $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ?>" method="post" novalidate>
            <!-- novalidate disattiva controlli input di defualt del browser perché ho creato controlli cusotm tramite PHP.
             Uso comunque classi e struttura Bootstrap per visualizzazione con stili e colori Bootstrap ad hoc per errori e conferme -->
            <h3>Sign In</h3>
            <div class="mb-3 form-floating">
                <input type="email" class="form-control <?= (!empty($email_err)) ? 'is-invalid' : ''; ?>" id="login-email" name="login-email"
                    aria-describedby="emailHelp" placeholder="Your email here" value="<?= $user_email; ?>" required>
                <label for="login-email" class="form-label">Email address</label>
                <div class="invalid-feedback">
                    <?= $email_err; ?>
                </div>
            </div>
            <div class="mb-3 form-floating">
                <input type="password" class="form-control <?= (!empty($pwd_err)) ? 'is-invalid' : ''; ?>" id="login-pwd" name="login-pwd"
                    placeholder="Your password here" required>
                <label id="login-pwd-label" for="login-pwd" class="form-label">Password</label>
                <div id="invalid-pwd-fdb" class="invalid-feedback">
                    <?= $pwd_err; ?>
                </div>
            </div>
            <button id="normal-signin-btn" type="submit"
                class="btn btn-primary d-block my-2 mx-auto">Submit</button>
            <p class="my-2 text-center">OR</p>
            <a id="code-signin-btn" type="button" class="btn btn-primary d-block mx-auto align-items-center">Use a
                Sign-in Code</a>
            <a class="forgot-pwd d-block my-3 text-center" href="#">Forgot Password?</a>
        </form>

        <div class="form-footer mx-auto mt-4">
            <div class="mb-3 form-check">
                <!-- Questo checkbox andrà capito come usarlo: salvataggio in local storage dei dati di login? Cookie? -->
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Remember me</label>
            </div>
            <p>New to Mindflix? <a class="signup-form-link" href="signup.php">Sign up now.</a></p>
            <p class="recapcha recapcha-warning">This page is protected by Google reCAPTCHA to ensure you're not a
                bot. <a id="recapcha-learn" class="terms-link" href="#">Learn more.</a> </p>
            <p id="recapcha-info" class="recapcha hide-class">The information collected by Google reCAPTCHA is
                subject to the Google <a class="terms-link" href="https://policies.google.com/privacy">Privacy
                    Policy</a> and <a class="terms-link" href="https://policies.google.com/terms">Terms of
                    Service</a>, and is used for providing, maintaining, and improving the reCAPTCHA
                service and for general security purposes (it is not used for personalized advertising by Google).
            </p>
        </div>

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