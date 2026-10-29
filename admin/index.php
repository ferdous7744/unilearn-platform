<!DOCTYPE html>
<html lang="en">

<?php 
require_once 'conf/connection.php';
 require_once 'session_controller.php';
$page_title = 'Dashboard';
require_once 'conf/header.php' ?>
<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php require_once 'conf/sidebar.php' ?>

            <!-- Main Content -->
            <div class="col-md-10">
                
               
                <!-- Top Bar -->
                <?php  require_once 'conf/navbar.php' ?>
<h2 class="mb-4">Hi  the <?=$_SESSION['role']??'null' ?> <?=$_SESSION['user']??'null' ?>
                👋
                 </h2>             
                <!-- Content -->
                
            </div>
        </div>
    </div>

   <?php require_once 'conf/footer.php' ?>