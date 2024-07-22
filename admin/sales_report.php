<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Sales Report</h4>
        </div>
        <div class="card-body">
            <!-- Canvas for Chart.js -->
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch sales data from PHP
        fetch('sales-data.php')
            .then(response => response.json())
            .then(data => {
                // Prepare data for Chart.js
                const ctx = document.getElementById('salesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line', // You can also use 'bar', 'pie', etc.
                    data: {
                        labels: data.labels, // Array of month names
                        datasets: [{
                            label: 'Monthly Sales Income',
                            data: data.values, // Array of total income values
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    });
</script>

<?php include('includes/footer.php'); ?>
