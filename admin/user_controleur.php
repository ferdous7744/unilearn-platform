<?php

require_once 'conf/globel_functions.php';
require_once 'session_controller.php';

require_once 'conf/connection.php';

// ──────────────────────────────────────────────
// ── Delete — POST ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $id  = intval($_POST['id']);
    $sql = $conn->prepare('DELETE FROM users WHERE id = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $sql->close();
    $conn->close();

    $_SESSION['message'] = 'users deleted successfully';
    header('Location: user.php');
    exit;
}
// ──────────────────────────────────────────────
// ── active — POST ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'toggle') {
    $id  = intval($_POST['id']);
    $sql = $conn->prepare('UPDATE users SET active = NOT active WHERE id = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $sql->close();
    $conn->close();

    $_SESSION['message'] = 'users updated successfully';
    header('Location: user.php');
    exit;
}

// ──────────────────────────────────────────────
//  Add / Update — POST
// ──────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars(strip_tags($_POST['name']));
    $active = isset($_POST['active']) ? 1 : 0;
    $email = htmlspecialchars(strip_tags($_POST['email'] ?? ''));
    $role = htmlspecialchars(strip_tags($_POST['role'] ?? ''));
    $password = htmlspecialchars(strip_tags($_POST['password'] ?? ''));
    $gender = htmlspecialchars(strip_tags($_POST['gender'] ?? ''));
    $id = intval($_POST['id'] ?? 0);
    $datetime = date('Y-m-d H:i:s');
    $url_image = uploadFile('user_image', $_POST['old_url_image'], $_FILES['url_image'], 'image');
    if($url_image == false){
        $url_image = $_POST['old_url_image'];
    }


    if ($id > 0) {
        // ── Update ──
        $sql = $conn->prepare(
            'UPDATE users SET name=?, active=?, updated_at=?, email=?, url_image=? , role=?, gender=? , password=? WHERE id=?'
        );
        if ($sql) {
            $sql->bind_param('sissssssi', $name, $active, $datetime, $email, $url_image, $role, $gender, $password, $id);
            $sql->execute();
            $sql->close();
            
            $_SESSION['message'] = "File updated: " . $_POST['old_url_image'] . " to " . $url_image;
        } else {
            $_SESSION['message'] = 'Error preparing SQL statement: ' . $conn->error;
        }
    } else {
        // ── Insert ──
        $sql = $conn->prepare(
            'INSERT INTO users (name, active, created_at, email, url_image, role, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        if ($sql) {
            $sql->bind_param('sissssss', $name, $active, $datetime, $email, $url_image, $role, $gender, $password);
            $sql->execute();
            $sql->close();
            $_SESSION['message'] = 'User added successfully';
        } else {
            $_SESSION['message'] = 'Error preparing SQL statement: ' . $conn->error;
        }
    }

    $conn->close();
    header('Location: user.php');
    exit;
}

// ──────────────────────────────────────────────
//  Load users data — Edit mode
// ──────────────────────────────────────────────
$editMode = false;

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $sql = $conn->prepare('SELECT * FROM users WHERE id = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $res = $sql->get_result();

    if ($res->num_rows === 1) {
        $users = $res->fetch_assoc();
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
                    <a href="users.php" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>

                <h2 class="text-center m-5">
                    <i class="fas fa-<?= $editMode ? 'edit' : 'user-plus' ?> me-1"></i>
                    
                    <?= $editMode ? 'Edit User #' . $users['id'] : 'Add New User' ?>
                    </h2>
                <div class="card">
                    
                        
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $users['id'] ?? '' ?>">
                            <input type="hidden" name="old_url_image" value="<?= $users['url_image'] ?? '' ?>">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="<?= $users['name'] ?? '' ?>" placeholder="Enter User "
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="url_image" class="form-control"
                                    accept="*.jpg,*.jpeg ,*.png ,*.gif ">
                            </div>
                            <div>
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?= $users['email'] ?? '' ?>" placeholder="Enter email " >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">password</label>

                               
                                    <input type="password" name="password" class="form-control"
                                    placeholder="Enter password " >
                            </div>
                            <div>
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="male" <?= (isset($users['gender']) && $users['gender'] === 'male') ? 'selected' : '' ?>>Male</option>
                                    <option value="female" <?= (isset($users['gender']) && $users['gender'] === 'female') ? 'selected' : '' ?>>Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">role</label>
                                <select name="role" class="form-control">
                                    <option value="admin" <?= (isset($users['role']) && $users['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                                    <option value="user" <?= (isset($users['role']) && $users['role'] === 'user') ? 'selected' : '' ?>>User</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="active" type="checkbox" id="checkactive" value="1"
                                        <?= (isset($users['active']) ? $users['active'] : '1') ? 'checked' : '' ?> >
                                    <label class="form-check-label" for="checkactive"> active</label>
                                </div>
                            </div>





                            <div class="d-grid">
                                <button type="submit" class="btn btn-<?= $editMode ? 'success' : 'primary' ?>">
                                    <i class="fas fa-<?= $editMode ? 'save' : 'plus' ?> me-1"></i>
                                    <?= $editMode ? 'Save Changes' : 'Add User' ?>
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
