<?php

$dsn = '***:host=***;port=***;dbname=***';
$usr = '***';
$pass = '***';


$pdo = new PDO($dsn, $usr, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
