<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/<?= PROJECT_NAME ?>/public/css/staff/dashboard.css">
</head>

<body>
    <div class="main-content">
        <div class="dashboard-grid">
            <div class="div1">
                <div class="dashboard staff-info">
                    <div class="info-header">
                        <h3>STAFF INFORMATION</h3>
                    </div>
                    <div class="info-content">
                        <div class="img">
                            <i class="fa-solid fa-user-circle fa-5x"></i>
                        </div>
                        <div class="text">
                            <p>User ID: <?php echo htmlspecialchars($_SESSION['user']['user_id']); ?></p>
                            <p>Username: <?php echo htmlspecialchars($_SESSION['user']['last_name']); ?></p>
                            <p>Email: <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
                            <p>Role: <?php echo htmlspecialchars($_SESSION['user']['role'] == App\Models\User::ROLE_STAFF ? 'Staff' : 'Admin'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="div2">
                    <a href="books/index.books.php?page_number=1">
                        <div class="dashboard box1 book-manage">Book Management</div>
                    </a>

                    <a href="categories/index.categories.php">
                        <div class="dashboard box1 category-man">Category Management</div>
                    </a>
                </div>
            </div>

            <a href="salesReport/monthly.salesReport.php">
                <div class="div1 bottom">
                    <div class="dashboard sales-report">
                        <div class="chart">
                    <canvas id="myChart"></canvas>
                </div>
            </a>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="/oop-bookstore/public/js/chart.js"></script>
                </div>
                <div class="div2-2">
                    <a href="orders/index.orders.php?page_number=1">
                        <div class=" box2 order-manage">Order Management</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>