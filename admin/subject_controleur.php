<?php
session_start();
require_once 'conf/connection.php';
require_once 'conf/globel_functions.php';

// unset($_SESSION['idSem']);
// ──────────────────────────────────────────────
// ── Delete — POST ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $id  = intval($_POST['id']);
    $sql = $conn->prepare('DELETE FROM subjects WHERE id = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $sql->close();
    $conn->close();

    $_SESSION['message'] = 'Subject deleted successfully';
    header('Location: subjects.php');
    exit;
}

// ──────────────────────────────────────────────
// ── toggle — POST ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'toggle') {
    $id  = intval($_POST['id']);
    $sql = $conn->prepare('UPDATE subjects SET active = NOT active  WHERE id = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $sql->close();
    $conn->close();

    $_SESSION['message'] = 'Subject updated successfully';
    header('Location: subjects.php');
    exit;
}

// ──────────────────────────────────────────────
//  Add / Update — POST
// ──────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $disc = htmlspecialchars(strip_tags($_POST['disc']));
    $coef = htmlspecialchars(strip_tags($_POST['coef']));
    $url_image = uploadFile('subject_images', $_POST['old_url_image'], $_FILES['url_image'], 'image');
    if($url_image == false){
        $url_image = $_POST['old_url_image'];
    }
    $active = htmlspecialchars(strip_tags($_POST['active']));
    $id = intval($_POST['id'] ?? 0);
    $datetime = date('Y-m-d H:i:s');


    if ($id > 0) {
        // ── Update ──
        $sql = $conn->prepare(
            'UPDATE subjects SET name=?, coef=?,  disc=?, url_image=?, active=?, updated_at=? WHERE id=?'
        );
        $sql->bind_param('sissisi', $name, $coef, $disc, $url_image, $active, $datetime, $id);
        $sql->execute();
        $sql->close();

        $_SESSION['message'] = 'Subject updated successfully';
    } else {
        // ── Insert ──
        $sql = $conn->prepare(
            'INSERT INTO subjects (name, coef, id_sp, id_sem, disc, url_image, active, created_at) VALUES (?, ?, ?, ?, ?, ? ,? ,?)'
        );
        $sql->bind_param('siisssis', $name, $coef, $_SESSION['idSpc'], $_SESSION['idSem'], $disc, $url_image, $active, $datetime);
        if (!$sql->execute()) {
    die("خطأ في الاستعلام: " . $conn->error);
}
        $sql->close();

        $_SESSION['message'] = 'Subject added successfully';
    }

    $conn->close();
    header('Location: subjects.php');
    exit;
}


// // ──────────────────────────────────────────────
// //  Load subject data — Edit mode
// // ──────────────────────────────────────────────
$editMode = false;

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $sql = $conn->prepare('SELECT * FROM subjects WHERE id = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $res = $sql->get_result();

    if ($res->num_rows === 1) {
        $subject = $res->fetch_assoc();
        $editMode = true;
    }
    $sql->close();
}
$pageTitle = 'Spesialities Add/Update';
include_once('conf/header.php'); ?>
<div class="container-fluid">
    <div class="row">
        <?php include_once('conf/sidebar.php') ?>
        <!-- Main Content -->
        <div class="col-md-10">
            <!-- Top Bar -->
            <?php include_once('conf/navbar.php') ?>

            <!-- Content -->
            <div class="container-fluid">

                <h2 class="mb-4"><i class="fas fa-layer-group me-1"></i> Subject Add/Update</h2>
                <div class="container">
                    
                    
                    <div class="text-end my-3">
                        <a href="subjects.php" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                                    
                                    <i class="fas fa-<?= $editMode ? 'edit' : 'user-plus' ?> me-1"></i>
                                    <?= $editMode ? 'Edit Subject #' . $subject['id'] : 'Add New Subject' ?>
                                </div>

                                <div class="card-body">
                                    <form  method="POST" enctype="multipart/form-data">

                                        <input type="hidden" name="id" value="<?= $subject['id']??'' ?>">
                                        <input type="hidden" name="old_url_image" value="<?= $subject['url_image']??'' ?>">

                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control"
                                                value="<?= $subject['name']??'' ?>" placeholder="Enter subject ame"
                                                required>
                                        </div> 
                                        <div class="mb-3">
                                            <label class="form-label">Price</label>
                                            <input type="file" name="url_image" class="form-control" accept=".jpg,.jpeg,.png,.gif,image/*">
                                        </div>  
                                        <div class="mb-3">
                                            <label class="form-label">Coef</label>
                                            <input type="number" min="0" name="coef" class="form-control" placeholder="Enter Coef">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">disc</label>
                                            <textarea name="disc" class="form-control" placeholder="Enter disc"  rows="4"><?= $subject['disc']??'' ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" 
                                                    name="active" id="checkboxId" value="1"
                                                    <?= ($subject['active'] ?? 1) ? 'checked' : '' ?>>
                                                <label class="form-check-label fw-semibold" for="checkboxId" >Active</label>
                                            </div>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-<?= $editMode ? 'info' : 'primary' ?>">
                                                <i class="fas fa-<?= $editMode ? 'save' : 'plus' ?> me-1"></i>
                                                <?= $editMode ? 'Save Changes' : 'Add Subject' ?>
                                            </button>
                                        </div>

                                    </form>
                                </div>

                                <div class="card-footer">
                                    <small><?= date('Y-m-d') ?></small>
                                    <small class="float-end"><?= date('H:i:s') ?></small>
                                </div>
                            </div>

                       
                </div>

         </div>
            </div>
        </div>
    </div>
</div>

<?php $conn->close(); ?>