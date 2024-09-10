<?php
// Include necessary files and start session
include_once "../init.php";

// Ensure user is logged in
if ($getFromU->loggedIn() === false) {
    header('Location: ../index.php');
    exit();
}

// Retrieve mthfrom and mthto from query string
if (isset($_GET['mthfrom']) && isset($_GET['mthto'])) {
    $mthfrom = $_GET['mthfrom'] . "-01";
    $mthto = $_GET['mthto'] . "-01";

    $mthexp = $getFromE->mthwise($_SESSION['UserId'], $mthfrom, $mthto);

    // Here you would typically generate your chart based on $mthexp data
    // Example: Assume using a JavaScript chart library like Chart.js
?>

<div class="wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 style="font-family:'Source Sans Pro'; font-size: 1.3em; text-align: center">
                        Chart of Expenses between <?php echo date('F, Y', strtotime($_GET['mthfrom'])); ?>
                        and <?php echo date('F, Y', strtotime($_GET['mthto'])); ?></h4>
                </div>
                <div class="card-content" style="height: 400px;"> <!-- Adjust height as needed -->
                    <!-- Add your chart rendering code here -->
                    <canvas id="myChart" style="max-height: 100%; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <button id="change-graph">mode</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Example Chart.js code to render a line chart
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line', 
        data: {
            labels: [
                <?php foreach ($mthexp as $expense) {
                    echo "'" . $expense->Item . "',";
                } ?>
            ],
            datasets: [{
                label: 'Cost (Rs)',
                data: [
                    <?php foreach ($mthexp as $expense) {
                        echo $expense->Cost . ",";
                    } ?>
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'green',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php
} else {
    // Handle case when mthfrom and mthto are not set
    echo "Error: Invalid parameters.";
}
?>
