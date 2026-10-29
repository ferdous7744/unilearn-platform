<?php

include('session_controller.php');
require_once 'conf/connection.php';
require_once 'conf/globel_functions.php';



// unset($_SESSION['idSem']);
// ──────────────────────────────────────────────
// ── Delete — POST ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $id = intval($_POST['id']);
    $sql = $conn->prepare('DELETE FROM contents WHERE id = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $sql->close();
    $conn->close();

    $_SESSION['message'] = 'Content deleted successfully';
    header('Location: content.php');
    exit;
}

// ──────────────────────────────────────────────
// ── toggle — POST ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'toggle') {
    $id = intval($_POST['id']);
    $sql = $conn->prepare('UPDATE contents SET active = NOT active  WHERE id = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $sql->close();
    $conn->close();

    $_SESSION['message'] = 'Content updated successfully';
    header('Location: content.php');
    exit;
}

// ──────────────────────────────────────────────
//  Add / Update — POST
// ──────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $disc = htmlspecialchars(strip_tags($_POST['disc']));
    $type = htmlspecialchars(strip_tags($_POST['type']));
    $youtube = htmlspecialchars(strip_tags($_POST['youtube']));
    $website = htmlspecialchars(strip_tags($_POST['website']));
    $file_url = uploadFile('subject_images', $_POST['old_file_url'], $_FILES['file_url'], 'pdf');
    $active = isset($_POST['active']) ? 1 : 0;
    if ($file_url == false) {
        $file_url = $_POST['old_file_url'];
    }
    $id = intval($_POST['id'] ?? 0);
    $datetime = date('Y-m-d H:i:s');


    if ($id > 0) {
        // ── Update ──
        $sql = $conn->prepare(
            'UPDATE contents SET name=?, type=?, website=?, youtube=?, disc=?, file_url=?, active=?, updated_at=? WHERE id=?'
        );
        $sql->bind_param('ssssssisi', $name, $type, $website, $youtube, $disc, $file_url, $active, $datetime, $id);
        $sql->execute();
        $sql->close();

        $_SESSION['message'] = 'Content updated successfully';
    } else {
        // ── Insert ──
        $sql = $conn->prepare(
            'INSERT INTO contents (name, type, subject_id, website, youtube, disc, file_url, active, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $sql->bind_param('ssissssis', $name, $type, $_SESSION['idSub'], $website, $youtube, $disc, $file_url, $active, $datetime);
        $sql->execute();
        $sql->close();

        $_SESSION['message'] = 'Content added successfully';
    }

    $conn->close();
    header('Location: content.php');
    exit;
}


// // ──────────────────────────────────────────────
// //  Load subject data — Edit mode
// // ──────────────────────────────────────────────
$editMode = false;
$content = [];
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $sql = $conn->prepare('SELECT * FROM contents WHERE id = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $res = $sql->get_result();

    if ($res->num_rows === 1) {
        $content = $res->fetch_assoc();
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

                <h2 class="mb-4"><i class="fas fa-layer-group me-1"></i> Content Add/Update</h2>

                <div class="container">


                    <div class="text-end my-3">
                        <a href="content.php" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-<?= $editMode ? 'edit' : 'user-plus' ?> me-1"></i>
                            <?= $editMode ? 'Edit Content #' . $content['id'] : 'Add New Content' ?>
                        </div>

                        <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">

                                <input type="hidden" name="id" value="<?= $content['id'] ?? '' ?>">
                                <input type="hidden" name="old_file_url" value="<?= $content['file_url'] ?? '' ?>">
                                <div class="row">

                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="<?= $content['name'] ?? '' ?>" placeholder="Enter subject ame"
                                            required>
                                    </div>
                                    
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">Youtube</label>
                                        <input type="text" name="youtube" class="form-control"
                                            value="<?= $content['youtube'] ?? '' ?>" placeholder="Enter Youtube Video"
                                            >
                                   </div>
                                    
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">WebSite</label>
                                        <input type="url" name="website" class="form-control"
                                            value="<?= $content['website'] ?? '' ?>" placeholder="Enter Link Web site"
                                            >
                                   </div>
                                    
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">Type </label>
                                        <select name="type" class="form-select" required>
                                            <option value="">Select Content Type  </option>
                                            <?php foreach (contentType() as $value):
                                                echo $value; ?>
                                                <option value="<?= $value ?>" <?= ($content['type'] ?? '') === $value ? 'selected' : '' ?>><?= $value ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">Pdf file</label>
                                        <input type="file" name="file_url" class="form-control" accept=".pdf" value="<?= $content['website'] ?? '' ?>" >
                                    </div>
                                    <div class="col-lg-7 mb-3">
                                        <label class="form-label">Disc</label>
                                        <textarea name="disc" class="form-control"
                                            placeholder="Enter disc"
                                            rows="4"><?= $content['disc'] ?? '' ?></textarea>
                                    </div>
                                    <div class="col-lg-5 mb-3">
                                        <label class="form-label">Preview</label>
                                        <?php if (!empty($content['youtube'])): ?>
                                            <iframe width="100%" height="200" src="https://www.youtube.com/embed/<?= htmlspecialchars($content['youtube']) ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                        <?php else: ?>
                                            <p class="text-muted">No YouTube video to preview.</p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="active"
                                                id="checkboxId" value="1" <?= ($content['active'] ?? 1) ? 'checked' : '' ?>>
                                            <label class="form-check-label fw-semibold" for="checkboxId">Active</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-<?= $editMode ? 'info' : 'primary' ?>">
                                        <i class="fas fa-<?= $editMode ? 'save' : 'plus' ?> me-1"></i>
                                        <?= $editMode ? 'Save Changes' : 'Add Content' ?>
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