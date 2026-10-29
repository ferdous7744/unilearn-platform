<?php 
if($style == 'index'){?>
  
  <style>
    :root {
      --bs-primary: #1a237e;
      --bs-primary-rgb: 26,35,126;
    }
    body { font-family: 'Segoe UI', system-ui, sans-serif; background:#f3f4f8; }

    /* Hero */
    .hero-section {
      min-height: 82vh;
      background: linear-gradient(135deg, #0d1257 0%, #1a237e 55%, #3949ab 100%);
      position: relative;
      overflow: hidden;
    }
    .hero-section::before {
      content:'';
      position:absolute; inset:0;
      background: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1600&q=60') center/cover no-repeat;
      opacity:.15;
    }

    /* Stat divider */
    .stat-divider { border-right: 1px solid #e5e7eb; }
    .stat-divider:last-child { border-right: none; }

    /* Specialty card click */
    .specialty-link { text-decoration:none; color:inherit; display:block; }
    .specialty-link:hover .card { transform:translateY(-4px); box-shadow:0 8px 28px rgba(26,35,126,.12) !important; }
    .specialty-link .card { transition: transform .2s, box-shadow .2s; }

    /* Badge colors */
    .icon-wrap { width:52px; height:52px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; }
  </style>
<?php }?>
<?php if($style == 'levels'){
  ?>
  <style>
    body { font-family: 'Segoe UI', system-ui, sans-serif; background:#f3f4f8; }

    /* Level tabs */
    .level-tab {
      border: none; background: none;
      border-bottom: 3px solid transparent;
      padding: .75rem 1.5rem;
      font-weight: 600; font-size: .92rem;
      color: #6b7280; white-space: nowrap;
      transition: color .2s, border-color .2s;
    }
    .level-tab:hover { color: #1a237e; }
    .level-tab.active { color: #0d1257; border-bottom: 3px solid #0d1257; }

    /* Semester accordion row */
    .sem-header {
      cursor: pointer;
      border-top: 1px solid #e5e7eb;
      transition: background .15s;
    }
    .sem-header:hover { background: #f8f9ff; }
    .sem-body { display: none; }
    .sem-body.show { display: block; }
    .sem-icon { transition: transform .2s; }
    .sem-icon.open { transform: rotate(180deg); }
  </style>
   <?php }; ?>
<?php if($style == 'modules'){ 
  ?>
 <style>
    body { font-family: 'Segoe UI', system-ui, sans-serif; background:#f3f4f8; }
    .module-link { text-decoration: none; color: inherit; display: block; }
    .module-link .card { border-radius:14px; transition: transform .2s, box-shadow .2s; cursor:pointer; }
    .module-link:hover .card { transform:translateY(-4px); box-shadow:0 8px 28px rgba(26,35,126,.12) !important; }
    .icon-box { width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; }
    .mod-col.hidden { display: none !important; }
  </style>
   <?php }; ?>
<?php if($style == 'module-detail'){
  ?>
  <style>
    body { font-family: 'Segoe UI', system-ui, sans-serif; background:#f3f4f8; }
    .content-tab { flex:1; border:none; background:none; border-bottom:3px solid transparent; padding:1rem .75rem; font-size:.9rem; font-weight:600; color:#6b7280; text-align:center; transition:color .2s, border-color .2s; cursor:pointer; }
    .content-tab:hover { color:#1a237e; background:#f8f9ff; }
    .content-tab.active { color:#0d1257; border-bottom:3px solid #0d1257; }
    .tab-panel { display:none; }
    .tab-panel.active { display:block; }
    .file-row { transition:background .15s; }
    .file-row:hover { background:#f8f9ff !important; }
    .file-icon { width:42px; height:42px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
  </style>
   <?php
}; ?>
<?php if($style == ''){
  
} ?>