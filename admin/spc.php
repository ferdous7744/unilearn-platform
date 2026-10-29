<!DOCTYPE html>
<html lang="en">
<?php
include('session_controller.php');
$page_title = 'spc';
require_once 'conf/header.php';
require_once 'conf/connection.php';

$qury = "SELECT * FROM spc";
$result = $conn->query($qury);
$nb = 1;
?>

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
                        <a href="sp_controleur.php" class="btn btn-primary m-3">Add speciality</a>
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
                                        <th>Image</th>
                                        <th>discreption</th>
                                        <th>Active</th>
                                        <th>Updated At</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($spc = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= $nb++; ?></td>
                                            <td><?= htmlspecialchars($spc['sname']) ?></td>
                                            <td>

                                                <?php if ($spc['url_image']): ?>

                                                    <img src="<?= htmlspecialchars($spc['url_image']); ?>" ... alt="Image" class="img-thumbnail" height="90" width="70">

                                                <?php else: ?>
                                                    <span>No image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= substr($spc['disc'], 0, 40) . '...'  ?> </td>
                                            <td>
                                                <form action="sp_controleur.php" method="POST">
                                                    <input type="hidden" name="id" value="<?= $spc['id'] ?>">
                                                    <input type="hidden" name="action" value="toggle">
                                                    <button class="btn btn-sm <?= $spc['active'] ? 'btn-success' : 'btn-danger' ?>" type="submit">
                                                        <?= $spc['active'] ? 'Active' : 'Inactive' ?>
                                                    </button>
                                                </form>
                                            </td>
                                            <td><?= $spc['update_at'] ?? '-' ?></td>
                                            <td><?= $spc['creat_at'] ?? '-' ?></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="sp_controleur.php?edit=<?= $spc['id'] ?>" class="btn btn-sm">
                                                        <i class="fas fa-edit "></i>
                                                    </a>

                                                    <form action="sp_controleur.php" method="POST" style="display:inline;">
                                                        <input type="hidden" name="id" value="<?= $spc['id'] ?>">
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
</body>

</html>