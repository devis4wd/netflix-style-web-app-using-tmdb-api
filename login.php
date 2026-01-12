<?php
// Enable these only during local debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();

/*
  If the user is already logged in, there is no reason to show the login form.
*/
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {

    // Optional: notify login via email ((demo feature -- PHPMAIL INSTALLATION REQUIRED))
    // If this fails, the login should still succeed.
    //This block was initially coded into a separate send-data.php file
    try {
        require_once('PHPMailer/class.phpmailer.php');

        $mail = new PHPmailer();
        $mail->isHTML(true);

        $mail->From = 'no-reply@your-domain.com';
        $mail->FromName = 'FakeFlix Demo';

        $mail->AddAddress('devis.vallotto@gmail.com');

        $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

        $mail->Subject = "FakeFlix login: {$user_email}";
        $mail->Body = "
        <p>A user logged in successfully.</p>
        <ul>
            <li><b>Email</b>: {$user_email}</li>
            <li><b>IP</b>: {$ip}</li>
            <li><b>User agent</b>: {$ua}</li>
        </ul>
    ";

        $mail->Send();
    } catch (Throwable $e) {
        // Intentionally ignore email errors in this demo project
    }


    header('Location: index.php');
    exit();
}

/*
  Database connection (expects $db_conn from config.php).
*/
require_once('config.php');

/* -------------------------------------------------------------------------- */
/* Form state                                                                  */
/* -------------------------------------------------------------------------- */

$user_email = '';
$user_pwd = '';

$email_err = '';
$pwd_err = '';
$login_err = '';

/* -------------------------------------------------------------------------- */
/* Handle POST                                                                 */
/* -------------------------------------------------------------------------- */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Email validation (basic)
    $input_email = trim($_POST['login-email'] ?? '');
    if ($input_email === '') {
        $email_err = 'Please enter an email address.';
    } else {
        $user_email = $input_email;
    }

    // Password validation (basic)
    $input_pwd = trim($_POST['login-pwd'] ?? '');
    if ($input_pwd === '') {
        $pwd_err = 'Please enter your password.';
    } else {
        $user_pwd = $input_pwd;
    }

    /*
      If there are no form errors, check if the user exists and verify the password hash.
    */
    if ($email_err === '' && $pwd_err === '') {

        $sql = "SELECT id, username, email, password FROM registered_users WHERE email = ?";

        if ($stmt = mysqli_prepare($db_conn, $sql)) {

            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $user_email;

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);

                // Email should be unique (1 record max)
                if (mysqli_stmt_num_rows($stmt) === 1) {

                    mysqli_stmt_bind_result($stmt, $db_id, $db_username, $db_email, $db_hashed_password);

                    if (mysqli_stmt_fetch($stmt)) {

                        // IMPORTANT: remove any var_dump/debug prints in production
                        if (password_verify($user_pwd, $db_hashed_password)) {

                            // Session is already started at the top, but keeping this check is harmless
                            if (session_status() === PHP_SESSION_NONE) {
                                session_start();
                            }

                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $db_id;
                            $_SESSION['username'] = $db_username;

                            header('Location: index.php');
                            exit();
                        } else {
                            $pwd_err = "Incorrect password for {$user_email}. Please try again.";
                        }
                    } else {
                        $login_err = 'Unable to read user data from the database.';
                    }
                } else {
                    $email_err = 'No registered user found with this email.';
                }
            } else {
                $login_err = 'Database query failed. Please try again later.';
            }

            mysqli_stmt_close($stmt);
        } else {
            $login_err = 'Database statement preparation failed.';
        }
    }
}

// Page SEO metadata
$description = "Mindflix Sign In page. Personal, non-commercial project to learn web development.";
$title = "Sign In | Mindflix";
include("php/service-pages-header.php");
?>

<main class="main d-flex align-items-center justify-content-center">
    <section class="form-container mx-auto p-4" aria-label="Sign in form">
        <form class="mx-auto" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
            <!-- novalidate disables browser native validation so custom PHP errors can be displayed consistently -->
            <h1 class="h3">Sign In</h1>

            <?php if (!empty($login_err)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($login_err); ?>
                </div>
            <?php endif; ?>

            <div class="mb-3 form-floating">
                <input
                    type="email"
                    class="form-control <?= (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                    id="login-email"
                    name="login-email"
                    placeholder="Your email here"
                    value="<?= htmlspecialchars($user_email); ?>"
                    required
                    autocomplete="email">
                <label for="login-email" class="form-label">Email address</label>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($email_err); ?>
                </div>
            </div>

            <div class="mb-3 form-floating">
                <input
                    type="password"
                    class="form-control <?= (!empty($pwd_err)) ? 'is-invalid' : ''; ?>"
                    id="login-pwd"
                    name="login-pwd"
                    placeholder="Your password here"
                    required
                    autocomplete="current-password">
                <label id="login-pwd-label" for="login-pwd" class="form-label">Password</label>
                <div id="invalid-pwd-fdb" class="invalid-feedback">
                    <?= htmlspecialchars($pwd_err); ?>
                </div>
            </div>

            <button id="normal-signin-btn" type="submit" class="btn btn-primary d-block my-2 mx-auto">
                Submit
            </button>

            <p class="my-2 text-center">OR</p>

            <!-- This is a UI toggle (handled in script.js). Keep it as a button for better semantics/accessibility. -->
            <button id="code-signin-btn" type="button" class="btn btn-primary d-block mx-auto align-items-center">
                Use a Sign-in Code
            </button>

            <a class="forgot-pwd d-block my-3 text-center" href="#">Forgot Password?</a>
        </form>

        <footer class="form-footer mx-auto mt-4">
            <div class="mb-3 form-check">
                <!-- TODO: decide how to implement this (cookie / localStorage) -->
                <input type="checkbox" class="form-check-input" id="remember-me">
                <label class="form-check-label" for="remember-me">Remember me</label>
            </div>

            <p>New to Mindflix? <a class="signup-form-link" href="signup.php">Sign up now.</a></p>

            <p class="recapcha recapcha-warning">
                This page is protected by Google reCAPTCHA to ensure you're not a bot.
                <a id="recapcha-learn" class="terms-link" href="#">Learn more.</a>
            </p>

            <p id="recapcha-info" class="recapcha hide-class">
                The information collected by Google reCAPTCHA is subject to the Google
                <a class="terms-link" href="https://policies.google.com/privacy">Privacy Policy</a> and
                <a class="terms-link" href="https://policies.google.com/terms">Terms of Service</a>.
            </p>
        </footer>
    </section>
</main>

<?php require('php/service-pages-footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>

</html>