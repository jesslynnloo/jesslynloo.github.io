<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$query_last_id = "SELECT rental_id from rental ORDER BY rental_id DESC LIMIT 1";
$id_array = mysqli_query($conn, $query_last_id);
$result1 = mysqli_fetch_assoc($id_array);
$id_to_create = $result1['rental_id']+1;

$rental_date = '';
$inventory_id = '';
$customer_id ='';
$return_date = '';
$staff_id = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'rental_date'=>'', 'inventory_id'=>'', 'customer_id'=>'', 'return_date'=>'', 'staff_id'=>'');

if(isset($_POST['submit'])){

    if(empty($_POST['rental_date'])){
        $errors['rental_date'] = 'Rental date is required. <br />';
    }
    else{
        $rental_date = $_POST['rental_date'];
    }

    if(empty($_POST['inventory_id'])){
        $errors['inventory_id'] = 'Inventory Id is required. <br />';
    }
    else{
        $inventory_id = $_POST['inventory_id'];
    }

    if(empty($_POST['customer_id'])){
        $errors['customer_id'] = 'Customer Id is required. <br />';
    }
    else{
        $customer_id = $_POST['customer_id'];
    }

    if(empty($_POST['return_date'])){
        $errors['return_date'] = 'Return date is required. <br />';
    }
    else{
        $return_date = $_POST['return_date'];
    }

    if(empty($_POST['staff_id'])){
        $errors['staff_id'] = 'Staff Id is required. <br />';
    }
    else{
        $staff_id = $_POST['staff_id'];
    }

    if(array_filter($errors)){
        //
    }
    
    else{
        $sql = "INSERT INTO rental (rental_id, rental_date, inventory_id, customer_id, return_date, staff_id, last_update) VALUES ('$id_to_create', '$rental_date', '$inventory_id', '$customer_id', '$return_date', '$staff_id', '$last_update')";

        if(mysqli_query($conn, $sql)){
            header('Location: rental.php');
        }
        else{
            echo 'query error: ' . mysqli_error($conn);
        }
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html>

<body>

    <form action="create_rental.php" class="white" method="POST">
		<label>Rental Id</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_create) ?>" readonly>
        <div class="red-text"><?php echo $errors['id']; ?></div>

		<label for="rental_date">Rental Date</label>
		<input type="datetime-local" id="rental_date" name="rental_date" value="<?php echo htmlspecialchars($rental_date) ?>">
        <div class="red-text"><?php echo $errors['rental_date']; ?></div>

        <label>Inventory Id</label>
        <input type="text" name="inventory_id" value="<?php echo htmlspecialchars($inventory_id) ?>">
        <div class="red-text"><?php echo $errors['inventory_id']; ?></div>

        <label>Customer Id</label>
        <input type="text" name="customer_id" value="<?php echo htmlspecialchars($customer_id) ?>">
        <div class="red-text"><?php echo $errors['customer_id']; ?></div>

        <label for="return_date">Return Date</label>
        <input type="datetime-local" id="return_date" name="return_date" value="<?php echo htmlspecialchars($return_date) ?>">
        <div class="red-text"><?php echo $errors['return_date']; ?></div>

        <label>Staff Id</label>
        <input type="text" name="staff_id" value="<?php echo htmlspecialchars($staff_id) ?>">
        <div class="red-text"><?php echo $errors['staff_id']; ?></div>

        <div class="center">
            <input type="submit" name="submit" value="Next" class="btn brand z-depth-0">
        </div>
    </form>

    <form action="create.php" method="POST">
        <input type="hidden" name="id" value="">
        <input type="submit" name="back" value="Back to previous page" class=" right btn brand z-depth-0">

    </form>

</body>

</html>