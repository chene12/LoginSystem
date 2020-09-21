<?php
    require_once('header.php');
    session_start();
?>
    <h1 class="title">Signup Form</h1>

    <p id="error">
        <!-- Print signup error message-->
        <b><?php
        if (isset($_SESSION['signup-err'])) {
            echo 'ERROR: ', $_SESSION['signup-err'];
            unset($_SESSION['signup-err']);
        }
        ?></b>
    </p>

    <br>

    <div id="signup">

    <form method="post" action="include/signup.inc.php">

    <ul>
        <li>
            <label>Username:&nbsp
            <input type="text" name="user" placeholder="*Required"></label>
            <br>
            <p>
            *Case-sensitive<br>
            *Contains at least 8 characters<br>
            *Contains only alphanumerals and underscores
            </p>
        </li>
        <li>
            <label>Password:&nbsp
            <input type="password" name="pwd" placeholder="*Required">
            </label>
            <p>
            *Case-sensitive<br>
            *Contains at least 10 characters
            </p>
        </li>
        <li>
            <label>Repeat Password:&nbsp
            <input type="password" name="pwd-rep" placeholder="*Required">
            </label>
        </li>
        <li>
            <input type="submit" name="signup-submit">
        </li>
    </ul>

    </form>

    </div>
<?php require_once('footer.php');?>
