<!DOCTYPE html>
<html lang="en">

<?php

include('session_controller.php');
require_once 'conf/connection.php';
include_once 'conf/globel_functions.php';
$page_title = 'content';

// ✅ Fetch spc table (not overwritten)
$qury = "SELECT * FROM spc WHERE active = 1 ORDER BY id DESC";
$spc = $conn->query($qury);

// ✅ Fetch semester table
$qury = "SELECT * FROM semester ORDER BY id DESC";
$sem = $conn->query($qury);

$qury = "SELECT * FROM subjects ORDER BY id DESC";
$sub = $conn->query($qury);

require_once 'conf/header.php';
$nb = 1;

// ✅ Handle POST: save selections to session
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_semester']) && $_POST['id_semester'] !== '') {
        $_SESSION['idSem'] = $_POST['id_semester'];
    }
    if (isset($_POST['id_specialty']) && $_POST['id_specialty'] !== '') {
        $_SESSION['idSpc'] = $_POST['id_specialty']; // ✅ key is idSpc
    }
    if (isset($_POST['id_subject']) && $_POST['id_subject'] !== '') {
        $_SESSION['idSub'] = $_POST['id_subject']; // ✅ key is idSub
    }
}

// ✅ Initialize $content to null to avoid undefined variable
$subjects = null;
$total_subjects = 0;

// ✅ Use correct key idSpc (not idSp), and check not empty
if(isset($_SESSION['idSpc']) && isset($_SESSION['idSem'])){

    $sql = "SELECT * FROM subjects WHERE id_sp='{$_SESSION['idSpc']}' AND id_sem='{$_SESSION['idSem']}'  ORDER BY id DESC";
    $subjects = $conn->query($sql);

    if(isset($_SESSION['idSub'])){
        $sql = "SELECT * FROM contents WHERE subject_id='{$_SESSION['idSub']}' ORDER BY id DESC";
        $result = $conn->query($sql);
        $total_contents = $result->num_rows;
    }

}
?>


<body >

    <div class="container-fluid">
        <div class="row">
            <?php require_once 'conf/sidebar.php'; ?>
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php require_once 'conf/navbar.php'; ?>

                <!-- Filter Form -->
                <form action="" method="post">
                    <div class="row mt-3">
                        <div class="col-lg-4">
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

                        <div class="col-lg-4">
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
                        <div class="col-lg-4">
                            <label class="form-label">Subject</label>
                            <select name="id_subject" class="select-control form-select" onchange="this.form.submit()">
                                <option value="">-- Select Subject --</option>
                                <?php if ($subjects): while ($row = $subjects->fetch_assoc()): ?>
                                    <option value="<?= $row['id'] ?>"
                                        <?= (isset($_SESSION['idSub']) && $_SESSION['idSub'] == $row['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($row['name']) ?>
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
                        <a href="content_controleur.php" class="btn btn-primary m-3">Add Subject</a>
                    </div>
                </div>

                <!-- Table or messages -->
                


                    <?php if(isset($_SESSION['idSpc']) && isset($_SESSION['idSem']) && isset($_SESSION['idSub'])){ ?>
                    <div class="row">
                            <?php if (!empty($_SESSION['message'])) { ?>
                                <div class="alert alert-success text-center">
                                    <?php
                                    print $_SESSION['message'];
                                    $_SESSION['message'] = null;
                                    ?>
                                </div>
                            <?php } ?>

                            <div class="col-lg-12">
                                <div class="text-end my-3">
                                    <a href="content_controleur.php" class="btn btn-outline-primary">
                                        <i class="fas fa-plus me-1"></i>
                                        Add new content</a>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex">
                                            <div class="flex-fill">
                                                <i class="fas fa-list me-1"></i> Content List <br>
                                            </div>
                                            Total: <?= $total_contents ?>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>#ID</th>
                                                        <th>Name</th>
                                                        <th>Type</th>
                                                        <th>File</th>
                                                        <th>Web</th>
                                                        <th>Active</th>
                                                        <th>Disc</th>
                                                        <th>Updated at</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($content = $result->fetch_assoc()) { ?>
                                                        <tr>
                                                            <td><?= $content['id'] ?></td>
                                                            <td><?= $content['name'] ?></td>
                                                            <td>
                                                                <?= $content['type'] ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                               
                                                                if(isset($content['file_url']) && file_exists($content['file_url'])){
                                                                    ?>
                                                                    <a href="<?=$content['file_url']?>" target="_blank" >
                                                                        <i class="fas fa-file-download fa-lg text-danger"></i>
                                                                    </a>
                                                                    
                                                                <?php }else{?>
                                                                    <i class=" fas fa-file-pdf fa-lg text-uted"></i>
                                                                <?php }?>
                                                                
                                                            </td>
                                                            <td>
                                                                <?php if(isset($content['website'])){
                                                                    ?>
                                                                    <a href="<?=$content['website']?>" target="_blank" >
                                                                        <i class=" fab fa-internet-explorer fa-lg text-info"></i>
                                                                    </a>
                                                                    
                                                                <?php }else{?>
                                                                    <i class="fab fa-internet-explorer fa-lg text-uted"></i>
                                                                <?php }?> 
                                                            </td>
                                                            <td>
                                                                <form action="content_controleur.php" method="POST">
                                                                    <input type="hidden" name="action" value="toggle">
                                                                    <input type="hidden" name="id"
                                                                        value="<?= $content['id'] ?>">
                                                                    <?php if ($content['active']) { ?>
                                                                        <button type="submit" class="btn btn-sm bg-success-subtle text-success">
                                                                            <i class="fas fa-play"></i>
                                                                        </button>
                                                                    <?php } else { ?>
                                                                        <button type="submit"
                                                                            class="btn btn-sm bg-danger-subtle text-danger">
                                                                            <i class="fas fa-stop"></i>
                                                                        </button>
                                                                    <?php } ?>
                                                                </form>
                                                            </td>
                                                            <td><?= substr($content['disc'], 0, 40) . " ..." ?></td>
                                                            <td><?= $content['updated_at'] ?></td>
                                                            <td class="d-flex gap-1">
                                                                <a href="content_controleur.php?edit=<?= $content['id'] ?>"
                                                                    class="btn btn-outline-info btn-sm">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>

                                                                <form action="content_controleur.php" method="POST"
                                                                    onclick="return confirm('Are you sure you want to delete this content?')">
                                                                    <input type="hidden" name="action" value="delete">
                                                                    <input type="hidden" name="id"
                                                                        value="<?= $content['id'] ?>">
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer ">
                                        <div class="d-flex">
                                            <div class="flex-fill">
                                                <small> <?= date('Y-m-d') ?></small>
                                            </div>
                                            <small> <?= date('H:i:s') ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php }?>
                </div>
            

            </div>
        </div>
    </div>

    <?php require_once 'conf/footer.php'; ?>
