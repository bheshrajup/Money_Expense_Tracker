<?php 
    include_once '../init.php'; 

    // User login check
    if ($getFromU->loggedIn() === false) {
        header('Location: ../index.php');
    }

    include_once 'skeleton.php';

    // Check if dtfrom and dtto are set in POST
    $dtfrom = isset($_POST['dtfrom']) ? $_POST['dtfrom'] : '';
    $dtto = isset($_POST['dtto']) ? $_POST['dtto'] : '';
?>
<style>
    .card-header {
        display: flex;
        justify-content: space-between; /* Align items horizontally with space between them */
        align-items: center; /* Align items vertically */
    }

    .generate-btn {
        background-color: green;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        margin-top: 10px; /* Add margin to separate from table */
        display: block; /* Ensure it behaves like a block element */
        float: right; /* Float right to align to the right side */
    }

    .generate-btn:hover {
        background-color: darkgreen;
    }
</style>


<div class="wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 style="font-family:'Source Sans Pro'; font-size: 1.3em; text-align: center">Expenses incurred between <?php echo date("d-m-Y",strtotime($dtfrom)) ?> and <?php echo date("d-m-Y",strtotime($dtto)) ?></h4>
                </div>
                <div class="card-content">
                    <table>
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Description</th>
                                <th>Cost</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="chart-facilitate">
                            <?php
                                $dtexp = $getFromE->dtwise($_SESSION['UserId'], $dtfrom, $dtto);
                                if($dtexp !== NULL) {
                                    $len = count($dtexp);
                                    for ($x = 1; $x <= $len; $x++) {
                                        echo "<tr>
                                                <td>".$x."</td>
                                                <td>".$dtexp[$x-1]->Item."</td>
                                                <td>"."Rs. ".$dtexp[$x-1]->Cost."</td>
                                                <td>".date("d-m-Y",strtotime($dtexp[$x-1]->Date))."</td>
                                            </tr>";	
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                    <button onclick="generateReport()" class="generate-btn">Generate Report</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function generateReport() {
        // Open the chart page in a new tab
        var url = 'generate_datewise_chart.php?dtfrom=<?php echo urlencode($dtfrom); ?>&dtto=<?php echo urlencode($dtto); ?>';
        window.open(url, '_blank');
    }
</script>
<script src="../static/js/7-Datewise-Detailed.js"></script>
