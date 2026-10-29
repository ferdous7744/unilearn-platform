<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
$pageTitle = 'Login';
require_once 'conf/header.php'; ?>

<body>
    <section class="bg-light py-5">
           <?php if (!empty($_SESSION['message'])) { ?>
            <div class="alert alert-danger text-center">
                <?php
                print $_SESSION['message'];
                $_SESSION['message'] = null;
        ?>
            </div>
        <?php } ?>
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5 col-sm-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h3 class="card-title mb-4 text-center">Admin dushbord</h3>
                            <form action="login_controller.php" method="post">
                                <div class="mb-3">
                                    <label for="email" class="form-label"> <i class="bi bi-envelope me-1"></i>Email address</label>
                                    <input type="email" required class="form-control" name="email" placeholder="Enter your email">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label"> <i class=" bi bi-key me-1"></i>Password</label>
                                    <input type="password" required class="form-control" name="password" placeholder="Enter your password">
                                </div>
                                <div class=" mb-3 text-center">
                                    <button type="submit" class="btn btn-primary w-50"> Login</button>
                                    <a class="btn btn-warning w-25" href="index.php"> back</a>
                                </div>
                            </form>
                        </div>
                    </div>

    </section>
</body>

</html>