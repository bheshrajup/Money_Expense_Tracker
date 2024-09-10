<?php
include_once '../init.php';

// User login check
if ($getFromU->loggedIn() === false) {
    header('Location: ../index.php');
    exit();
}

// Check if dtfrom and dtto are set in URL parameters
if (!isset($_GET['dtfrom']) || !isset($_GET['dtto'])) {
    die('Date range not provided'); // Handle error: Date range not provided
}

// Retrieve and sanitize date range from URL
$dtfrom = $_GET['dtfrom'];
$dtto = $_GET['dtto'];

// Fetch data for chart based on date range using dtwise method from Expense class
$expensesData = $getFromE->dtwise($_SESSION['UserId'], $dtfrom, $dtto);

// Prepare data for Chart.js
$labels = [];
$data = [];

foreach ($expensesData as $expense) {
    $labels[] = date("d-m-Y", strtotime($expense->Date));
    $data[] = $expense->Cost;
}

// JSON encode data for JavaScript consumption
$data_json = json_encode([
    'labels' => $labels,
    'data' => $data
]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Expenses Chart</title>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 95%;
            max-width: 1100px; /* Adjust max-width to control chart size */
            padding: 10px; /* Adjust padding for content spacing */
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden; /* Ensure content doesn't overflow */
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden; /* Ensure content doesn't overflow */
        }
        .card-content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Expenses incurred between <?php echo date('d-m-Y', strtotime($dtfrom)); ?> and <?php echo date('d-m-Y', strtotime($dtto)); ?></h2>
        </div>
        
        <div class="card">
            <div class="card-content">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Retrieve data passed from PHP
        var chartData = <?php echo $data_json; ?>;

        // Chart.js code to generate chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Daily Expenses',
                    data: chartData.data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'green',
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
    </script>
</body>
</html>
