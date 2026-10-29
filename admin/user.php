<!DOCTYPE html>
<html lang="en">

<?php 
include('session_controller.php');
require_once 'conf/connection.php';
$page_title = 'users';


$qury = "SELECT * FROM users ORDER BY id DESC";
$result = $conn->query($qury);
require_once 'conf/header.php';
$nb = 1; ?>
<body>

    <div class="container-fluid">
        <div class="row">
            <?php require_once 'conf/sidebar.php' ?>

            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4"> 
                <?php require_once 'conf/navbar.php' ?>
                
            <div class="row">
                    <div class="col-lg-12">
                        <?php if (isset($_SESSION['message'])): ?>
                            <div class="m-2 alert alert-success alert-dismissible fade show text-center shadow-sm" role="alert">
                                <?= $_SESSION['message']; ?>
                                <?php unset($_SESSION['message']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <a href="user_controleur.php" class="btn btn-primary m-3">Add user</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Name</th>
                                        <th>role</th>
                                        <th>Email</th>
                                        <th>Image</th>
                                        <th>Gender</th>
                                        <th>Active</th>
                                        <th>Updated At</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($users  = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= $nb++; ?></td>
                                            <td><?= $users ['name']?></td>
                                            <td><?= $users ['role']?></td>
                                            <td><?= $users ['email']?></td>
                                            <td>

                                                <?php if ($users ['url_image']): ?>
                                                    <img src="<?= $users ['url_image'];?>" alt="Image" class="img-thumbnail" height="90" width="70">
                                                <?php else: ?>
                                                    <span>No image</span>
                                                <?php endif; ?>
                                              
                                            </td>
                                            <td> <button class="btn btn-sm text-light  <?= $users ['gender'] === 'male' ? 'btn-primary' : 'btn-danger' ?>"><?= $users ['gender']; ?></button></td>
                                            <td>
                                                <form action="user_controleur.php" method="POST">
                                                    <input type="hidden" name="id" value="<?= $users ['id'] ?>">
                                                    <input type="hidden" name="action" value="toggle">
                                                    <button class="btn btn-sm <?= $users ['active'] ? 'btn-success' : 'btn-danger' ?>" type="submit">
                                                        <?= $users ['active'] ? 'Active' : 'Inactive' ?>
                                                    </button>
                                                </form>
                                            </td>
                                            <td><?= $users ['updated_at'] ?? '-' ?></td>
                                            <td><?= $users ['created_at'] ?? '-' ?></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="user_controleur.php?edit=<?= $users ['id'] ?>" class="btn btn-sm">
                                                        <i class="fas fa-edit "></i>
                                                    </a>
                                                    
                                                    <form action="user_controleur.php" method="POST" style="display:inline;">
                                                        <input type="hidden" name="id" value="<?= $users ['id'] ?>">
                                                        <input type="hidden" name="action" value="delete">
                                                        <button class="btn btn-sm " type="submit" onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash text-danger"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>

   <?php require_once 'conf/footer.php' ?>