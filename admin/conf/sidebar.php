 <!-- Sidebar -->
            <div class="col-md-2 px-0 sidebar">
                <div class="p-3">
                    <h4 class="text-white text-center mb-4">Dashboard</h4>
                    <nav class="nav flex-column">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" href="index.php">
                            <i class="fas fa-home m-2"></i>Home
                        </a>
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'spc.php') ? 'active' : ''; ?>" href="spc.php">
                            <i class="fas fa-star m-2 "></i>Speciality
                        </a>
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'subjects.php') ? 'active' : ''; ?>" href="subjects.php">
                            <i class="fas fa-archive m-2"></i>modules
                        </a>
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'user.php') ? 'active' : ''; ?>" href="user.php">
                            <i class="fas fa-users m-2"></i>Users
                        </a>
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'content.php') ? 'active' : ''; ?>" href="content.php">
                            <i class="fas fa-file m-2"></i>content
                        </a>
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'webinfo.php') ? 'active' : ''; ?>" href="webinfo.php">
                            <i class="fas fa-globe m-2"></i>web information
                        </a>
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'setting.php') ? 'active' : ''; ?>" href="setting.php">
                            <i class="fas fa-tools m-2"></i>setting
                        </a>
                    </nav>
                </div>
            </div>