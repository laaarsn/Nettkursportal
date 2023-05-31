<?php
session_start();

if (isset($_POST['submitLogin'])) {
    $_SESSION['id'] = 1;
    header("Location: minside.php");
}