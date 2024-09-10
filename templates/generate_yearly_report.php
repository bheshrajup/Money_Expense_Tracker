<?php
// Include necessary files and start session
include_once "../init.php";

// Ensure user is logged in
if ($getFromU->loggedIn() === false) {
    header('Location: ../index.php');
    exit(); // Always exit after header redirect
}

// Retrieve yrfrom and yrto from query string
if (isset($_GET['yrfrom']) && isset($_GET['yrto'])) {
    $yrfrom = $_GET['yrfrom'];
    $yrto = $_GET['yrto'];

    // Fetch yearly expenses data based on user ID, yrfrom, and yrto
    $yrexp = $getFromE->yrwise($_SESSION['UserId'], $yrfrom, $yrto);

    // Prepare data for Chart.js
    $labels = [];
    $costs = [];
    foreach ($yrexp as $expense) {
        $labels[] = $expense->Item;
        $costs[] = $expense->Cost;
    }
    $labels = json_encode($labels);
    $costs = json_encode($costs);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yearly Expense Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%; /* Make the container full width */
            max-width: 1200px; /* Limit maximum width for readability */
            margin: 0 auto; /* Center the container horizontally */
            padding: 20px; /* Add padding for spacing */
            box-sizing: border-box; /* Ensure padding doesn't affect total width */
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js library -->
</head>

<body>
    <div class="container">
        <h2 style="text-align: center;">Yearly Expense Report</h2>
        <canvas id="myChart"></canvas> <!-- Chart.js canvas -->
    </div>

    <script>
        // JavaScript code to render a line chart using Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo $labels; ?>,
                datasets: [{
                    label: 'Cost (Rs)',
                    data: <?php echo $costs; ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
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

<?php
} else {
    // Handle case when yrfrom and yrto are not set
    echo "Error: Invalid parameters.";
}
?>
