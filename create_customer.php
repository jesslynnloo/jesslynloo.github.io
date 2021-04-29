<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$query_last_id = "SELECT customer_id from customer ORDER BY customer_id DESC LIMIT 1";
$id_array = mysqli_query($conn, $query_last_id);
$result1 = mysqli_fetch_assoc($id_array);
$id_to_create = $result1['customer_id']+1;

$store_id = '';
$first_name = '';
$last_name ='';
$address_id = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'store_id'=>'', 'first_name'=>'', 'last_name'=>'', 'address_id'=>'');

if(isset($_POST['submit'])){

    if(empty($_POST['store_id'])){
        $errors['store_id'] = 'Store Id is required. <br />';
    }
    else{
        $store_id = $_POST['store_id'];
    }

    if(empty($_POST['first_name'])){
        $errors['first_name'] = 'First name is required. <br />';
    }
    else{
        $first_name = $_POST['first_name'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $first_name)){
            $errors['first_name'] = 'First name must be letters and/or spaces only.';
        }
    }

    if(empty($_POST['last_name'])){
        $errors['last_name'] = 'Last name is required. <br />';
    }
    else{
        $last_name = $_POST['last_name'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $last_name)){
            $errors['last_name'] = 'Last name must be letters and/or spaces only.';
        }

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
        $sql = "INSERT INTO customer (customer_id, store_id, first_name, last_name, address_id, last_update) VALUES ('$id_to_create', '$store_id', '$first_name', '$last_name', '$address_id', '$last_update')";

        if(mysqli_query($conn, $sql)){
            header('Location: customer.php');
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

    <form action="create_customer.php" class="white" method="POST">
		<label>Customer Id</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_create) ?>" readonly>
        <div class="red-text"><?php echo $errors['id']; ?></div>

		<label>Store Id</label>
		<input type="text" name="store_id" value="<?php echo htmlspecialchars($store_id) ?>">
        <div class="red-text"><?php echo $errors['store_id']; ?></div>

        <label>First Name</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name) ?>">
        <div class="red-text"><?php echo $errors['first_name']; ?></div>

        <label>Last Name</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name) ?>">
        <div class="red-text"><?php echo $errors['last_name']; ?></div>

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