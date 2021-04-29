<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$id_to_update = '';
$manager_staff_id = '';
$address_id = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'manager_staff_id'=>'', 'address_id'=>'');

if(isset($_POST['submit'])){

    $id_to_update = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'ID is required. <br />';
    }
    else{
        $sql_check_id = "SELECT store_id FROM store WHERE store_id = $id_to_update";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if(mysqli_num_rows($result_check_id) == 0){
            $errors['id'] = 'ID is not found in the table. <br />';        
        }
    }

    if(empty($_POST['manager_staff_id']) and empty($_POST['address_id'])){
        $errors['manager_staff_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['address_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
    }
    else{
        if (!empty($_POST['manager_staff_id'])){
            $manager_staff_id = $_POST['manager_staff_id'];
        }

        else{
            $query = "SELECT manager_staff_id from store WHERE store_id = '$id_to_update'";
            $manager_staff_id_array = mysqli_query($conn, $query);
            $result1 = mysqli_fetch_assoc($manager_staff_id_array);
            $manager_staff_id = $result1['manager_staff_id'];
        }

        if (!empty($_POST['address_id'])){
            $address_id = $_POST['address_id'];
        }

        else{
            $query = "SELECT address_id from store WHERE store_id = '$id_to_update'";
            $address_id_array = mysqli_query($conn, $query);
            $result2 = mysqli_fetch_assoc($address_id_array);
            $address_id = $result2['address_id'];
        }
    }

    if(array_filter($errors)){
        //
    }
    
    else{

        $sql = "UPDATE store SET manager_staff_id = '$manager_staff_id', address_id = '$address_id', last_update = '$last_update' WHERE store_id = '$id_to_update'";

        if(mysqli_query($conn, $sql)){
            header('Location: store.php');
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
        <label>Store Id that you wish to update: </label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_update) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label>Manager_staff Id: </label>
		<input type="text" name="manager_staff_id" value="<?php echo htmlspecialchars($manager_staff_id) ?>">
        <div class="red-text"><?php echo $errors['manager_staff_id']; ?></div>

        <label>Address Id: </label>
		<input type="text" name="address_id" value="<?php echo htmlspecialchars($address_id) ?>">
        <div class="red-text"><?php echo $errors['address_id']; ?></div>

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