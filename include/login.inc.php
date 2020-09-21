<?php
session_start();

function login_redirect() {
    // Redirects back to main login page and closes the script.
    header('Location: ../login.php');
    exit();
}

if (isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['login-submit'])) {
    // Database Connection
    try {
        require('db.inc.php');
    }
    catch(PDOException $ex) {
        $_SESSION['login-err'] = 'Internal error. Please try again next time.';
        $err_msg = '/phplesson/01_crud/login.inc.php, PDO Err = ';
        error_log($err_msg.$ex->getMessage());
        login_redirect();
    }
    catch(Throwable $ex) {
        $_SESSION['login-err'] = 'Internal error. Please try again next time.';
        $err_msg = '/phplesson/01_crud/login.inc.php, Err = ';
        error_log($err_msg.$ex->getMessage());
        login_redirect();
    }

    $user = $_POST['user'];
    $pwd = $_POST['pwd'];

    // Check for invalid fields
    if (strlen($user) < 8) {
        $_SESSION['login-err'] = 'Invalid username.';
        login_redirect();
    }
    else if (strlen($pwd) < 10) {
        $_SESSION['login-err'] = 'Invalid password.';
        login_redirect();
    }

    // Pull data from database
    $sql = 'SELECT username, password
            FROM login_system.public.users
            WHERE username = :user';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user' => $user
    ]);
    $data = $stmt->fetch();

    // Check if return data is nothing
    if (empty($data)) {
        $message = 'Nonexistent username. Please signup for an account';
        $_SESSION['login-err'] = $message;
        login_redirect();
    }

    // Check if username and password match; if yes, log them in
    // Logout previous user
    if ($data['username'] == $user and
        password_verify($pwd, $data['password'])) {
        session_destroy();
        session_start();
        $_SESSION['login'] = true;
        header('Location: ../index.php');
        exit();
    }
    else {
        $_SESSION['login-err'] = 'Incorrect password or username';
        login_redirect();
    }
}
login_redirect();
