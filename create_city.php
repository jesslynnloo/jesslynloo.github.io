<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$query_last_id = "SELECT city_id from city ORDER BY city_id DESC LIMIT 1";
$id_array = mysqli_query($conn, $query_last_id);
$result1 = mysqli_fetch_assoc($id_array);
$id_to_create = $result1['city_id']+1;

$city = '';
$country_id = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'city'=>'', 'country_id'=>'');

if(isset($_POST['submit'])){

    if(empty($_POST['city'])){
        $errors['city'] = 'City name is required. <br />';
    }
    else{
        $city = $_POST['city'];
    }

    if(empty($_POST['country_id'])){
        $errors['country_id'] = 'Country Id is required. <br />';
    }
    else{
        $country_id = $_POST['country_id'];
    }

    if(array_filter($errors)){
        //
    }
    
    else{
        $sql = "INSERT INTO city (city_id, city, country_id, last_update) VALUES ('$id_to_create', '$city', '$country_id', '$last_update')";

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

    <form action="create_city.php" class="white" method="POST">
		<label>City Id</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_create) ?>" readonly>
        <div class="red-text"><?php echo $errors['id']; ?></div>

		<label>City Name</label>
		<input type="text" name="city" value="<?php echo htmlspecialchars($city) ?>">
        <div class="red-text"><?php echo $errors['city']; ?></div>

        <label>Country Id</label>
		<input type="text" name="country_id" value="<?php echo htmlspecialchars($country_id) ?>">
        <div class="red-text"><?php echo $errors['country_id']; ?></div>

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