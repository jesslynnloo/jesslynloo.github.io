<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$id_to_update = '';
$country = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'country'=>'');

if(isset($_POST['submit'])){

    $id_to_update = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'ID is required. <br />';
    }
    else{
        $sql_check_id = "SELECT country_id FROM country WHERE country_id = $id_to_update";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if(mysqli_num_rows($result_check_id) == 0){
            $errors['id'] = 'ID is not found in the table. <br />';        
        }
    }

    if(empty($_POST['country'])){
        $errors['country'] = 'Please key in country name. <br />'; 
    }
    else{
        $country = $_POST['country'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $country)){
            $errors['country'] = 'Country name must be letters and/or spaces only.';
        }
    }

    if(array_filter($errors)){
        //
    }
    
    else{

        $sql = "UPDATE country SET country = '$country', last_update = '$last_update' WHERE country_id = '$id_to_update'";

        if(mysqli_query($conn, $sql)){
            header('Location: country.php');
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
        <label>Country Id that you wish to update: </label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_update) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label>Country Name: </label>
        <input type="text" name="country" value="<?php echo htmlspecialchars($country) ?>">
        <div class="red-text"><?php echo $errors['country']; ?></div>

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