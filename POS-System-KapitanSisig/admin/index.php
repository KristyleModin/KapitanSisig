<?php include('includes/header.php'); ?>

<div class="container-fluid px-4 pb-4">
    <div class="pt-4">
        <?php alertMessage(); ?>
    </div>
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>

    <div class="row">
        <!-- Menu Products Section -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <?php
                    $productsQuery = "SELECT COUNT(*) AS total_products FROM products";
                    $productsResult = mysqli_query($conn, $productsQuery);
                    $totalProducts = mysqli_fetch_assoc($productsResult)['total_products'];
                    ?>
                    <h4>Menu Products</h4>
                    <h2><?= $totalProducts; ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="products.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <!-- Total Sales for the Month Section
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <?php
                    // Calculate the first and last day of the current month
                    $currentMonth = date('Y-m');
                    $startDate = $currentMonth . '-01';
                    $endDate = date('Y-m-t', strtotime($startDate));

                    // Query for total sales for the current month
                    $salesQuery = "SELECT SUM(total_amount) AS total_sales 
                                   FROM orders 
                                   WHERE order_status = 'Completed' 
                                   AND order_date BETWEEN '$startDate' AND '$endDate'";
                    $salesResult = mysqli_query($conn, $salesQuery);
                    $totalSales = mysqli_fetch_assoc($salesResult)['total_sales'];
                    ?>
                    <h4>Total Sales This Month</h4>
                    <h2>Php <?= number_format($totalSales, 2); ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="sales.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div> -->

        <!-- Ingredients Section -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <?php
                    $ingredientsQuery = "SELECT COUNT(*) AS total_ingredients FROM ingredients";
                    $ingredientsResult = mysqli_query($conn, $ingredientsQuery);
                    $totalIngredients = mysqli_fetch_assoc($ingredientsResult)['total_ingredients'];
                    ?>
                    <h4>Ingredients</h4>
                    <h2><?= $totalIngredients; ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="ingredients-view.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>