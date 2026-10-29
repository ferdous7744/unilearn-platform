<!DOCTYPE html>
<html lang="en">
<style>
    .code-box {
        background-color: #c9a7f5;
        color: #000000;
        font-family: Verdana, Geneva, sans-serif;
        font-size: 14px;
        border-radius: 0 0 6px 6px;
        padding: 16px;
        white-space: pre;
        overflow-x: auto;
        user-select: none;
        cursor: default;
    }

    .code-header {
        background-color: #d7d5d5;
       
        font-family: Verdana, Geneva, sans-serif;
        border-radius: 6px 6px 0 0;
    }
</style>
<?php
require_once 'conf/connection.php';
$info = [];
$qury = "SELECT * FROM webinfo";
$info = $conn->query($qury)->fetch_assoc();
$nb = 1;
$page_title = 'web info';
require_once 'conf/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
}; ?>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php require_once 'conf/sidebar.php' ?>

            <!-- Main Content -->
            <div class="col-md-10">
                <!-- Top Bar -->
                <?php require_once 'conf/navbar.php' ?>
                <div class="container mt-4">


                    <div class="row g-3 m-4 justify-content-center">
                        <div class="col-md-8">
                            <div class="border  shadow rounded  h-100">
                                <div class="code-header d-flex justify-content-between align-items-center px-3 py-2">
                                    <span class="text-secondary small fw-semibold"> <i class=" fas fa-crosshairs"></i> Objective</span>
                                    <form action="info_control.php" method="POST">
                                        <input type="hidden" name="content_type" value="objective">
                                        <input type="hidden" name="id" value="<?= $info['id'] ?>">
                                        <button class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </button>
                                    </form>
                                </div>
                                <div class="code-box p-3"><?= $info['objective'] ?></div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="border  shadow rounded h-100">
                                <div class="code-header d-flex justify-content-between align-items-center px-3 py-2">
                                    <span class="text-secondary small fw-semibold"> <i class="fas fa-envelope"></i> Email</span>
                                    <form action="info_control.php" method="POST">
                                        <input type="hidden" name="content_type" value="email">
   
   <input type="hidden" name="id" value="<?= $info['id'] ?>">                                     <button class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </button>
                                    </form>
                                </div>
                                <div class="code-box p-3 text-break"><?= $info['email'] ?></div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="border  shadow rounded h-100">
                                <div class="code-header d-flex justify-content-between align-items-center px-3 py-2">
                                    <span class="text-secondary small fw-semibold"> <i class="fas fa-phone"></i> Phone</span>
                                    <form action="info_control.php" method="POST">
                                        <input type="hidden" name="content_type" value="phone">
   
   <input type="hidden" name="id" value="<?= $info['id'] ?>">                                     <button class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </button>
                                    </form>
                                </div>
                                <div class="code-box p-3"><?= $info['phone'] ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mx-4 justify-content-center">
                        <div class="col-md-3">
                            <div class="border  shadow rounded h-100">
                                <div class="code-header d-flex justify-content-between align-items-center px-3 py-2">
                                    <span class="text-secondary small fw-semibold"> <i class="fab fa-youtube"></i> YouTube</span>
                                    <form action="info_control.php" method="POST">
                                        <input type="hidden" name="content_type" value="youtube">
 
 <input type="hidden" name="id" value="<?= $info['id'] ?>">                                       <button class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </button>
                                    </form>
                                </div>
                                <div class="code-box p-3"><?= $info['youtube'] ?></div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="border shadow rounded h-100">
                                <div class="code-header d-flex justify-content-between align-items-center px-3 py-2">
                                    <span class="text-secondary small fw-semibold"> <i class="fab fa-facebook"></i> Facebook</span>
                                    <form action="info_control.php" method="POST">
                                        <input type="hidden" name="content_type" value="facebook">

<input type="hidden" name="id" value="<?= $info['id'] ?>">                                        <button class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </button>
                                    </form>
                                </div>
                                <div class="code-box p-3"><?= $info['facebook'] ?></div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="border shadow rounded h-100">
                                <div class="code-header d-flex justify-content-between align-items-center px-3 py-2">
                                    <span class="text-secondary small fw-semibold"> <i class="fas fa-map-marker-alt"></i> Address</span>
                                    <form action="info_control.php" method="POST">
                                        <input type="hidden" name="content_type" value="adress">
  
  <input type="hidden" name="id" value="<?= $info['id'] ?>">                                      <button class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </button>
                                    </form>
                                </div>
                                <div class="code-box p-3"><?= $info['adress'] ?></div>
                            </div>
                        </div>
                    </div>
                </div>





            </div>
        </div>
    </div>

    <?php require_once 'conf/footer.php' ?>