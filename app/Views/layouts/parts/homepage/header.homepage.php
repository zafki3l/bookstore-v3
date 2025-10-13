<div class="header">
    <ul type="none" class="nav-menu">
        <div class="nav-left">
            <li>
                <div class="dropdown">
                    <button>Category</button>
                    <div class="category-content">
                    <a href="#">Fiction</a>
                    <a href="#">Non-Fiction</a>
                    <a href="#">Science</a>
                    <a href="#">History</a>
                </div>
            <li><a href="/<?= PROJECT_NAME ?>">Homepage</a></li>
            <!-- <?php if($role == 3): ?> <!--admin-->
                    <li><a href="/oop-bookstore/views/admin/dashboard.admin.php?page_number=1">Admin Dashboard</a></li> <!--show dashboard for admin-->
                    <li><a href="/oop-bookstore/views/staff/dashboard.staff.php">Staff Dashboard</a></li>
            <?php elseif($role == 2): ?>
                    <li><a href="../staff/dashboard.php">Staff Dashboard</a></li> <!--Show dashboard for staff-->
            <?php endif; ?> -->
        </div>

        <div class="nav-right">
            <?php if(isset($_SESSION['username'])): ?>
                <li><a href="/oop-bookstore/views/myorder/all.myorder.php">Account</a></li>
                <li>
                    <a href="#" onclick="document.getElementById('logoutForm').submit(); return false;">Logout</a>
                </li>
                <form id="logoutForm" action="/oop-bookstore/actions/auth/logout.auth.php" method="post" style="display:none;">
                    <input type="hidden" name="logout" value="1">
                </form>
            <?php else: ?>
                <li><a href="/<?= PROJECT_NAME ?>/register">Register</a></li>
                <li><a href="/<?= PROJECT_NAME ?>/login">login</a></li>
            <?php endif; ?>
        </div>
    </ul>
</div>