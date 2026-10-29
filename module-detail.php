<?php
require_once 'conf/conection.php';

// ── جلب المادة ──
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
  header('Location: modules.php');
  exit;
}

$stmt = $conn->prepare(
  "SELECT s.*, sp.sname AS specialty_name, sem.name AS semester_name
   FROM subjects s
   LEFT JOIN spc sp ON sp.id = s.id_sp
   LEFT JOIN semester sem ON sem.id = s.id_sem
   WHERE s.id = ? AND s.active = 1"
);
$stmt->bind_param('i', $id);
$stmt->execute();
$module = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$module) {
  header('Location: modules.php');
  exit;
}

// ── جلب المحتويات وتجميعها حسب النوع ──
$stmt = $conn->prepare("SELECT * FROM contents WHERE subject_id = ? AND active = 1 ORDER BY created_at DESC, id DESC");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$groups = [];
while ($row = $res->fetch_assoc()) {
  $groups[$row['type']][] = $row;
}
$stmt->close();

$types = array_keys($groups);
$currentTab = $_GET['tab'] ?? ($types[0] ?? '');
if (!isset($groups[$currentTab])) {
  $currentTab = $types[0] ?? '';
}

function e($v) { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }

function fileSizeText($path) {
  if (!is_file($path)) return '';
  $b = filesize($path);
  if ($b >= 1048576) return round($b / 1048576, 1) . ' MB';
  if ($b >= 1024)    return round($b / 1024) . ' KB';
  return $b . ' B';
}

$backUrl = 'modules.php?semester=' . intval($module['id_sem']) . '&specialty=' . intval($module['id_sp']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <?php $pageTitle = e($module['name']); require_once 'conf/header.php'; ?>
 <?php $style = 'module-detail'; require_once 'conf/style.php' ?>
  <style>
    body { font-family: 'Segoe UI', system-ui, sans-serif; background:#f3f4f8; }
    .content-tab { flex:1; display:block; text-decoration:none; border-bottom:3px solid transparent; padding:1rem .75rem; font-size:.9rem; font-weight:600; color:#6b7280; text-align:center; transition:color .2s, border-color .2s; }
    .content-tab:hover { color:#1a237e; background:#f8f9ff; }
    .content-tab.active { color:#0d1257; border-bottom:3px solid #0d1257; }
    .file-row { transition:background .15s; }
    .file-row:hover { background:#f8f9ff !important; }
    .file-icon { width:42px; height:42px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
  </style>
</head>
<body>

<!-- NAVBAR -->
<?php require_once 'conf/navbar.php' ?>

<div class="container-lg px-4 py-4" style="max-width:960px;">

  <a href="<?= e($backUrl) ?>" class="d-inline-flex align-items-center gap-2 text-muted text-decoration-none fw-semibold small mb-3">
    <i class="bi bi-arrow-left"></i> Back to Modules
  </a>

  <!-- Hero -->
  <div class="card border rounded-4 p-4 mb-4">
    <div class="d-flex align-items-center gap-2 mb-3">
      <span class="badge rounded-pill fw-semibold" style="background:#ede9fe;color:#5b21b6;"><?= e($module['specialty_name']) ?></span>
      <span class="fw-bold small text-secondary">
        <?= e($module['semester_name']) ?> &bull; <?= e($module['coef']) ?> Credits
      </span>
    </div>
    <h1 class="fw-bolder mb-3" style="font-size:clamp(1.6rem,4vw,2.6rem);color:#0d1257;line-height:1.15;">
      <?= e($module['name']) ?>
    </h1>
    <p class="text-muted mb-0" style="max-width:720px;line-height:1.7;">
      <?= e($module['disc']) ?: 'No description available.' ?>
    </p>
  </div>

  <!-- Tabs -->
  <div class="card border rounded-4 overflow-hidden">

    <?php if (empty($groups)): ?>
      <div class="p-5 text-center text-muted">
        <i class="bi bi-folder2-open fs-1 d-block mb-3"></i>
        No content available for this module yet.
      </div>
    <?php else: ?>

      <!-- Tab buttons -->
      <div class="d-flex border-bottom bg-white">
        <?php foreach ($types as $type): ?>
          <a class="content-tab <?= $type === $currentTab ? 'active' : '' ?>"
             href="module-detail.php?id=<?= $id ?>&tab=<?= urlencode($type) ?>">
            <?= e($type) ?> (<?= count($groups[$type]) ?>)
          </a>
        <?php endforeach; ?>
      </div>

      <!-- Tab panel -->
      <div class="p-3">
        <?php foreach ($groups[$currentTab] as $c):
          $filePath = !empty($c['file_url']) ? 'admin/' . $c['file_url'] : '';
          $size = $filePath ? fileSizeText($filePath) : '';
          $date = !empty($c['created_at']) ? date('Y-m-d', strtotime($c['created_at'])) : '-';
        ?>
          <div class="file-row d-flex align-items-center justify-content-between flex-wrap gap-2 p-3 border rounded-3 mb-2 bg-white">
            <div class="d-flex align-items-center gap-3">
              <div class="file-icon" style="background:#fee2e2;">
                <i class="bi <?= $filePath ? 'bi-file-earmark-pdf' : (!empty($c['youtube']) ? 'bi-youtube' : 'bi-link-45deg') ?>" style="color:#dc2626;"></i>
              </div>
              <div>
                <div class="fw-bold small"><?= e($c['name']) ?></div>
                <div class="text-muted" style="font-size:.78rem;">
                  <?= e($date) ?><?= $size ? ' &bull; ' . e($size) : '' ?>
                </div>
                <?php if (!empty($c['disc'])): ?>
                  <div class="text-muted" style="font-size:.78rem;"><?= e($c['disc']) ?></div>
                <?php endif; ?>
              </div>
            </div>

            <div class="d-flex gap-2">
              <?php if ($filePath): ?>
                <a href="<?= e($filePath) ?>" download class="btn btn-sm border fw-semibold d-inline-flex align-items-center gap-2 small" style="border-radius:8px;">
                  <i class="bi bi-download"></i> Download
                </a>
              <?php endif; ?>

              <?php if (!empty($c['youtube'])): ?>
                <a href="https://www.youtube.com/watch?v=<?= urlencode($c['youtube']) ?>" target="_blank" rel="noopener"
                   class="btn btn-sm border fw-semibold d-inline-flex align-items-center gap-2 small" style="border-radius:8px;">
                  <i class="bi bi-youtube text-danger"></i> Video
                </a>
              <?php endif; ?>

              <?php if (!empty($c['website'])): ?>
                <a href="<?= e($c['website']) ?>" target="_blank" rel="noopener"
                   class="btn btn-sm border fw-semibold d-inline-flex align-items-center gap-2 small" style="border-radius:8px;">
                  <i class="bi bi-box-arrow-up-right"></i> Website
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    <?php endif; ?>

  </div>
</div>

<!-- FOOTER -->
<?php require_once 'conf/footer.php' ?>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>