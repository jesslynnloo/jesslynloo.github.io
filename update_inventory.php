<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$id_to_update = '';
$film_id = '';
$store_id = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'film_id'=>'', 'store_id'=>'');

if(isset($_POST['submit'])){

    $id_to_update = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'ID is required. <br />';
    }
    else{
        $sql_check_id = "SELECT inventory_id FROM inventory WHERE inventory_id = $id_to_update";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if(mysqli_num_rows($result_check_id) == 0){
            $errors['id'] = 'ID is not found in the table. <br />';        
        }
    }

    if(empty($_POST['film_id']) and empty($_POST['store_id'])){
        $errors['film_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['store_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
    }
    else{
        if (!empty($_POST['film_id'])){
            $film_id = $_POST['film_id'];
        }

        else{
            $query = "SELECT film_id from inventory WHERE inventory_id = '$id_to_update'";
            $film_id_array = mysqli_query($conn, $query);
            $result1 = mysqli_fetch_assoc($film_id_array);
            $film_id = $result1['film_id'];
        }

        if (!empty($_POST['store_id'])){
            $store_id = $_POST['store_id'];
        }

        else{
            $query = "SELECT store_id from inventory WHERE inventory_id = '$id_to_update'";
            $store_id_array = mysqli_query($conn, $query);
            $result2 = mysqli_fetch_assoc($store_id_array);
            $store_id = $result2['store_id'];
        }
    }

    if(array_filter($errors)){
        //
    }
    
    else{

        $sql = "UPDATE inventory SET film_id = '$film_id', store_id = '$store_id', last_update = '$last_update' WHERE inventory_id = '$id_to_update'";

        if(mysqli_query($conn, $sql)){
            header('Location: inventory.php');
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
        <label>Inventory Id that you wish to update: </label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_update) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label>Film Id: </label>
		<input type="text" name="film_id" value="<?php echo htmlspecialchars($film_id) ?>">
        <div class="red-text"><?php echo $errors['film_id']; ?></div>

        <label>Store Id: </label>
		<input type="text" name="store_id" value="<?php echo htmlspecialchars($store_id) ?>">
        <div class="red-text"><?php echo $errors['store_id']; ?></div>

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