<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$id_to_create = '';
$film_id = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'film_id'=>'');

if(isset($_POST['submit'])){

    $id_to_create = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'Actor Id is required. <br />';
    }

    if(empty($_POST['film_id'])){
        $errors['film_id'] = 'Film Id is required. <br />';
    }
    else{
        $film_id = $_POST['film_id'];
    }

    if(array_filter($errors)){
        //
    }
 
    else{
        $sql = "INSERT INTO film_actor (actor_id, film_id, last_update) VALUES ('$id_to_create', '$film_id', '$last_update')";

        if(mysqli_query($conn, $sql)){
            header('Location: film_actor.php');
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

    <form action="create_film_actor.php" class="white" method="POST">
		<label>Actor Id</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_create) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label>Film Id</label>
		<input type="text" name="film_id" value="<?php echo htmlspecialchars($film_id) ?>">
        <div class="red-text"><?php echo $errors['film_id']; ?></div>

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