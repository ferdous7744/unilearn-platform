<?php
session_start();

require_once 'conf/globel_functions.php';


require_once 'conf/connection.php';

// ──────────────────────────────────────────────
// ── Delete — POST ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $id  = intval($_POST['id']);
    $sql = $conn->prepare('DELETE FROM spc WHERE id = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $sql->close();
    $conn->close();

    $_SESSION['message'] = 'spc deleted successfully';
    header('Location: spc.php');
    exit;
}
// ──────────────────────────────────────────────
// ── active — POST ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'toggle') {
    $id  = intval($_POST['id']);
    $sql = $conn->prepare('UPDATE spc SET active = NOT active WHERE id = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $sql->close();
    $conn->close();

    $_SESSION['message'] = 'spc updated successfully';
    header('Location: spc.php');
    exit;
}

// ──────────────────────────────────────────────
//  Add / Update — POST
// ──────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sname = htmlspecialchars(strip_tags($_POST['sname']));
    $active = isset($_POST['active']) ? 1 : 0;
    $disc = htmlspecialchars(strip_tags($_POST['disc'] ?? ''));
    $id = intval($_POST['id'] ?? 0);
    $datetime = date('Y-m-d H:i:s');
    $url_image = uploadFile('sp_image', $_POST['old_url_image'], $_FILES['url_image'], 'image');
    if($url_image == false){
        $url_image = $_POST['old_url_image'];
    }


    if ($id > 0) {
        // ── Update ──
        $sql = $conn->prepare(
            'UPDATE spc SET sname=?, active=?, update_at=?, disc=?, url_image=? WHERE id=?'
        );
        if ($sql) {
            $sql->bind_param('sisssi', $sname, $active, $datetime, $disc, $url_image, $id);
            $sql->execute();
            $sql->close();
            
            $_SESSION['message'] = "File updated: " . $_POST['old_url_image'] . " to " . $url_image;
        } else {
            $_SESSION['message'] = 'Error preparing SQL statement: ' . $conn->error;
        }
    } else {
        // ── Insert ──
        $sql = $conn->prepare(
            'INSERT INTO spc (sname, active, creat_at, disc, url_image) VALUES (?, ?, ?, ?, ?)'
        );
        if ($sql) {
            $sql->bind_param('sssss', $sname, $active, $datetime, $disc, $url_image);
            $sql->execute();
            $sql->close();
            $_SESSION['message'] = 'speciality added successfully';
        } else {
            $_SESSION['message'] = 'Error preparing SQL statement: ' . $conn->error;
        }
    }

    $conn->close();
    header('Location: spc.php');
    exit;
}

// ──────────────────────────────────────────────
//  Load spc data — Edit mode
// ──────────────────────────────────────────────
$editMode = false;

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $sql = $conn->prepare('SELECT * FROM spc WHERE id = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $res = $sql->get_result();

    if ($res->num_rows === 1) {
        $spc = $res->fetch_assoc();
        $editMode = true;
    }
    $sql->close();
    
}
?>
<!DOCTYPE html>
<html lang="en">

<?php 

require_once 'conf/header.php'; ?>

<body>
    <div class="container-fluid">
        <div class="row ">
            <?php require_once 'conf/sidebar.php' ?>

           
            <div class="col">
                <?php require_once 'conf/navbar.php' ?>

                <div class="text-end my-3">
                    <a href="spc.php" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>

                <h2 class="text-center m-5">
                    <i class="fas fa-<?= $editMode ? 'edit' : 'user-plus' ?> me-1"></i>
                    
                    <?= $editMode ? 'Edit speciality #' . $spc['id'] : 'Add New speciality' ?>
                    </h2>
                <div class="card">
                    
                        
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $spc['id'] ?? '' ?>">
                            <input type="hidden" name="old_url_image" value="<?= $spc['url_image'] ?? '' ?>">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="sname" class="form-control"
                                    value="<?= $spc['sname'] ?? '' ?>" placeholder="Enter speciality "
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="url_image" class="form-control"
                                    accept="*.jpg,*.jpeg ,*.png ,*.gif ">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>

                               
                                    <textarea name="disc" id="disc" placeholder="write description" class="form-control"><?= $spc['disc'] ?? '' ?></textarea>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="active" type="checkbox" id="checkactive" value="1"
                                        <?= (isset($spc['active']) ? $spc['active'] : '1') ? 'checked' : '' ?> >
                                    <label class="form-check-label" for="checkactive"> active</label>
                                </div>
                            </div>





                            <div class="d-grid">
                                <button type="submit" class="btn btn-<?= $editMode ? 'success' : 'primary' ?>">
                                    <i class="fas fa-<?= $editMode ? 'save' : 'plus' ?> me-1"></i>
                                    <?= $editMode ? 'Save Changes' : 'Add Speciality' ?>
                                </button>
                            </div>

                        </form>
                        <div class="m-3">

                            <small><?= date('Y-m-d') ?></small>
                            <small class="float-end"><?= date('H:i:s') ?></small>
                        </div>
                    </div>

                   
                    
                </div>

            </div>
        </div>
    </div>
</body>

</html>
