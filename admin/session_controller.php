<?php

session_start();
if(!$_SESSION['role'])
{
    header("Location: ../login.php");
        exit;
}