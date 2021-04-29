<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$query_last_id = "SELECT country_id from country ORDER BY country_id DESC LIMIT 1";
$id_array = mysqli_query($conn, $query_last_id);
$result1 = mysqli_fetch_assoc($id_array);
$id_to_create = $result1['country_id']+1;

$country = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'country'=>'');

if(isset($_POST['submit'])){

    if(empty($_POST['country'])){
        $errors['country'] = 'Country name is required. <br />';
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
        $sql = "INSERT INTO country (country_id, country, last_update) VALUES ('$id_to_create', '$country', '$last_update')";

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

    <form action="create_country.php" class="white" method="POST">
		<label>Country Id</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_create) ?>" readonly>
        <div class="red-text"><?php echo $errors['id']; ?></div>

		<label>Country Name</label>
		<input type="text" name="country" value="<?php echo htmlspecialchars($country) ?>">
        <div class="red-text"><?php echo $errors['country']; ?></div>

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