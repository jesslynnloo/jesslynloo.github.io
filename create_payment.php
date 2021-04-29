<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$query_last_id = "SELECT payment_id from payment ORDER BY payment_id DESC LIMIT 1";
$id_array = mysqli_query($conn, $query_last_id);
$result1 = mysqli_fetch_assoc($id_array);
$id_to_create = $result1['payment_id']+1;

$customer_id = '';
$staff_id = '';
$rental_id ='';
$amount = '';
$payment_date = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'customer_id'=>'', 'staff_id'=>'', 'rental_id'=>'', 'amount'=>'', 'payment_date'=>'');

if(isset($_POST['submit'])){

    if(empty($_POST['customer_id'])){
        $errors['customer_id'] = 'Customer Id is required. <br />';
    }
    else{
        $customer_id = $_POST['customer_id'];
    }

    if(empty($_POST['staff_id'])){
        $errors['staff_id'] = 'Staff Id is required. <br />';
    }
    else{
        $staff_id = $_POST['staff_id'];
    }

    if(empty($_POST['rental_id'])){
        $errors['rental_id'] = 'Rental Id is required. <br />';
    }
    else{
        $rental_id = $_POST['rental_id'];
    }

    if(empty($_POST['amount'])){
        $errors['amount'] = 'Amount is required. <br />';
    }
    else{
        $amount = $_POST['amount'];
    }

    if(empty($_POST['payment_date'])){
        $errors['payment_date'] = 'Payment date is required. <br />';
    }
    else{
        $payment_date = $_POST['payment_date'];
    }

    if(array_filter($errors)){
        //
    }
    
    else{
        $sql = "INSERT INTO payment (payment_id, customer_id, staff_id, rental_id, amount, payment_date, last_update) VALUES ('$id_to_create', '$customer_id', '$staff_id', '$rental_id', '$amount', '$payment_date', '$last_update')";

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

    <form action="create_payment.php" class="white" method="POST">
		<label>Payment Id</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_create) ?>" readonly>
        <div class="red-text"><?php echo $errors['id']; ?></div>

		<label>Customer Id</label>
		<input type="text" name="customer_id" value="<?php echo htmlspecialchars($customer_id) ?>">
        <div class="red-text"><?php echo $errors['customer_id']; ?></div>

        <label>Staff Id</label>
        <input type="text" name="staff_id" value="<?php echo htmlspecialchars($staff_id) ?>">
        <div class="red-text"><?php echo $errors['staff_id']; ?></div>

        <label>Rental Id</label>
        <input type="text" name="rental_id" value="<?php echo htmlspecialchars($rental_id) ?>">
        <div class="red-text"><?php echo $errors['rental_id']; ?></div>

        <label>Amount</label>
        <input type="text" name="amount" value="<?php echo htmlspecialchars($amount) ?>">
        <div class="red-text"><?php echo $errors['amount']; ?></div>

        <label for="payment_date">Payment Date</label>
        <input type="datetime-local" id="payment_date" name="payment_date" value="<?php echo htmlspecialchars($payment_date) ?>">
        <div class="red-text"><?php echo $errors['payment_date']; ?></div>
        
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