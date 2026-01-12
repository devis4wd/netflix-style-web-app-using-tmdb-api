<?php
// Enable these only during local debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();

/*
  If the user is already logged in, redirect to the home page.
*/
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {

    if (mysqli_stmt_execute($stmt)) {

        // Optional: notify registration via email (demo feature -- PHPMAIL INSTALLATION REQUIRED)
        // If this fails, registration should still succeed.
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

            $safeUsername = htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8');
            $safeEmail = htmlspecialchars($user_email, ENT_QUOTES, 'UTF-8');

            $mail->Subject = "FakeFlix registration completed: {$user_email}";
            $mail->Body = "
            <p>A new user registration has been completed.</p>
            <ul>
                <li><b>Username</b>: {$safeUsername}</li>
                <li><b>Email</b>: {$safeEmail}</li>
                <li><b>IP</b>: {$ip}</li>
                <li><b>User agent</b>: {$ua}</li>
            </ul>
        ";

            $mail->Send();
        } catch (Throwable $e) {
            // Intentionally ignore email errors in this demo project
        }

        header('Location: login.php');
        exit();
    }


    header('Location: index.php');
    exit();
}

require_once('config.php');

/* -------------------------------------------------------------------------- */
/* Form state                                                                  */
/* -------------------------------------------------------------------------- */

$user_name = '';
$user_email = '';
$user_pwd = '';
$confirm_pwd = '';

// Keep raw inputs so the form can re-display user data after POST errors
$input_username = '';
$input_pwd = '';
$input_confirm_pwd = '';

$name_err = '';
$email_err = '';
$pwd_err = '';
$confirm_pwd_err = '';
$terms_err = '';
$privacy_err = '';
$signup_err = '';

/* -------------------------------------------------------------------------- */
/* Handle POST                                                                 */
/* -------------------------------------------------------------------------- */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* Username */
    $input_username = trim($_POST['signup-username'] ?? '');
    if ($input_username === '') {
        $name_err = 'Please enter a username.';
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $input_username)) {
        $name_err = 'Ensure your username contains upper and lower case letters and at least one number.';
    } else {
        $user_name = $input_username;
    }

    /* Email */
    $input_email = trim($_POST['signup-email'] ?? '');
    if ($input_email === '') {
        $email_err = 'Please enter an email address.';
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        $email_err = 'Please enter a valid email address.';
    } else {
        $user_email = $input_email;
    }

    /* Password */
    $input_pwd = trim($_POST['signup-pwd'] ?? '');
    if ($input_pwd === '') {
        $pwd_err = 'Please choose a password.';
    } elseif (strlen($input_pwd) < 8) {
        $pwd_err = 'Ensure your password is at least 8 characters long.';
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[_*#$@!]).+$/', $input_pwd)) {
        $pwd_err = 'Use upper and lower case letters, at least one number, and a symbol like @, _, #, *.';
    } else {
        $user_pwd = $input_pwd;
    }

    /* Confirm password */
    $input_confirm_pwd = trim($_POST['signup-confirm-pwd'] ?? '');
    if ($input_confirm_pwd === '') {
        $confirm_pwd_err = 'Confirm your password.';
    } elseif ($pwd_err === '' && $user_pwd !== $input_confirm_pwd) {
        $confirm_pwd_err = "Your confirmation password doesn't match the password you chose.";
    } else {
        $confirm_pwd = $input_confirm_pwd;
    }

    /* Terms / Privacy checkboxes */
    if (empty($_POST['signup-tos'])) {
        $terms_err = 'You need to accept our Terms of Service.';
    }
    if (empty($_POST['signup-privacy'])) {
        $privacy_err = 'You need to accept our Privacy Policy.';
    }

    /*
      If all fields are valid, register the user.
    */
    if (
        $name_err === '' &&
        $email_err === '' &&
        $pwd_err === '' &&
        $confirm_pwd_err === '' &&
        $terms_err === '' &&
        $privacy_err === ''
    ) {

        /*
          Minimal duplicate email check (keeps the project realistic without being over-engineered).
        */
        $check_sql = "SELECT id FROM registered_users WHERE email = ? LIMIT 1";
        if ($check_stmt = mysqli_prepare($db_conn, $check_sql)) {

            mysqli_stmt_bind_param($check_stmt, "s", $param_email);
            $param_email = $user_email;

            if (mysqli_stmt_execute($check_stmt)) {
                mysqli_stmt_store_result($check_stmt);

                if (mysqli_stmt_num_rows($check_stmt) > 0) {
                    $email_err = 'This email is already registered. Please sign in instead.';
                }
            } else {
                $signup_err = 'Database query failed. Please try again later.';
            }

            mysqli_stmt_close($check_stmt);
        } else {
            $signup_err = 'Database statement preparation failed.';
        }

        /*
          If email is not already used, insert the new user.
        */
        if ($email_err === '' && $signup_err === '') {

            $insert_sql = "INSERT INTO registered_users (username, email, password) VALUES (?, ?, ?)";

            if ($stmt = mysqli_prepare($db_conn, $insert_sql)) {

                mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_email, $param_pwd);

                $param_name = $user_name;
                $param_email = $user_email;
                $param_pwd = password_hash($user_pwd, PASSWORD_DEFAULT);

                if (mysqli_stmt_execute($stmt)) {
                    header('Location: login.php');
                    exit();
                } else {
                    $signup_err = 'Something went wrong during registration. Please try again.';
                }

                mysqli_stmt_close($stmt);
            } else {
                $signup_err = 'Database statement preparation failed.';
            }
        }
    }

    mysqli_close($db_conn);
}

