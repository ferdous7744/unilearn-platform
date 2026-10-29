<!DOCTYPE html>
<html lang="en">
<?php
require_once 'conf/connection.php';
require_once 'conf/globel_functions.php';
require_once 'conf/header.php';
$content_type = htmlspecialchars(strip_tags($_POST['content_type'] ?? ''));
$id = (int)($_POST['id'] ?? 0);

if($content_type && $id){
    // استخدام Prepared Statement لجلب البيانات بأمان
    $stmt_get = $conn->prepare("SELECT * FROM webinfo WHERE id = ?");
    $stmt_get->bind_param("i", $id);
    $stmt_get->execute();
    $info = $stmt_get->get_result()->fetch_assoc();
}

// 2. معالجة طلب التحديث (عند الضغط على الزر)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_content'])) {
    $new_content = htmlspecialchars(strip_tags($_POST['new_content'] ?? ''));
    if ($new_content) {
        // نستخدم $content_type مباشرة هنا لأنه تم التحقق منه في الخطوة 1
        $stmt = $conn->prepare("UPDATE webinfo SET $content_type = ? WHERE id = ?");
        $stmt->bind_param("si", $new_content, $id);
        if ($stmt->execute()) {
            $_SESSION['message'] = $content_type . " updated successfully.";
        } else {
            $_SESSION['message'] = "Error updating " . $content_type . ": " . $stmt->error;
        }
        $stmt->close();
    }
    header("Location: webinfo.php");
    exit();
}?>
<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php require_once 'conf/sidebar.php' ?>

            <!-- Main Content -->
            <div class="col-md-10">
                <!-- Top Bar -->
                <?php  require_once 'conf/navbar.php' ?>

                <form action="info_control.php" method="post">
                    <input type="hidden" name="content_type" value="<?= $content_type ?>">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="form-group">
                        <label for="new_content">New <?= ucfirst($content_type) ?>:</label>
                        <textarea class="form-control" id="new_content" name="new_content" rows="5"><?= isset($info[$content_type]) ? $info[$content_type] : '' ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>

            </div>
        </div>
    </div>

   <?php require_once 'conf/footer.php' ?>