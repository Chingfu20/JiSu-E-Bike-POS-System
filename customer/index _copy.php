<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Ensure this path is correct -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <style>
        :root {
            --background-light: #f8f9fa;
            --color-light: #343a40;
            --primary-color-light: #007bff;
            --background-dark: #343a40;
            --color-dark: #f8f9fa;
            --primary-color-dark: #17a2b8;
        }

        body {
            background-color: var(--background-light);
            color: var(--color-light);
            font-family: Arial, sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        .dark-mode {
            background-color: var(--background-dark);
            color: var(--color-dark);
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #fff;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .dark-mode .card {
            background-color: #495057;
            border-color: #6c757d;
        }

        .card-header {
            background-color: var(--primary-color-light);
            color: white;
            padding: 12px;
            font-size: 1.25rem;
        }

        .dark-mode .card-header {
            background-color: var(--primary-color-dark);
        }

        .card-body {
            padding: 15px;
        }

        .chart-container {
            height: 200px;
            width: 100%;
        }

        .chart-container canvas {
            max-width: 100%;
            height: auto !important;
        }

        .toggle-container {
            margin: 10px 0;
        }

        .toggle-switch {
            display: inline-block;
            width: 60px;
            height: 30px;
            position: relative;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 15px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            border-radius: 50%;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: var(--primary-color-dark);
        }

        input:checked + .slider:before {
            transform: translateX(30px);
        }

        footer {
            margin-top: 20px;
            background-color: var(--background-light);
            color: var(--color-light);
            padding: 10px;
            text-align: center;
        }

        body.dark-mode footer {
            background-color: #1f1f1f;
            color: var(--color-dark);
        }
    </style>
</head>
<body>

<?php include('includes/header.php'); ?>

<div class="container-fluid">
    <h1 class="mt-4"></h1>

    <!-- Dark Mode Toggle -->
    <div class="toggle-container">
        <label class="toggle-switch">
            <input type="checkbox" id="modeToggle">
            <span class="slider"></span>
        </label>
        <span>Dark Mode</span>
    </div>

    <?php alertMessage(); ?>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header">Total Categories</div>
                <div class="card-body chart-container">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header">Total Products</div>
                <div class="card-body chart-container">
                    <canvas id="productChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header">Total Customers</div>
                <div class="card-body chart-container">
                    <canvas id="customerChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header">Monthly Sales Report</div>
                <div class="card-body chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header">Today's Orders</div>
                <div class="card-body chart-container">
                    <canvas id="todayOrdersChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header">Total Orders</div>
                <div class="card-body chart-container">
                    <canvas id="totalOrdersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="categoryCount" value="<?= getCount('categories'); ?>">
<input type="hidden" id="productCount" value="<?= getCount('products'); ?>">
<input type="hidden" id="customerCount" value="<?= getCount('customers'); ?>">
<input type="hidden" id="salesAmount" value="<?php
    $totalSales = mysqli_query($conn, "SELECT SUM(total_amount) AS total_sales FROM orders");
    echo $totalSales ? mysqli_fetch_assoc($totalSales)['total_sales'] : 0.00;
?>">
<input type="hidden" id="todayOrders" value="<?php
    $todayDate = date('Y-m-d');
    $todayOrders = mysqli_query($conn, "SELECT * FROM orders WHERE order_date='$todayDate'");
    echo $todayOrders ? mysqli_num_rows($todayOrders) : 0;
?>">
<input type="hidden" id="totalOrders" value="<?= getCount('orders'); ?>">

<?php include('includes/footer.php'); ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const categoryCount = document.getElementById("categoryCount").value;
        const productCount = document.getElementById("productCount").value;
        const customerCount = document.getElementById("customerCount").value;
        const salesAmount = document.getElementById("salesAmount").value;
        const todayOrders = document.getElementById("todayOrders").value;
        const totalOrders = document.getElementById("totalOrders").value;

        const commonOptions = {
            type: 'bar',
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        };

        const createChart = (context, label, data, bgColor, brColor) => {
            new Chart(context, {
                ...commonOptions,
                data: {
                    labels: [label],
                    datasets: [{
                        data: [data],
                        backgroundColor: bgColor,
                        borderColor: brColor,
                        borderWidth: 1
                    }]
                }
            });
        };

        createChart(document.getElementById("categoryChart"), "Categories", categoryCount, 'rgba(153, 102, 255, 0.2)', 'rgba(153, 102, 255, 1)');
        createChart(document.getElementById("productChart"), "Products", productCount, 'rgba(54, 162, 235, 0.2)', 'rgba(54, 162, 235, 1)');
        createChart(document.getElementById("customerChart"), "Customers", customerCount, 'rgba(255, 206, 86, 0.2)', 'rgba(255, 206, 86, 1)');
        createChart(document.getElementById("salesChart"), "Sales (Total)", salesAmount, 'rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)');
        createChart(document.getElementById("todayOrdersChart"), "Today's Orders", todayOrders, 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 1)');
        createChart(document.getElementById("totalOrdersChart"), "Total Orders", totalOrders, 'rgba(231, 233, 237, 0.2)', 'rgba(231, 233, 237, 1)');

        // Dark mode toggle functionality
        const modeToggle = document.getElementById("modeToggle");
        const body = document.body;
        modeToggle.addEventListener("change", () => {
            body.classList.toggle("dark-mode");
        });
    });
</script>
</body>
</html>