// Page SEO metadata
$description = "Mindflix Sign Up page. Personal, non-commercial project to learn web development.";
$title = "Sign Up | Mindflix";
include("php/service-pages-header.php");
?>

<main class="main d-flex align-items-center justify-content-center">
    <section class="form-container mx-auto p-4" aria-label="Sign up form">
        <form class="mx-auto" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
            <h1 class="h3">Sign Up</h1>

            <?php if (!empty($signup_err)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($signup_err); ?>
                </div>
            <?php endif; ?>

            <div class="mb-3 form-floating">
                <input
                    type="text"
                    class="form-control <?= (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                    id="signup-username"
                    name="signup-username"
                    placeholder="Choose your username"
                    value="<?= htmlspecialchars($input_username); ?>"
                    required
                    autocomplete="username">
                <label for="signup-username" class="form-label">Choose your username</label>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($name_err); ?>
                </div>
            </div>

            <div class="mb-3 form-floating">
                <input
                    type="email"
                    class="form-control <?= (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                    id="signup-email"
                    name="signup-email"
                    placeholder="Your email here"
                    value="<?= htmlspecialchars($user_email); ?>"
                    required
                    autocomplete="email">
                <label for="signup-email" class="form-label">Email address</label>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($email_err); ?>
                </div>
            </div>

            <div class="mb-3 form-floating">
                <input
                    type="password"
                    class="form-control <?= (!empty($pwd_err)) ? 'is-invalid' : ''; ?>"
                    id="signup-pwd"
                    name="signup-pwd"
                    placeholder="Your password here"
                    value="<?= htmlspecialchars($input_pwd); ?>"
                    minlength="8"
                    required
                    autocomplete="new-password">
                <label id="signup-pwd-label" for="signup-pwd" class="form-label">Password</label>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($pwd_err); ?>
                </div>
            </div>

            <div class="mb-3 form-floating">
                <input
                    type="password"
                    class="form-control <?= (!empty($confirm_pwd_err)) ? 'is-invalid' : ''; ?>"
                    id="signup-confirm-pwd"
                    name="signup-confirm-pwd"
                    placeholder="Confirm your password here"
                    value="<?= htmlspecialchars($input_confirm_pwd); ?>"
                    minlength="8"
                    required
                    autocomplete="new-password">
                <label for="signup-confirm-pwd" class="form-label">Confirm password</label>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($confirm_pwd_err); ?>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input
                    type="checkbox"
                    class="form-check-input <?= (!empty($terms_err)) ? 'is-invalid' : ''; ?>"
                    id="signup-tos"
                    name="signup-tos"
                    value="Accepted"
                    <?= !empty($_POST['signup-tos']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="signup-tos">
                    I accept the <a class="terms-link" href="#">Terms of Service</a>
                </label>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($terms_err); ?>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input
                    type="checkbox"
                    class="form-check-input <?= (!empty($privacy_err)) ? 'is-invalid' : ''; ?>"
                    id="signup-privacy"
                    name="signup-privacy"
                    value="Accepted"
                    <?= !empty($_POST['signup-privacy']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="signup-privacy">
                    I accept the <a class="terms-link" href="#">Privacy Policy</a>
                </label>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($privacy_err); ?>
                </div>
            </div>

            <button id="normal-signin-btn" type="submit" class="btn btn-primary d-block my-2 mx-auto">
                Complete registration
            </button>
        </form>
    </section>
</main>

<?php require('php/service-pages-footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>

</html>