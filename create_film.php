<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$query_last_id = "SELECT film_id from film ORDER BY film_id DESC LIMIT 1";
$id_array = mysqli_query($conn, $query_last_id);
$result1 = mysqli_fetch_assoc($id_array);
$id_to_create = $result1['film_id']+1;

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

    if(empty($_POST['title'])){
        $errors['title'] = 'Title is required. <br />';
    }
    else{
        $title = $_POST['title'];
    }

    if(empty($_POST['description'])){
        $errors['description'] = 'Description is required. <br />';
    }
    else{
        $description = $_POST['description'];
    }

    if(empty($_POST['release_year'])){
        $errors['release_year'] = 'Release year is required. <br />';
    }
    else{
        $release_year = $_POST['release_year'];
    }

    if(empty($_POST['language_id'])){
        $errors['language_id'] = 'Language Id is required. <br />';
    }
    else{
        $language_id = $_POST['language_id'];
    }

    if(empty($_POST['rental_duration'])){
        $errors['rental_duration'] = 'Rental duration is required. <br />';
    }
    else{
        $rental_duration = $_POST['rental_duration'];
    }

    if(empty($_POST['rental_rate'])){
        $errors['rental_rate'] = 'Rental rate is required. <br />';
    }
    else{
        $rental_rate = $_POST['rental_rate'];
    }

    if(empty($_POST['length'])){
        $errors['length'] = 'Length is required. <br />';
    }
    else{
        $length = $_POST['length'];
    }
    
    if(empty($_POST['replacement_cost'])){
        $errors['replacement_cost'] = 'Replacement cost is required. <br />';
    }
    else{
        $replacement_cost = $_POST['replacement_cost'];
    }

    if(empty($_POST['rating'])){
        $errors['rating'] = 'Rating is required. <br />';
    }
    else{
        $rating = $_POST['rating'];
    }

    if(array_filter($errors)){
        //
    }
    
    else{
        $sql = "INSERT INTO film (film_id, title, description, release_year, language_id, rental_duration, rental_rate, length, replacement_cost, rating, last_update) VALUES ('$id_to_create', '$title', '$description', '$release_year', '$language_id', '$rental_duration', '$rental_rate', '$length', '$replacement_cost', '$rating','$last_update')";

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

    <form action="create_film.php" class="white" method="POST">
		<label>Film Id</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_create) ?>" readonly>
        <div class="red-text"><?php echo $errors['id']; ?></div>

		<label>Title</label>
		<input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
        <div class="red-text"><?php echo $errors['title']; ?></div>

        <label>Description</label>
        <input type="text" name="description" value="<?php echo htmlspecialchars($description) ?>">
        <div class="red-text"><?php echo $errors['description']; ?></div>

        <label>Release Year</label>
        <input type="text" name="release_year" value="<?php echo htmlspecialchars($release_year) ?>">
        <div class="red-text"><?php echo $errors['release_year']; ?></div>

        <label>Language Id</label>
        <input type="text" name="language_id" value="<?php echo htmlspecialchars($language_id) ?>">
        <div class="red-text"><?php echo $errors['language_id']; ?></div>

        <label>Rental Duration</label>
        <input type="text" name="rental_duration" value="<?php echo htmlspecialchars($rental_duration) ?>">
        <div class="red-text"><?php echo $errors['rental_duration']; ?></div>

		<label>Rental Rate</label>
		<input type="text" name="rental_rate" value="<?php echo htmlspecialchars($rental_rate) ?>">
        <div class="red-text"><?php echo $errors['rental_rate']; ?></div>

        <label>Length</label>
        <input type="text" name="length" value="<?php echo htmlspecialchars($length) ?>">
        <div class="red-text"><?php echo $errors['length']; ?></div>

        <label>Replacement Cost</label>
        <input type="text" name="replacement_cost" value="<?php echo htmlspecialchars($replacement_cost) ?>">
        <div class="red-text"><?php echo $errors['replacement_cost']; ?></div>

        <label>Rating</label>
        <input type="text" name="rating" value="<?php echo htmlspecialchars($rating) ?>">
        <div class="red-text"><?php echo $errors['rating']; ?></div>

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