<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  
  $pageTitle = "main page";
  require_once 'conf/header.php';
  require_once 'conf/conection.php';
  $qury = "SELECT * FROM spc where active = 1";
  $spc = $conn->query($qury);
  $totalspc = $spc->num_rows;
  $nb = 1; 
   $qury = "SELECT * FROM contents where active = 1";
  $content = $conn->query($qury);
  $totalcontent = $content->num_rows;
   $qury = "SELECT * FROM subjects where active = 1";
  $subjects = $conn->query($qury);
  $totalsub = $subjects->num_rows;
  $qury = "SELECT * FROM webinfo ";
  $webinfoResult = $conn->query($qury);
  $webinfo = $webinfoResult ? $webinfoResult->fetch_assoc() : [];
  ?>
  <?php $style = 'index';
  require_once 'conf/style.php' ?>
</head>

<body>

  <!-- NAVBAR -->
  <?php require_once 'conf/navbar.php' ?>

  <!-- HERO -->
  <section class="hero-section d-flex align-items-center">
    <div class="container-fluid px-4 px-lg-5 position-relative" style="z-index:2;">
      <div class="row">
        <div class="col-lg-7">
          <h1 class="display-3 fw-bolder text-white lh-sm mb-4">
            Welcome to the<br>University Learning<br>Platform
          </h1>
          <p class="text-white-50 fs-5 mb-5" style="max-width:520px; line-height:1.7;">
            <?=$webinfo['objective']?$webinfo['objective'] : 'Welcome to our learning platform!' ?>
          </p>
          <div class="d-flex flex-wrap gap-3">
            <a href="#specialties" class="btn btn-light fw-bold px-4 py-2" style="border-radius:8px; color:#1a237e;">
              Explore Now
            </a>
            <a href="modules.php" class="btn fw-bold px-4 py-2 text-white" style="border-radius:8px; border:2px solid rgba(255,255,255,.6); background:transparent;">
              Browse Modules
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- STATS -->
  <section class="bg-white border-bottom">
    <div class="row g-0 text-center">
<
      <!-- STAT CARD TEMPLATE (repeat this block for each stat) -->
      <div class="col-lg-3 stat-divider py-5">
        <div class="d-flex justify-content-center mb-3">
          <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px;background:#eef0fb;">
            <i class="bi bi-people fs-4" style="color:#1a237e;"></i>
          </div>
        </div>
        <div class="fw-bolder fs-1"><?= $totalspc ?></div>
        <div class="text-muted small fw-semibold">specialties available</div>
      </div>
       <div class="col-lg-4 stat-divider py-5">
        <div class="d-flex justify-content-center mb-3">
          <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px;background:#eef0fb;">
            <i class="bi bi-file-earmark-text fs-4" style="color:#1a237e;"></i>
          </div>
        </div>
        <div class="fw-bolder fs-1"><?= $totalcontent ?></div>
        <div class="text-muted small fw-semibold">contents available</div>
      </div>
       <div class="col-lg-4 stat-divider py-5">
        <div class="d-flex justify-content-center mb-3">
          <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px;background:#eef0fb;">
            <i class="bi bi-book fs-4" style="color:#1a237e;"></i>
          </div>
        </div>
        <div class="fw-bolder fs-1"><?= $totalsub ?></div>
        <div class="text-muted small fw-semibold">subjects available</div>
      </div>
      <!-- /STAT CARD TEMPLATE -->

    </div>
  </section>

  <!-- SPECIALTIES -->
  <section class="py-5" id="specialties">
    <div class="container-lg">

      <!-- Header -->
      <div class="d-flex flex-wrap align-items-start justify-content-between mb-4 gap-3">
        <div>
          <h2 class="fw-bolder fs-2 mb-1">Academic Specialties</h2>
          <p class="text-muted mb-0">Discover programs tailored to your career goals.</p>
        </div>
        <div class="input-group" style="width:240px;">
          <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
          <input type="text" class="form-control border-start-0" placeholder="Search specialties..." id="searchInput" oninput="filterCards(this.value)" style="border-radius:0 8px 8px 0;" />
        </div>
      </div>

      <!-- Cards -->
      <div class="row g-4" id="cardsGrid">
        <?php while ($row = $spc->fetch_assoc()) { ?>
          <!-- SPECIALTY CARD TEMPLATE (repeat this block for each specialty) -->
          <div class="col-md-6 col-lg-4 specialty-col" data-name="<?= $row['id']; ?>">
            <a href="levels.php?specialty=<?=$row['id']; ?>" class="specialty-link">
              <div class="card border rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4">
                  <?php if ($row['url_image']): ?>

                    <img src="<?= 'admin/' . htmlspecialchars($row['url_image']); ?>" ... alt="Image" class="img-thumbnail border-0 mb-3" height="100" width="100">

                  <?php else: ?>
                    <span>No image</span>
                  <?php endif; ?>
                  <h5 class="fw-bold mb-1"><?php echo $row['sname']; ?></h5>
                  <p class="text-muted small mb-0"><?= $row['disc']; ?></p>
                </div>
                <div class="card-footer bg-white border-top text-center py-3">
                  <span class="fw-semibold small text-secondary">Explore <?php echo $row['sname']; ?></span>
                  <i class="bi bi-book ms-2 text-secondary small"></i>
                </div>
              </div>
            </a>
          </div><?php } ?>
        <!-- /SPECIALTY CARD TEMPLATE -->

      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <?php require_once 'conf/footer.php' ?>

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    function filterCards(q) {
      q = q.toLowerCase().trim();
      document.querySelectorAll('.specialty-col').forEach(col => {
        const match = !q || col.dataset.name.includes(q) || col.innerText.toLowerCase().includes(q);
        col.style.display = match ? '' : 'none';
      });
    }
  </script>
</body>

</html>