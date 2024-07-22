<?php
include 'includes/db.php'; // Ensure correct path

// Get current year
$currentYear = date('Y');

// SQL query to get total income per month for the current year
$sql = "
    SELECT 
        MONTH(date) AS month,
        SUM(amount) AS total_income
    FROM sales
    WHERE YEAR(date) = ?
    GROUP BY MONTH(date)
    ORDER BY MONTH(date)
";

// Prepare and execute statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $currentYear);
$stmt->execute();
$result = $stmt->get_result();

// Prepare data for JSON response
$labels = [];
$values = [];
while ($row = $result->fetch_assoc()) {
    $month = $row['month'];
    $total_income = $row['total_income'];
    $monthName = DateTime::createFromFormat('!m', $month)->format('F');
    $labels[] = $monthName;
    $values[] = $total_income;
}

// Close connection
$stmt->close();
$conn->close();

// Return data as JSON
echo json_encode(['labels' => $labels, 'values' => $values]);
?>
