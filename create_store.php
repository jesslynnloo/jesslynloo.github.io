<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$query_last_id = "SELECT store_id from store ORDER BY store_id DESC LIMIT 1";
$id_array = mysqli_query($conn, $query_last_id);
$result1 = mysqli_fetch_assoc($id_array);
$id_to_create = $result1['store_id']+1;

$manager_staff_id = '';
$address_id = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'manager_staff_id'=>'', 'address_id'=>'');

if(isset($_POST['submit'])){

    if(empty($_POST['manager_staff_id'])){
        $errors['manager_staff_id'] = 'Manager_staff Id is required. <br />';
    }
    else{
        $manager_staff_id = $_POST['manager_staff_id'];
    }

    if(empty($_POST['address_id'])){
        $errors['address_id'] = 'Address Id is required. <br />';
    }
    else{
        $address_id = $_POST['address_id'];
    }

    if(array_filter($errors)){
        //
    }
    
    else{
        $sql = "INSERT INTO store (store_id, manager_staff_id, address_id, last_update) VALUES ('$id_to_create', '$manager_staff_id', '$address_id', '$last_update')";

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

    <form action="create_store.php" class="white" method="POST">
		<label>Store Id</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_create) ?>" readonly>
        <div class="red-text"><?php echo $errors['id']; ?></div>

		<label>Manager_staff Id</label>
		<input type="text" name="manager_staff_id" value="<?php echo htmlspecialchars($manager_staff_id) ?>">
        <div class="red-text"><?php echo $errors['manager_staff_id']; ?></div>

        <label>Address Id</label>
		<input type="text" name="address_id" value="<?php echo htmlspecialchars($address_id) ?>">
        <div class="red-text"><?php echo $errors['address_id']; ?></div>

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