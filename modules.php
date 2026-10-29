<!DOCTYPE html>
<html lang="en">
<head>
<?php $pageTitle = "Modules"; require_once 'conf/header.php'; ?>
 <?php $style='modules'; require_once 'conf/style.php';
  require_once 'conf/conection.php';
  $specialty_id = isset($_GET['specialty']) ? intval($_GET['specialty']) : null;
  $semester_id = isset($_GET['semester']) ? intval($_GET['semester']) : 1;
  $modules = [];
  if ($specialty_id !== null) {
    $stmt = $conn->prepare("SELECT * FROM subjects WHERE id_sp = ? AND id_sem = ? AND active = 1");
    $stmt->bind_param('ii', $specialty_id, $semester_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
      $modules[] = $row;
    }
    $stmt->close();
  }

 ?>
</head>
<body>

<!-- NAVBAR -->
<?php require_once 'conf/navbar.php' ?>

<!-- PAGE HEADER -->
<div class="bg-white border-bottom py-4">
  <div class="container-lg px-4">
    <nav aria-label="breadcrumb" class="mb-2">
      <ol class="breadcrumb mb-0 small">
        <li class="breadcrumb-item"><a href="levels.php" class="text-muted text-decoration-none fw-semibold">Levels (L1)</a></li>
        <li class="breadcrumb-item active fw-semibold">Semester 1</li>
      </ol>
    </nav>
    <h1 class="fw-bolder fs-2 mb-1">Modules</h1>
    <p class="text-muted mb-3">Browse all available modules for this semester.</p>
    <div class="d-flex flex-wrap gap-2">
      <div class="input-group" style="width:280px;">
        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted small"></i></span>
        <input type="text" class="form-control border-start-0" placeholder="Search by name or code..."
               id="searchInput" oninput="filterModules()" style="border-radius:0 8px 8px 0;"/>
      </div>
      <div class="input-group" style="width:auto;">
        <span class="input-group-text bg-white border-end-0"><i class="bi bi-funnel text-muted small"></i></span>
        <select class="form-select border-start-0" id="typeFilter" onchange="filterModules()" style="border-radius:0 8px 8px 0; min-width:130px;">
          <option value="">Credits</option>
          <option value="basic">1</option>
          <option value="methodological">2</option>
          <option value="discovery">3</option>
          <option value="discovery">4</option>
          <option value="discovery">5</option>
          <option value="discovery">6</option>
        </select>
      </div>
    </div>
  </div>
</div>

<!-- MODULES GRID -->
<div class="container-lg px-4 py-4">
  <div class="row g-4" id="modulesGrid">

    <!-- MODULE CARD TEMPLATE (one card shown) -->
    <?php if (count($modules) > 0): ?>
      <?php foreach ($modules as $module): ?>
        <div class="col-sm-6 col-lg-3 mod-col"
             data-name="<?= htmlspecialchars(strtolower($module['name'] ?? '')) ?>"
             data-code="<?= htmlspecialchars(strtolower($module['disc'] ?? '')) ?>"
             data-type="<?= htmlspecialchars(strtolower($module['coef'] ?? '')) ?>">
          <a href="module-detail.php?id=<?= htmlspecialchars($module['id']); ?>" class="module-link">
            <div class="card border h-100 p-3">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <?php if ($module['url_image']): ?>

                    <img src="<?= 'admin/' . htmlspecialchars($module['url_image']); ?>" ... alt="Image" class="img-thumbnail border-0 mb-3" height="100" width="100">

                  <?php else: ?>
                    <span>No image</span>
                  <?php endif; ?>
                
              </div>
              <div class="fw-bold lh-sm mb-3" style="font-size:2rem;">
                <?= htmlspecialchars($module['name'] ?? '') ?>
              </div>
              <div class="text-uppercase fw-bold mb-1" style="color:#1a237e; font-size:.72rem; letter-spacing:.05em;"><?= htmlspecialchars($module['disc'] ?? '') ?></div>
              <div class="text-muted small mt-auto"><?= htmlspecialchars($module['coef'] ?? '0') ?> Credits</div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <!-- /MODULE CARD TEMPLATE -->

    <div class="col-12 text-center py-5 d-none" id="noResults">
      <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
      <p class="text-muted">No modules found matching your search.</p>
    </div>

  </div>
</div>

<!-- FOOTER -->
<?php require_once 'conf/footer.php' ?>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
  function filterModules() {
    const q    = document.getElementById('searchInput').value.toLowerCase().trim();
    const type = document.getElementById('typeFilter').value.toLowerCase();
    let visible = 0;
    document.querySelectorAll('.mod-col').forEach(col => {
      const ok = (!q    || col.dataset.name.includes(q) || col.dataset.code.includes(q))
              && (!type || col.dataset.type === type);
      col.classList.toggle('hidden', !ok);
      if (ok) visible++;
    });
    document.getElementById('noResults').classList.toggle('d-none', visible > 0);
  }
</script>
</body>
</html>
