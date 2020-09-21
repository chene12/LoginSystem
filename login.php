<?php
    require('header.php');
    session_start();
?>
    <h1 class="title">Login Page</h1>

    <p id="error">
        <!-- Print signup error message-->
        <b><?php
        if (isset($_SESSION['login-err'])) {
            echo 'ERROR: ', $_SESSION['login-err'];
            unset($_SESSION['login-err']);
        }
        ?></b>
    </p>

    <br>

    <div id="login">

    <form method="post" action="include/login.inc.php">

        <ul>
            <li>
                <label>Username:&nbsp
                <input type="text" name="user" placeholder="*Required">
                </label>
            </li>
            <li>
                <label>Password:&nbsp
                <input type="password" name="pwd" placeholder="*Required">
                </label>
            </li>
            <li>
                <input type="submit" name="login-submit">
            </li>
        </ul>

    </form>

    </div>

<?php require('footer.php');?>
