<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$id_to_update = '';
$rental_date = '';
$inventory_id = '';
$customer_id ='';
$return_date = '';
$staff_id = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'rental_date'=>'', 'inventory_id'=>'', 'customer_id'=>'', 'return_date'=>'', 'staff_id'=>'');

if(isset($_POST['submit'])){

    $id_to_update = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'ID is required. <br />';
    }
    else{
        $sql_check_id = "SELECT rental_id FROM rental WHERE rental_id = $id_to_update";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if(mysqli_num_rows($result_check_id) == 0){
            $errors['id'] = 'ID is not found in the table. <br />';        
        }
    }

    if(empty($_POST['rental_date']) and empty($_POST['inventory_id']) and empty($_POST['customer_id']) and empty($_POST['return_date']) and empty($_POST['staff_id'])){
        $errors['rental_date'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['inventory_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['customer_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['return_date'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['staff_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
    }
    else{
        if (!empty($_POST['rental_date'])){
            $rental_date = $_POST['rental_date'];
        }

        else{
            $query = "SELECT rental_date from rental WHERE rental_id = '$id_to_update'";
            $rental_date_array = mysqli_query($conn, $query);
            $result1 = mysqli_fetch_assoc($rental_date_array);
            $rental_date = $result1['rental_date'];
        }

        if (!empty($_POST['inventory_id'])){
            $inventory_id = $_POST['inventory_id'];
        }

        else{
            $query = "SELECT inventory_id from rental WHERE rental_id = '$id_to_update'";
            $inventory_id_array = mysqli_query($conn, $query);
            $result2 = mysqli_fetch_assoc($inventory_id_array);
            $inventory_id = $result2['inventory_id'];
        }

        if (!empty($_POST['customer_id'])){
            $customer_id = $_POST['customer_id'];
        }

        else{
            $query = "SELECT customer_id from rental WHERE rental_id = '$id_to_update'";
            $customer_id_array = mysqli_query($conn, $query);
            $result3 = mysqli_fetch_assoc($customer_id_array);
            $customer_id = $result3['customer_id'];
        }

        if (!empty($_POST['return_date'])){
            $return_date = $_POST['return_date'];
        }

        else{
            $query = "SELECT return_date from rental WHERE rental_id = '$id_to_update'";
            $return_date_array = mysqli_query($conn, $query);
            $result4 = mysqli_fetch_assoc($return_date_array);
            $return_date = $result4['return_date'];
        }

        if (!empty($_POST['staff_id'])){
            $staff_id = $_POST['staff_id'];
        }

        else{
            $query = "SELECT staff_id from rental WHERE rental_id = '$id_to_update'";
            $staff_id_array = mysqli_query($conn, $query);
            $result5 = mysqli_fetch_assoc($staff_id_array);
            $staff_id = $result5['staff_id'];
        }
    }

    if(array_filter($errors)){
        //
    }
    
    else{

        $sql = "UPDATE rental SET rental_date = '$rental_date', inventory_id = '$inventory_id', customer_id = '$customer_id', return_date = '$return_date', staff_id = '$staff_id', last_update = '$last_update' WHERE rental_id = '$id_to_update'";

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

    <form action="#" class="white" method="POST">
        <label>Rental Id that you wish to update: </label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_update) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label for="rental_date">Rental Date: </label>
		<input type="datetime-local" id="rental_date" name="rental_date" value="<?php echo htmlspecialchars($rental_date) ?>">
        <div class="red-text"><?php echo $errors['rental_date']; ?></div>

        <label>Inventory Id: </label>
        <input type="text" name="inventory_id" value="<?php echo htmlspecialchars($inventory_id) ?>">
        <div class="red-text"><?php echo $errors['inventory_id']; ?></div>

        <label>Customer Id: </label>
        <input type="text" name="customer_id" value="<?php echo htmlspecialchars($customer_id) ?>">
        <div class="red-text"><?php echo $errors['customer_id']; ?></div>

        <label for="return_date">Return Date: </label>
        <input type="datetime-local" id="return_date" name="return_date" value="<?php echo htmlspecialchars($return_date) ?>">
        <div class="red-text"><?php echo $errors['return_date']; ?></div>

        <label>Staff Id: </label>
        <input type="text" name="staff_id" value="<?php echo htmlspecialchars($staff_id) ?>">
        <div class="red-text"><?php echo $errors['staff_id']; ?></div>

        <div class="center">
            <input type="submit" name="submit" value="Next" class="btn brand z-depth-0">
        </div>
    </form>

    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="">
        <input type="submit" name="back" value="Back to previous page" class=" right btn brand z-depth-0">

    </form>

</body>

</html>