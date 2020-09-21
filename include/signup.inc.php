<?php
session_start();

function signup_redirect() {
    // Redirects back to main signup page and closes the script.
    header('Location: ../signup.php');
    exit();
}

if (isset($_POST['signup-submit'])) {
    // Database Connection
    try {
        require('db.inc.php');
    }
    catch(PDOException $ex) {
        $_SESSION['signup-err'] = 'Internal error. Please try again next time.';
        $err_msg = '/phplesson/01_crud/signup.inc.php, PDO Err = ';
        error_log($err_msg.$ex->getMessage());
        signup_redirect();
    }
    catch(Throwable $ex) {
        $_SESSION['signup-err'] = 'Internal error. Please try again next time.';
        $err_msg = '/phplesson/01_crud/signup.inc.php, Err = ';
        error_log($err_msg.$ex->getMessage());
        signup_redirect();
    }

    $user = $_POST['user'];
    $pwd = $_POST['pwd'];
    $rpwd = $_POST['pwd-rep'];

    // Check for any empty fields
    if (empty($user) or empty($pwd) or empty($rpwd)) {
        if (empty($user)) {$_SESSION['signup-err'] = 'Username field empty.';}
        else if (empty($pwd)) {
            $_SESSION['signup-err'] = 'Password field empty.';
        }
        else if (empty($rpwd)) {
            $_SESSION['signup-err'] = 'Repeat password field empty.';
        }
        signup_redirect();
    }

    // Check that username contains at least 8 characters
    if (strlen($user) < 8) {
        $_SESSION['signup-err'] = 'Invalid username.';
        signup_redirect();
    }

    // Check username contains only alphanumerals and underscores
    $user_pattern = "/\w+/";
    if (! preg_match($user_pattern, $user)) {
        $_SESSION['signup-err'] = 'Invalid username.';
        signup_redirect();
    }

    // Check password contains at least 10 characters
    if (strlen($pwd) < 10) {
        $_SESSION['signup-err'] = 'Weak Password.';
        signup_redirect();
    }

    // Check that password and r-password match
    if ($pwd !== $rpwd) {
        $_SESSION['signup-err'] = 'Repeated password does not match.';
        signup_redirect();
    }

    // Hash the password before insertion
    $hpwd = password_hash($pwd, PASSWORD_DEFAULT);

    // Insert data into database
    // Username has unique constraint; thus, catch duplicate and log the error
    try {
        $sql = 'INSERT INTO login_system.public.users(username, password)
                VALUES(:user, :pwd)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
           ':user' => $user,
           ':pwd' => $hpwd
        ]);
    }
    catch(PDOException $ex) {
        $_SESSION['signup-err'] = 'Username already taken.';
        $err_msg = '/phplesson/01_crud/signup.inc.php, PDO Err = ';
        error_log($err_msg.$ex->getMessage());
        signup_redirect();
    }

    header('Location: ../login.php');
    exit();
}
signup_redirect();
