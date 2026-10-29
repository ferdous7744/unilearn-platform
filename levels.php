<!DOCTYPE html>
<html lang="en">
<head>
<?php 
$pageTitle = "levels page";
require_once 'conf/header.php';
require_once 'conf/conection.php';

$yearResult = $conn->query("SELECT * FROM year");
$specialty_id = isset($_GET['specialty']) ? intval($_GET['specialty']) : 1;
$semResult  = $conn->query("SELECT * FROM semester");


$semesters = [];
while ($row = $semResult->fetch_assoc()) {
    $semesters[$row['id_year']][] = $row;
}
?>
<?php $style = 'levels'; require_once 'conf/style.php'; ?>
</head>
<body>

<?php require_once 'conf/navbar.php'; ?>

<!-- PAGE HEADER + TABS -->
<div class="bg-white border-bottom pt-4">
  <div class="container-lg px-4">
    <p class="text-muted small fw-semibold d-flex align-items-center gap-2 mb-1">
      <i class="bi bi-layers-fill" style="color:#1a237e;"></i> Academic Structure
    </p>
    <h1 class="fw-bolder fs-2 mb-3">Academic Levels</h1>
    <div class="d-flex overflow-auto" id="levelTabs">
      <?php
      $first = true;
      $yearResult->data_seek(0);
      while ($year = $yearResult->fetch_assoc()):
      ?>
        <button class="level-tab <?= $first ? 'active' : '' ?>"
                data-level="<?= $year['id'] ?>">
          <?= $year['name'] ?>
        </button>
      <?php $first = false; endwhile; ?>
    </div>
  </div>
</div>

<!-- MAIN -->
<div class="container-lg px-4 py-4">
  <?php
  $yearResult->data_seek(0);
  $first = true;
  while ($year = $yearResult->fetch_assoc()):
  ?>
  <div class="level-panel <?= $first ? '' : 'd-none' ?>" id="panel-<?= $year['id'] ?>">
    <div class="bg-white border rounded-4 overflow-hidden">

      <div class="p-4 pb-2">
        <h4 class="fw-bold mb-1"><?= $year['name'] ?> Curriculum</h4>
        <p class="text-muted small">
          Explore the semester structure and module distribution for <?= $year['name'] ?>.
        </p>
      </div>

      <?php if (!empty($semesters[$year['id']])): ?>
        <?php foreach ($semesters[$year['id']] as $sem): ?>
        <div class="sem-header px-4 py-3 d-flex align-items-center justify-content-between"
             onclick="toggleSem(this)">
          <div class="d-flex align-items-center gap-3">
            <span class="fw-bold fs-6"><?= $sem['name'] ?></span>
            <span class="badge rounded-pill fw-semibold"
                  style="background:#eef0fb; color:#1a237e; font-size:.78rem;">
              <!-- module count query -->
              <?php
                $sid = $sem['id'];
                $modCount = $conn->query("SELECT COUNT(*) as cnt FROM subjects WHERE id_sem = $sid");
                $cnt = $modCount->fetch_assoc();
                echo $cnt['cnt'];
              ?> Modules
            </span>
          </div>
          <i class="bi bi-chevron-down text-muted sem-icon"></i>
        </div>
        <div class="sem-body px-4 pb-4">
          <p class="text-muted small mb-3 mt-2">
            <?= $sem['name'] ?> — Academic year content
          </p>
          <a href="modules.php?semester=<?= $sem['id'] ?>&specialty=<?= $specialty_id ?>"
   class="btn btn-sm border fw-semibold d-inline-flex align-items-center gap-2"
   style="border-radius:8px; color:#374151;">
  View Modules <i class="bi bi-chevron-right"></i>
</a>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-muted small px-4 pb-4">No semesters found for this level.</p>
      <?php endif; ?>

    </div>
  </div>
  <?php $first = false; endwhile; ?>
</div>

<?php require_once 'conf/footer.php'; ?>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
  document.querySelectorAll('.level-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.level-tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.level-panel').forEach(p => p.classList.add('d-none'));
      tab.classList.add('active');
      document.getElementById('panel-' + tab.dataset.level).classList.remove('d-none');
    });
  });

  function toggleSem(header) {
    const body   = header.nextElementSibling;
    const icon   = header.querySelector('.sem-icon');
    const isOpen = body.classList.contains('show');
    header.closest('.bg-white').querySelectorAll('.sem-body').forEach(b => b.classList.remove('show'));
    header.closest('.bg-white').querySelectorAll('.sem-icon').forEach(i => i.classList.remove('open'));
    if (!isOpen) { body.classList.add('show'); icon.classList.add('open'); }
  }
</script>
</body>
</html>