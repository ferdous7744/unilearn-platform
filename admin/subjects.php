<!DOCTYPE html>
<html lang="en">

<?php

include('session_controller.php');
require_once 'conf/connection.php';
include_once 'conf/globel_functions.php';
$page_title = 'module';

// ✅ Fetch spc table (not overwritten)
$qury = "SELECT * FROM spc WHERE active = 1 ORDER BY id DESC";
$spc = $conn->query($qury);

// ✅ Fetch semester table
$qury = "SELECT * FROM semester ORDER BY id DESC";
$sem = $conn->query($qury);

require_once 'conf/header.php';
$nb = 1;

// ✅ Handle POST: save selections to session
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_semester'])) {
        $_SESSION['idSem'] = $_POST['id_semester'];
    }
    if (isset($_POST['id_specialty'])) {
        $_SESSION['idSpc'] = $_POST['id_specialty']; // ✅ key is idSpc
    }
}

// ✅ Initialize $subjects to null to avoid undefined variable
$subjects = null;
$total_subjects = 0;

// ✅ Use correct key idSpc (not idSp), and check not empty
if (
    isset($_SESSION['idSpc']) && isset($_SESSION['idSem']) &&
    $_SESSION['idSpc'] !== '' && $_SESSION['idSem'] !== ''
) {
    $stmt = $conn->prepare("SELECT * FROM subjects WHERE id_sp = ? AND id_sem = ? ORDER BY id DESC");
    $stmt->bind_param("ii", $_SESSION['idSpc'], $_SESSION['idSem']);
    $stmt->execute();
    $subjects = $stmt->get_result();
    $total_subjects = $subjects->num_rows;
    $stmt->close();
}
?>
<style>
    body {
        background: #f8f9fa;
       font-family: Verdana, Geneva, sans-serif;
    }
</style>
<body >

    <div class="container-fluid">
        <div class="row">
            <?php require_once 'conf/sidebar.php'; ?>
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php require_once 'conf/navbar.php'; ?>

                <!-- Filter Form -->
                <form action="" method="post">
                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <label class="form-label">Semester</label>
                            <select name="id_semester" class="select-control form-select" onchange="this.form.submit()">
                                <option value="">-- Select Semester --</option>
                                <?php if ($sem): while ($row = $sem->fetch_assoc()): ?>
                                    <option value="<?= $row['id'] ?>"
                                        <?= (isset($_SESSION['idSem']) && $_SESSION['idSem'] == $row['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($row['name']) ?>
                                    </option>
                                <?php endwhile; endif; ?>
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <label class="form-label">Speciality</label>
                            <select name="id_specialty" class="select-control form-select" onchange="this.form.submit()">
                                <option value="">-- Select Speciality --</option>
                                <?php if ($spc): while ($row = $spc->fetch_assoc()): ?>
                                    <option value="<?= $row['id'] ?>"
                                        <?= (isset($_SESSION['idSpc']) && $_SESSION['idSpc'] == $row['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($row['sname']) ?>
                                    </option>
                                <?php endwhile; endif; ?>
                            </select>
                        </div>
                    </div>
                </form>

                <!-- Alert & Add Button -->
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <?php if (isset($_SESSION['message'])): ?>
                            <div class="m-2 alert alert-success alert-dismissible fade show text-center shadow-sm" role="alert">
                                <?= $_SESSION['message']; ?>
                                <?php unset($_SESSION['message']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <a href="subject_controleur.php" class="btn btn-primary m-3">Add Subject</a>
                    </div>
                </div>

                <!-- Table or messages -->
                <?php if (!$subjects): ?>
                    <div class="alert alert-info mx-3">
                        Please select a <strong>Semester</strong> and <strong>Speciality</strong> to view subjects.
                    </div>

                <?php elseif ($total_subjects === 0): ?>
                    <div class="alert alert-warning mx-3">
                        No subjects found for the selected filters.
                    </div>

                <?php else: ?>
                    <div class="card mx-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Coefficient</th>
                                            <th>Image</th>
                                            <th>Description</th>
                                            <th>Active</th>
                                            <th>Updated At</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- ✅ Use $row, not $subjects, inside the loop -->
                                        <?php while ($row = $subjects->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $nb++ ?></td>
                                                <td><?= htmlspecialchars($row['name']) ?></td>
                                                <td><?= htmlspecialchars($row['coef']) ?></td>
                                                <td>
                                                    <?php if ($row['url_image']): ?>
                                                        <img src="<?= htmlspecialchars($row['url_image']) ?>" alt="Image" class="img-thumbnail" height="90" width="70">
                                                    <?php else: ?>
                                                        <span>No image</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars(substr($row['disc'], 0, 40)) . '...' ?></td>
                                                <td>
                                                    <form action="subject_controleur.php" method="POST">
                                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                        <input type="hidden" name="action" value="toggle">
                                                        <button class="btn btn-sm <?= $row['active'] ? 'btn-success' : 'btn-danger' ?>" type="submit">
                                                            <?= $row['active'] ? 'Active' : 'Inactive' ?>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td><?= $row['updated_at'] ?? '-' ?></td>
                                                <td><?= $row['created_at'] ?? '-' ?></td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="subject_controleur.php?edit=<?= $row['id'] ?>" class="btn btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="subject_controleur.php" method="POST" style="display:inline;">
                                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                            <input type="hidden" name="action" value="delete">
                                                            <button class="btn btn-sm" type="submit" onclick="return confirm('Are you sure?')">
                                                                <i class="fas fa-trash text-danger"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <?php require_once 'conf/footer.php'; ?>
