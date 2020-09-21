<?php
    require('header.php');
    session_start();
?>

    <div id="login-status">
        <b><?php
        if (isset($_SESSION['login'])) {
            print('Login Success!');
            print('<br><br>');
            print('<a style="text-decoration: none; color:red"
                href="include/logout.inc.php">');
            print('Logout</a>');
        }
        else {
            print('<span style="color: red">Not logged in. Please login.');
            print('</span>');
        }
        ?></b>
    </div>

    <br>

    <h1 class="title">Welcome to the CRUD App</h1>

    <div id="index-info">
        This application is the simplest application that will integrate all the
        fundamental operations of a database:

    <ul>
        <li>Create</li>
        <li>Read (a.k.a Select)</li>
        <li>Update</li>
        <li>Delete</li>
    </ul>

    </div>

<?php require('footer.php');?>
