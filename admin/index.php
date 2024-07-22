<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">

    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Dashboard</h1>
            <?php alertMessage(); ?>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body bg-primary p-3">
                <p class="text-sm mb-0 text-capitalized">Total Category</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('categories'); ?>
                </h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body bg-warning p-3">
                <p class="text-sm mb-0 text-capitalized">Total Products</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('products'); ?>
                </h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body bg-info p-3">
                <p class="text-sm mb-0 text-capitalized">Total Customers</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('customers'); ?>
                </h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body bg-danger p-3">
                <p class="text-sm mb-0 text-capitalized">Monthly Sales Report</p>
                <h5 class="fw-bold mb-0">
                    <?php
                    $totalSales = mysqli_query($conn, "SELECT SUM(total_amount) AS total_sales FROM orders");
                    if ($totalSales) {
                        $totalSalesAmount = mysqli_fetch_assoc($totalSales)['total_sales'];
                        echo number_format($totalSalesAmount, 2);
                    } else {
                        echo '0.00';
                    }
                    ?>
                </h5>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <hr>
            <h5>Orders</h5>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-capitalized">Today Orders</p>
                <h5 class="fw-bold mb-0">
                    <?php
                    $todayDate = date('Y-m-d');
                    $todayOrders = mysqli_query($conn, "SELECT * FROM orders WHERE order_date='$todayDate'");
                    if ($todayOrders) {
                        $totalCountOrders = mysqli_num_rows($todayOrders);
                        echo $totalCountOrders;
                    } else {
                        echo '0';
                    }
                    ?>
                </h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-capitalized">Total Orders</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('orders'); ?>
                </h5>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <hr>
            <h5>Monthly Sales Report</h5>
        </div>

        <div class="col-md-12 mb-3">
            <div class="card card-body p-3">
                <?php
                // Define the query to get monthly sales data
                $query = "SELECT 
                            DATE_FORMAT(order_date, '%Y-%m') AS month, 
                            COUNT(*) AS total_orders, 
                            SUM(total_amount) AS total_sales 
                          FROM orders 
                          GROUP BY month 
                          ORDER BY month DESC";

                $result = mysqli_query($conn, $query);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        ?>
                        <table class="table table-striped table-bordered align-items-center justify-content-center">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Total Orders</th>
                                    <th>Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <tr>
                                        <td><?= date('F Y', strtotime($row['month'] . '-01')); ?></td>
                                        <td><?= $row['total_orders']; ?></td>
                                        <td><?= number_format($row['total_sales'], 2); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <?php
                    } else {
                        echo "<h5>No Record Available</h5>";
                    }
                } else {
                    echo "<h5>Something Went Wrong</h5>";
                }
                ?>
            </div>
        </div>

    </div>
                
</div>

<?php include('includes/footer.php'); ?>
