<?php
include_once "../init.php";

// User login checker - Redirect if not logged in
if ($getFromU->loggedIn() === false) {
    header('Location: ../index.php');
    exit();
}

// Check if ID is provided in the URL
if (!isset($_GET['ID'])) {
    header('Location: 6-Manage-Expenses.php');
    exit();
}

$expense_id = $_GET['ID'];
$expense = $getFromE->getExpenseById($expense_id);

// Check if expense exists
if (!$expense) {
    header('Location: 6-Manage-Expenses.php');
    exit();
}

// Initialize variables for form fields
$item = $expense->Item;
$cost = $expense->Cost;
$date = date("Y-m-d", strtotime($expense->Date));

// Handle form submission to update expense
if (isset($_POST['update_expense'])) {
    $new_item = $_POST['item'];
    $new_cost = $_POST['cost'];
    $new_date = $_POST['date'];

    // Perform validation if needed

    // Update the expense record
    $result = $getFromE->updateExpense($expense_id, $new_item, $new_cost, $new_date);

    if ($result) {
        // SweetAlert to display success message
        echo "<script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Done!',
                        text: 'Record updated successfully',
                        icon: 'success',
                        confirmButtonText: 'Close'
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.href = '6-Manage-Expenses.php';
                        }
                    });
                };
              </script>";
    } else {
        // Handle update failure
        $error_message = "Failed to update expense.";
    }
}
include_once 'skeleton.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense</title>
    <style>
        /* Add your custom styles here */
        .edit-expense-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 20px; /* Add padding to bottom of form */
        }
        .edit-expense-form h2 {
            font-family: 'Source Sans Pro', sans-serif;
        }
        .edit-expense-form label {
            font-weight: bold;
            font-family: 'Source Sans Pro', sans-serif;
            display: inline-block;
            width: 100px; /* Adjust as needed for label width */
            margin-bottom: 5px;
        }
        .edit-expense-form input[type="text"],
        .edit-expense-form input[type="date"] {
            border-radius: 5px;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            font-weight: 500; /* Lighter font weight */
            width: 200px; /* Adjust as needed */
        }
        .edit-expense-form button[type="submit"] {
            background-color: green;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px; /* Adjust margin to move the button down */
        }
        .edit-expense-form button[type="submit"]:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="row">
            <div class="col-12 col-m-12 col-sm-12">
                <div class="card">
                    <div class="counter" style="display: flex; align-items: center; justify-content: center;">
                        <form method="post" class="edit-expense-form">
                            <h2>Edit Expense</h2>
                            <?php if (isset($error_message)): ?>
                                <p><?php echo $error_message; ?></p>
                            <?php endif; ?>
                            <input type="hidden" name="ID" value="<?php echo $expense_id; ?>">
                            <div>
                                <label for="item">Item:</label>
                                <input type="text" id="item" name="item" value="<?php echo htmlspecialchars($item); ?>" required>
                            </div>
                            <div>
                                <label for="cost">Cost:</label>
                                <input type="text" id="cost" name="cost" value="<?php echo htmlspecialchars($cost); ?>" required>
                            </div>
                            <div>
                                <label for="date">Date:</label>
                                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>" required>
                            </div>
                            <button type="submit" name="update_expense">Update Expense</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>
</html>
