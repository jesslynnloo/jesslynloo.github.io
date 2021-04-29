<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$query_last_id = "SELECT inventory_id from inventory ORDER BY inventory_id DESC LIMIT 1";
$id_array = mysqli_query($conn, $query_last_id);
$result1 = mysqli_fetch_assoc($id_array);
$id_to_create = $result1['inventory_id']+1;

$film_id = '';
$store_id = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'film_id'=>'', 'store_id'=>'');

if(isset($_POST['submit'])){

    if(empty($_POST['film_id'])){
        $errors['film_id'] = 'Film Id is required. <br />';
    }
    else{
        $film_id = $_POST['film_id'];
    }

    if(empty($_POST['store_id'])){
        $errors['store_id'] = 'Store Id is required. <br />';
    }
    else{
        $store_id = $_POST['store_id'];
    }

    if(array_filter($errors)){
        //
    }
    
    else{
        $sql = "INSERT INTO inventory (inventory_id, film_id, store_id, last_update) VALUES ('$id_to_create', '$film_id', '$store_id', '$last_update')";

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

    <form action="create_inventory.php" class="white" method="POST">
		<label>Inventory Id</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_create) ?>" readonly>
        <div class="red-text"><?php echo $errors['id']; ?></div>

		<label>Film Id</label>
		<input type="text" name="film_id" value="<?php echo htmlspecialchars($film_id) ?>">
        <div class="red-text"><?php echo $errors['film_id']; ?></div>

        <label>Store Id</label>
		<input type="text" name="store_id" value="<?php echo htmlspecialchars($store_id) ?>">
        <div class="red-text"><?php echo $errors['store_id']; ?></div>
        
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