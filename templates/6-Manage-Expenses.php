<?php 
	include_once "../init.php";

	// User login checker
	if ($getFromU->loggedIn() === false) {
        header('Location: ../index.php');
        exit();
	}

	include_once 'skeleton.php'; 

	// Deletes expense record
	if(isset($_POST['delrec']))
	{
		$getFromE->delexp($_POST['ID']);
		echo "<script>
				Swal.fire({
					title: 'Done!',
					text: 'Record deleted successfully',
					icon: 'success',
					confirmButtonText: 'Close'
				})
				</script>";
	}

    // Handle editing
    if(isset($_POST['editrec'])) {
        $expense_id = $_POST['ID'];
        
        // Redirect to edit expense page with the expense ID
        header("Location: edit_expense.php WHERE id=$expense_id");
        exit(); // Make sure to exit after redirection
    }
	
?>

<div class="wrapper">
        <div class="row">
           <div class="col-12">
               <div class="card">
                   <div class="card-header">
                        
                        <i class="fas fa-ellipsis-h"></i>
                        <h3 style="font-family:'Source Sans Pro'; font-size: 1.5em;">
                            Expenses
                        </h3>
                   </div>
                   <div class="card-content">
                   <table>
							<thead>
								<tr>
									<th>S.N</th>
									<th>Description</th>
									<th>Cost</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
										$totexp = $getFromE->allexp($_SESSION['UserId']);
										if($totexp !== NULL)
										{
											$len = count($totexp);
											for ($x = 1; $x <= $len; $x++) {
											echo "<tr>
												<td>".$x."</td>
												<td>".$totexp[$x-1]->Item."</td>
												<td>"."Rs. ".$totexp[$x-1]->Cost."</td>
												<td>".date("d-m-Y",strtotime($totexp[$x-1]->Date))."</td>	
												<td>
												<form style='display: inline;' action='edit_expense.php' method='GET'>
                                                        <input type='hidden' name='ID' value='".$totexp[$x-1]->ID."'></input>
                                                        <button type='submit' name='editrec' class='btn btn-default' style='background:none; color:#8f8f8f; font-size:1em;'>
                                                            <i class='far fa-edit' style='color:green;'></i>
                                                        </button>
                                                    </form>
                                                    <form style='display: inline;' action='' method='post'>
                                                        <input type='hidden' name='ID' value='".$totexp[$x-1]->ID."'></input>
                                                        <button type='submit' name='delrec' class='btn btn-default' style='background:none; color:#8f8f8f; font-size:1em;'>
                                                            <i class='far fa-trash-alt' style='color:red;'></i>
                                                        </button>
                                                    </form>
                                                    
                                                </td>
											</tr>";	
											}
										}
									?>
							</tbody>
						</table>
                   </div>
               </div>
           </div>
        </div>
</div>
