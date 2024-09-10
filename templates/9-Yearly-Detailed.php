<?php 
    include_once "../init.php";

    // User login check
    if ($getFromU->loggedIn() === false) {
        header('Location: ../index.php');
        exit(); // Always exit after header redirect
    }
    
    include_once 'skeleton.php';   
    
    // Set month and year from POST data
    $yrfrom = isset($_SESSION['yrfrom']) ? $_SESSION['yrfrom'] : '';
    $yrto = isset($_SESSION['yrto']) ? $_SESSION['yrto'] : '';

    // Retrieve yearly expenses data
    $yrexp = $getFromE->yrwise($_SESSION['UserId'], $yrfrom, $yrto);
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
                        Expenses incurred between <?php echo date('F, Y', strtotime($yrfrom)); ?> and <?php echo date('F, Y', strtotime($yrto)); ?></h4>    
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
                        <tbody>
                            <?php 
                                if(!empty($yrexp)) {
                                    $len = count($yrexp);
                                    for ($x = 1; $x <= $len; $x++) {
                                        echo "<tr>
                                            <td>".$x."</td>
                                            <td>".$yrexp[$x-1]->Item."</td>
                                            <td>"."Rs. ".$yrexp[$x-1]->Cost."</td>
                                            <td>".date("d-m-Y", strtotime($yrexp[$x-1]->Date))."</td>
                                        </tr>";    
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No expenses found for the selected period.</td></tr>";
                                }
                            ?>                  
                        </tbody>
                    </table>
					<br>
					<form action="generate_yearly_report.php" method="get" target="_blank">
                <input type="hidden" name="yrfrom" value="<?php echo $yrfrom; ?>">
                <input type="hidden" name="yrto" value="<?php echo $yrto; ?>">
                <button type="submit" class="generate-btn">Generate Report</button>
            </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-success {
        background-color: #28a745;
        color: #fff;
        border-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>

<script src="../static/js/yearly_detailed.js"></script>
