<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$id_to_update = '';
$street_address = '';
$district = '';
$city_id ='';
$postal_code = '';
$phone = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'street_address'=>'', 'district'=>'', 'city_id'=>'', 'postal_code'=>'', 'phone'=>'');

if(isset($_POST['submit'])){

    $id_to_update = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'ID is required. <br />';
    }
    else{
        $sql_check_id = "SELECT address_id FROM address WHERE address_id = $id_to_update";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if(mysqli_num_rows($result_check_id) == 0){
            $errors['id'] = 'ID is not found in the table. <br />';        
        }
    }

    if(empty($_POST['street_address']) and empty($_POST['district']) and empty($_POST['city_id']) and empty($_POST['postal_code']) and empty($_POST['phone'])){
        $errors['street_address'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['district'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['city_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['postal_code'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['phone'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
    }
    else{
        if (!empty($_POST['street_address'])){
            $street_address = $_POST['street_address'];
        }

        else{
            $query = "SELECT street_address from address WHERE address_id = '$id_to_update'";
            $street_address_array = mysqli_query($conn, $query);
            $result1 = mysqli_fetch_assoc($street_address_array);
            $street_address = $result1['street_address'];
        }

        if (!empty($_POST['district'])){
            $district = $_POST['district'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $district)){
                $errors['district'] = 'District must be letters and/or spaces only.';
            }
        }

        else{
            $query = "SELECT district from address WHERE address_id = '$id_to_update'";
            $district_array = mysqli_query($conn, $query);
            $result2 = mysqli_fetch_assoc($district_array);
            $district = $result2['district'];
        }

        if (!empty($_POST['city_id'])){
            $city_id = $_POST['city_id'];
        }

        else{
            $query = "SELECT city_id from address WHERE address_id = '$id_to_update'";
            $city_id_array = mysqli_query($conn, $query);
            $result3 = mysqli_fetch_assoc($city_id_array);
            $city_id = $result3['city_id'];
        }

        if (!empty($_POST['postal_code'])){
            $postal_code = $_POST['postal_code'];
        }

        else{
            $query = "SELECT postal_code from address WHERE address_id = '$id_to_update'";
            $postal_code_array = mysqli_query($conn, $query);
            $result4 = mysqli_fetch_assoc($postal_code_array);
            $postal_code = $result4['postal_code'];
        }

        if (!empty($_POST['phone'])){
            $phone = $_POST['phone'];
        }

        else{
            $query = "SELECT phone from address WHERE address_id = '$id_to_update'";
            $phone_array = mysqli_query($conn, $query);
            $result5 = mysqli_fetch_assoc($phone_array);
            $phone = $result5['phone'];
        }
    }

    if(array_filter($errors)){
        //
    }
    
    else{

        $sql = "UPDATE address SET street_address = '$street_address', district = '$district', city_id = '$city_id', postal_code = '$postal_code', phone = '$phone', last_update = '$last_update' WHERE address_id = '$id_to_update'";

        if(mysqli_query($conn, $sql)){
            header('Location: address.php');
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
        <label>Address Id that you wish to update: </label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_update) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label>Street Address: </label>
        <input type="text" name="street_address" value="<?php echo htmlspecialchars($street_address) ?>">
        <div class="red-text"><?php echo $errors['street_address']; ?></div>

        <label>District: </label>
        <input type="text" name="district" value="<?php echo htmlspecialchars($district) ?>">
        <div class="red-text"><?php echo $errors['district']; ?></div>

        <label>City Id: </label>
        <input type="text" name="city_id" value="<?php echo htmlspecialchars($city_id) ?>">
        <div class="red-text"><?php echo $errors['city_id']; ?></div>

        <label>Postal Code: </label>
        <input type="text" name="postal_code" value="<?php echo htmlspecialchars($postal_code) ?>">
        <div class="red-text"><?php echo $errors['postal_code']; ?></div>

        <label>Phone: </label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($phone) ?>">
        <div class="red-text"><?php echo $errors['phone']; ?></div>

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