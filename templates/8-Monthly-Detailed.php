<?php 
    include_once "../init.php";
    if ($getFromU->loggedIn() === false) {
        header('Location: ../index.php');
        exit(); // Always exit after header redirect
    }
    include_once 'skeleton.php'; 	
?>

	<style>
    button.generate-btn {
        background-color: green;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        float: right; /* Align the button to the right */
        margin-top: 10px;
        margin-left: 10px; /* Add margin between the table and button */
    }

    button.generate-btn:hover {
        background-color: darkgreen;
    }
</style>

<div class="wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 style="font-family:'Source Sans Pro'; font-size: 1.3em; text-align: center">
                        Expenses incurred between <?php echo date('F, Y', strtotime($_POST['mthfrom'])); ?> and <?php echo date('F, Y', strtotime($_POST['mthto'])); ?></h4>    
                </div>
                <div class="card-content">
                    <table>
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Description</th>
                                <th>Cost</th>
                                <th>Month</th>
                            </tr>
                        </thead>
                        <tbody id="chart-facilitate1">
                            <?php 
                                $_POST['mthto'] = $_POST['mthto']."-01";
                                $_POST['mthfrom'] = $_POST['mthfrom']."-01";

                                $mthexp = $getFromE->mthwise($_SESSION['UserId'],$_POST['mthfrom'],$_POST['mthto']);
                                if($mthexp !== NULL)
                                {
                                    $len = count($mthexp);
                                    for ($x = 1; $x <= $len; $x++) {
                                        echo "<tr>
                                            <td>".$x."</td>
                                            <td>".$mthexp[$x-1]->Item."</td>
                                            <td>"."Rs. ".$mthexp[$x-1]->Cost."</td>
                                            <td>".date("d-m-Y",strtotime($mthexp[$x-1]->Date))."</td>
                                        </tr>";    
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
					<form action="generate_month_report.php" method="get" target="_blank">
                <input type="hidden" name="mthfrom" value="<?php echo $_POST['mthfrom']; ?>">
                <input type="hidden" name="mthto" value="<?php echo $_POST['mthto']; ?>">
                <button type="submit" class="generate-btn">Generate Report</button>
            </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="../static/js/8-Monthly-Detailed.js"></script>
