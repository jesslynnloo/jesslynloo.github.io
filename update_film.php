<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$id_to_update = '';
$title = '';
$description = '';
$release_year ='';
$language_id = '';
$rental_duration = '';
$rental_rate = '';
$length = ''; 
$replacement_cost = '';
$rating = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'title'=>'', 'description'=>'', 'release_year'=>'', 'language_id'=>'', 'rental_duration'=>'', 'rental_rate'=>'', 'length'=>'', 'replacement_cost'=>'', 'rating'=>'');

if(isset($_POST['submit'])){

    $id_to_update = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'ID is required. <br />';
    }
    else{
        $sql_check_id = "SELECT film_id FROM film WHERE film_id = $id_to_update";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if(mysqli_num_rows($result_check_id) == 0){
            $errors['id'] = 'ID is not found in the table. <br />';        
        }
    }

    if(empty($_POST['title']) and empty($_POST['description']) and empty($_POST['release_year']) and empty($_POST['language_id']) and empty($_POST['rental_duration'])and empty($_POST['rental_rate']) and empty($_POST['length']) and empty($_POST['replacement_cost']) and empty($_POST['rating'])){
        $errors['title'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['description'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['release_year'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['language_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['rental_duration'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['rental_rate'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['length'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['replacement_cost'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['rating'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
    }
    else{
        if (!empty($_POST['title'])){
            $title = $_POST['title'];
        }

        else{
            $query = "SELECT title from film WHERE film_id = '$id_to_update'";
            $title_array = mysqli_query($conn, $query);
            $result1 = mysqli_fetch_assoc($title_array);
            $title = $result1['title'];
        }

        if (!empty($_POST['description'])){
            $description = $_POST['description'];
        }

        else{
            $query = "SELECT description from film WHERE film_id = '$id_to_update'";
            $description_array = mysqli_query($conn, $query);
            $result2 = mysqli_fetch_assoc($description_array);
            $description = $result2['description'];
        }

        if (!empty($_POST['release_year'])){
            $release_year = $_POST['release_year'];
        }

        else{
            $query = "SELECT release_year from film WHERE film_id = '$id_to_update'";
            $release_year_array = mysqli_query($conn, $query);
            $result3 = mysqli_fetch_assoc($release_year_array);
            $release_year = $result3['release_year'];
        }

        if (!empty($_POST['language_id'])){
            $language_id = $_POST['language_id'];
        }

        else{
            $query = "SELECT language_id from film WHERE film_id = '$id_to_update'";
            $language_id_array = mysqli_query($conn, $query);
            $result4 = mysqli_fetch_assoc($language_id_array);
            $language_id = $result4['language_id'];
        }

        if (!empty($_POST['rental_duration'])){
            $rental_duration = $_POST['rental_duration'];
        }

        else{
            $query = "SELECT rental_duration from film WHERE film_id = '$id_to_update'";
            $rental_duration_array = mysqli_query($conn, $query);
            $result5 = mysqli_fetch_assoc($rental_duration_array);
            $rental_duration = $result5['rental_duration'];
        }

        if (!empty($_POST['rental_rate'])){
            $rental_rate = $_POST['rental_rate'];
        }

        else{
            $query = "SELECT rental_rate from film WHERE film_id = '$id_to_update'";
            $rental_rate_array = mysqli_query($conn, $query);
            $result6 = mysqli_fetch_assoc($rental_rate_array);
            $rental_rate = $result6['rental_rate'];
        }

        if (!empty($_POST['length'])){
            $length = $_POST['length'];
        }

        else{
            $query = "SELECT length from film WHERE film_id = '$id_to_update'";
            $length_array = mysqli_query($conn, $query);
            $result7 = mysqli_fetch_assoc($length_array);
            $length = $result7['length'];
        }

        if (!empty($_POST['replacement_cost'])){
            $replacement_cost = $_POST['replacement_cost'];
        }

        else{
            $query = "SELECT replacement_cost from film WHERE film_id = '$id_to_update'";
            $replacement_cost_array = mysqli_query($conn, $query);
            $result8 = mysqli_fetch_assoc($replacement_cost_array);
            $replacement_cost = $result8['replacement_cost'];
        }

        if (!empty($_POST['rating'])){
            $rating = $_POST['rating'];
        }

        else{
            $query = "SELECT rating from film WHERE film_id = '$id_to_update'";
            $rating_array = mysqli_query($conn, $query);
            $result5 = mysqli_fetch_assoc($rating_array);
            $rating = $result5['rating'];
        }
    }

    if(array_filter($errors)){
        //
    }
    
    else{

        $sql = "UPDATE film SET title = '$title', description = '$description', release_year = '$release_year', language_id = '$language_id', rental_duration = '$rental_duration', rental_rate = '$rental_rate', length = '$length', replacement_cost = '$replacement_cost', rating = '$rating', last_update = '$last_update' WHERE film_id = '$id_to_update'";

        if(mysqli_query($conn, $sql)){
            header('Location: film.php');
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
        <label>Film Id that you wish to update: </label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_update) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label>Title: </label>
		<input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
        <div class="red-text"><?php echo $errors['title']; ?></div>

        <label>Description: </label>
        <input type="text" name="description" value="<?php echo htmlspecialchars($description) ?>">
        <div class="red-text"><?php echo $errors['description']; ?></div>

        <label>Release Year: </label>
        <input type="text" name="release_year" value="<?php echo htmlspecialchars($release_year) ?>">
        <div class="red-text"><?php echo $errors['release_year']; ?></div>

        <label>Language Id: </label>
        <input type="text" name="language_id" value="<?php echo htmlspecialchars($language_id) ?>">
        <div class="red-text"><?php echo $errors['language_id']; ?></div>

        <label>Rental Duration: </label>
        <input type="text" name="rental_duration" value="<?php echo htmlspecialchars($rental_duration) ?>">
        <div class="red-text"><?php echo $errors['rental_duration']; ?></div>

		<label>Rental Rate: </label>
		<input type="text" name="rental_rate" value="<?php echo htmlspecialchars($rental_rate) ?>">
        <div class="red-text"><?php echo $errors['rental_rate']; ?></div>

        <label>Length: </label>
        <input type="text" name="length" value="<?php echo htmlspecialchars($length) ?>">
        <div class="red-text"><?php echo $errors['length']; ?></div>

        <label>Replacement Cost: </label>
        <input type="text" name="replacement_cost" value="<?php echo htmlspecialchars($replacement_cost) ?>">
        <div class="red-text"><?php echo $errors['replacement_cost']; ?></div>

        <label>Rating: </label>
        <input type="text" name="rating" value="<?php echo htmlspecialchars($rating) ?>">
        <div class="red-text"><?php echo $errors['rating']; ?></div>

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