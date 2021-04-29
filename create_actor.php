<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$query_last_id = "SELECT actor_id from actor ORDER BY actor_id DESC LIMIT 1";
$id_array = mysqli_query($conn, $query_last_id);
$result1 = mysqli_fetch_assoc($id_array);
$id_to_create = $result1['actor_id']+1;

$first_name = '';
$last_name = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'first_name'=>'', 'last_name'=>'');

if(isset($_POST['submit'])){

    if(empty($_POST['first_name'])){
        $errors['first_name'] = 'First name is required. <br />';
    }
    else{
        $first_name = $_POST['first_name'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $first_name)){
            $errors['first_name'] = 'First name must be letters and/or spaces only.';
        }
    }

    if(empty($_POST['last_name'])){
        $errors['last_name'] = 'Last name is required. <br />';
    }
    else{
        $last_name = $_POST['last_name'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $last_name)){
            $errors['last_name'] = 'Last name must be letters and/or spaces only.';
        }
    }

    if(array_filter($errors)){
        //
    }
    
    else{
        $sql = "INSERT INTO actor (actor_id, first_name, last_name, last_update) VALUES ('$id_to_create', '$first_name', '$last_name', '$last_update')";

        if(mysqli_query($conn, $sql)){
            header('Location: actor.php');
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
		<label>Actor Id</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_create) ?>" readonly>
        <div class="red-text"><?php echo $errors['id']; ?></div>

		<label>First Name</label>
		<input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name) ?>">
        <div class="red-text"><?php echo $errors['first_name']; ?></div>

		<label>Last Name</label>
		<input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name) ?>">
        <div class="red-text"><?php echo $errors['last_name']; ?></div>

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