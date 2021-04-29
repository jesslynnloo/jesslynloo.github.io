<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$id_to_update = '';
$city = '';
$country_id = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'city'=>'', 'country_id'=>'');

if(isset($_POST['submit'])){

    $id_to_update = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'ID is required. <br />';
    }
    else{
        $sql_check_id = "SELECT city_id FROM city WHERE city_id = $id_to_update";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if(mysqli_num_rows($result_check_id) == 0){
            $errors['id'] = 'ID is not found in the table. <br />';        
        }
    }

    if(empty($_POST['city']) and empty($_POST['country_id'])){
        $errors['city'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['country_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
    }
    else{
        if (!empty($_POST['city'])){
            $city = $_POST['city'];
        }

        else{
            $query = "SELECT city from city WHERE city_id = '$id_to_update'";
            $city_array = mysqli_query($conn, $query);
            $result1 = mysqli_fetch_assoc($city_array);
            $city = $result1['city'];
        }

        if (!empty($_POST['country_id'])){
            $country_id = $_POST['country_id'];
        }

        else{
            $query = "SELECT country_id from city WHERE city_id = '$id_to_update'";
            $country_id_array = mysqli_query($conn, $query);
            $result2 = mysqli_fetch_assoc($country_id_array);
            $country_id = $result2['country_id'];
        }
    }

    if(array_filter($errors)){
        //
    }
    
    else{

        $sql = "UPDATE city SET city = '$city', country_id = '$country_id', last_update = '$last_update' WHERE city_id = '$id_to_update'";

        if(mysqli_query($conn, $sql)){
            header('Location: city.php');
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
        <label>City Id that you wish to update: </label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_update) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label>City: </label>
        <input type="text" name="city" value="<?php echo htmlspecialchars($city) ?>">
        <div class="red-text"><?php echo $errors['city']; ?></div>

        <label>Country Id: </label>
        <input type="text" name="country_id" value="<?php echo htmlspecialchars($country_id) ?>">
        <div class="red-text"><?php echo $errors['country_id']; ?></div>

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