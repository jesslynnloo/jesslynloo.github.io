<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$id_to_update = '';
$customer_id = '';
$email = '';
$active ='';
$create_date = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'customer_id'=>'', 'email'=>'', 'active'=>'', 'create_date'=>'');

if(isset($_POST['submit'])){

    $id_to_update = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'ID is required. <br />';
    }
    else{
        $sql_check_id = "SELECT email_id FROM customer_email WHERE email_id = $id_to_update";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if(mysqli_num_rows($result_check_id) == 0){
            $errors['id'] = 'ID is not found in the table. <br />';        
        }
    }

    if(empty($_POST['customer_id']) and empty($_POST['email']) and empty($_POST['active']) and empty($_POST['create_date'])){
        $errors['customer_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['email'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['active'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['create_date'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
    }
    else{
        if (!empty($_POST['customer_id'])){
            $customer_id = $_POST['customer_id'];
        }

        else{
            $query = "SELECT customer_id from customer_email WHERE email_id = '$id_to_update'";
            $customer_id_array = mysqli_query($conn, $query);
            $result1 = mysqli_fetch_assoc($customer_id_array);
            $customer_id = $result1['customer_id'];
        }

        if (!empty($_POST['email'])){
            $email = $_POST['email'];
        }

        else{
            $query = "SELECT email from customer_email WHERE email_id = '$id_to_update'";
            $email_array = mysqli_query($conn, $query);
            $result2 = mysqli_fetch_assoc($email_array);
            $email = $result2['email'];
        }

        if (!empty($_POST['active'])){
            $active = $_POST['active'];
        }

        else{
            $query = "SELECT active from customer_email WHERE email_id = '$id_to_update'";
            $active_array = mysqli_query($conn, $query);
            $result3 = mysqli_fetch_assoc($active_array);
            $active = $result3['active'];
        }

        if (!empty($_POST['create_date'])){
            $create_date = $_POST['create_date'];
        }

        else{
            $query = "SELECT create_date from customer_email WHERE email_id = '$id_to_update'";
            $create_date_array = mysqli_query($conn, $query);
            $result4 = mysqli_fetch_assoc($create_date_array);
            $create_date = $result4['create_date'];
        }
    }

    if(array_filter($errors)){
        //
    }
    
    else{

        $sql = "UPDATE customer_email SET customer_id = '$customer_id', email = '$email', active = '$active', create_date = '$create_date', last_update = '$last_update' WHERE email_id = '$id_to_update'";

        if(mysqli_query($conn, $sql)){
            header('Location: customer_email.php');
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
        <label>Email Id that you wish to update: </label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_update) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label>Customer Id: </label>
		<input type="text" name="customer_id" value="<?php echo htmlspecialchars($customer_id) ?>">
        <div class="red-text"><?php echo $errors['customer_id']; ?></div>

        <label>Email: </label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <div class="red-text"><?php echo $errors['email']; ?></div>

        <label>Active: </label>
        <input type="text" name="active" value="<?php echo htmlspecialchars($active) ?>">
        <div class="red-text"><?php echo $errors['active']; ?></div>

        <label for="create_date">Create Date: </label>
        <input type="datetime-local" id="create_date" name="create_date" value="<?php echo htmlspecialchars($create_date) ?>">
        <div class="red-text"><?php echo $errors['create_date']; ?></div>

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