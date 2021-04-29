<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$id_to_update = '';
$customer_id = '';
$staff_id = '';
$rental_id ='';
$amount = '';
$payment_date = '';
$check_null = 0;
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'customer_id'=>'', 'staff_id'=>'', 'rental_id'=>'', 'amount'=>'', 'payment_date'=>'');

if(isset($_POST['submit'])){

    $id_to_update = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'ID is required. <br />';
    }
    else{
        $sql_check_id = "SELECT payment_id FROM payment WHERE payment_id = $id_to_update";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if(mysqli_num_rows($result_check_id) == 0){
            $errors['id'] = 'ID is not found in the table. <br />';        
        }
    }

    if(empty($_POST['customer_id']) and empty($_POST['staff_id']) and empty($_POST['rental_id']) and empty($_POST['amount']) and empty($_POST['payment_date'])){
        $errors['customer_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['staff_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['rental_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['amount'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['payment_date'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
    }
    else{
        if (!empty($_POST['customer_id'])){
            $customer_id = $_POST['customer_id'];
        }

        else{
            $query = "SELECT customer_id from payment WHERE payment_id = '$id_to_update'";
            $customer_id_array = mysqli_query($conn, $query);
            $result1 = mysqli_fetch_assoc($customer_id_array);
            $customer_id = $result1['customer_id'];
        }

        if (!empty($_POST['staff_id'])){
            $staff_id = $_POST['staff_id'];
        }

        else{
            $query = "SELECT staff_id from payment WHERE payment_id = '$id_to_update'";
            $staff_id_array = mysqli_query($conn, $query);
            $result2 = mysqli_fetch_assoc($staff_id_array);
            $staff_id = $result2['staff_id'];
        }
        
        
        $query_check_null_id = "SELECT payment_id FROM payment WHERE rental_id IS NULL";
        $null_id_array = mysqli_query($conn, $query_check_null_id);
        $result_null_id = mysqli_fetch_array($null_id_array);
        
        if(array_search($id_to_delete, $result_null_id, TRUE)){
            if(!empty($_POST['rental_id'])){
                $rental_id = $_POST['rental_id'];
            }
            else{
                $query = "SELECT rental_id from payment WHERE payment_id = '$id_to_update'";
                $rental_id_array = mysqli_query($conn, $query);
                $result3 = mysqli_fetch_assoc($rental_id_array);
                $rental_id = $result3['rental_id'];
            }
        }
        else{
            if(!empty($_POST['rental_id'])){
                $rental_id = $_POST['rental_id'];
            }
            else{
                $query = "SELECT rental_id from payment WHERE payment_id = '$id_to_update'";
                $rental_id_array = mysqli_query($conn, $query);
                $result3 = mysqli_fetch_assoc($rental_id_array);
                $rental_id = $result3['rental_id'];
            }
        }
        
        
        
        
        
        
        
        
        
        

        

        /*if (!empty($_POST['rental_id'])){
            $rental_id = $_POST['rental_id'];
        }
        
        elseif(empty($_POST) and ($result3['rental_id']) === NULL){
            $check_null = 1;
        }

        else{
            $rental_id = $result3['rental_id'];
        }*/

        if (!empty($_POST['amount'])){
            $amount = $_POST['amount'];
        }

        else{
            $query = "SELECT amount from payment WHERE payment_id = '$id_to_update'";
            $amount_array = mysqli_query($conn, $query);
            $result4 = mysqli_fetch_assoc($amount_array);
            $amount = $result4['amount'];
        }

        if (!empty($_POST['payment_date'])){
            $payment_date = $_POST['payment_date'];
        }

        else{
            $query = "SELECT payment_date from payment WHERE payment_id = '$id_to_update'";
            $payment_date_array = mysqli_query($conn, $query);
            $result5 = mysqli_fetch_assoc($payment_date_array);
            $payment_date = $result5['payment_date'];
        }
    }

    if(array_filter($errors)){
        //
    }
    
    /*elseif($check_null == 1){
        $sql = "UPDATE payment SET customer_id = '$customer_id', staff_id = '$staff_id', rental_id = NULL, amount = '$amount', payment_date = '$payment_date', last_update = '$last_update' WHERE payment_id = '$id_to_update'";

        if(mysqli_query($conn, $sql)){
            header('Location: payment.php');
        }
        else{
            echo 'query error: ' . mysqli_error($conn);
        }
    }*/
    
    else{

        $sql = "UPDATE payment SET customer_id = $customer_id, staff_id = $staff_id, rental_id = $rental_id, amount = $amount, payment_date = '$payment_date', last_update = '$last_update' WHERE payment_id = $id_to_update";

        if(mysqli_query($conn, $sql)){
            header('Location: payment.php');
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
        <label>Payment Id that you wish to update: </label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_update) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label>Customer Id: </label>
		<input type="text" name="customer_id" value="<?php echo htmlspecialchars($customer_id) ?>">
        <div class="red-text"><?php echo $errors['customer_id']; ?></div>

        <label>Staff Id: </label>
        <input type="text" name="staff_id" value="<?php echo htmlspecialchars($staff_id) ?>">
        <div class="red-text"><?php echo $errors['staff_id']; ?></div>

        <label>Rental Id: </label>
        <input type="text" name="rental_id" value="<?php echo htmlspecialchars($rental_id) ?>">
        <div class="red-text"><?php echo $errors['rental_id']; ?></div>

        <label>Amount: </label>
        <input type="text" name="amount" value="<?php echo htmlspecialchars($amount) ?>">
        <div class="red-text"><?php echo $errors['amount']; ?></div>

        <label for="payment_date">Payment Date: </label>
        <input type="datetime-local" id="payment_date" name="payment_date" value="<?php echo htmlspecialchars($payment_date) ?>">
        <div class="red-text"><?php echo $errors['payment_date']; ?></div>

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