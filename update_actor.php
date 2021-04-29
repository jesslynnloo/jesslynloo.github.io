<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$id_to_update = '';
$first_name = $last_name = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'first_name'=>'', 'last_name'=>'');

if(isset($_POST['submit'])){

    $id_to_update = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'ID is required. <br />';
    }
    else{
        $sql_check_id = "SELECT actor_id FROM actor WHERE actor_id = $id_to_update";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if(mysqli_num_rows($result_check_id) == 0){
            $errors['id'] = 'ID is not found in the table. <br />';        
        }
    }

    if(empty($_POST['first_name']) and empty($_POST['last_name'])){
        $errors['first_name'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['last_name'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
    }
    else{
        if (!empty($_POST['first_name'])){
            $first_name = $_POST['first_name'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $first_name)){
                $errors['first_name'] = 'First name must be letters and/or spaces only.';
            }
        }

        else{
            $query = "SELECT first_name from actor WHERE actor_id = '$id_to_update'";
            $first_name_array = mysqli_query($conn, $query);
            $result1 = mysqli_fetch_assoc($first_name_array);
            $first_name = $result1['first_name'];
        }

        if (!empty($_POST['last_name'])){
            $last_name = $_POST['last_name'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $last_name)){
                $errors['last_name'] = 'Last name must be letters and/or spaces only.';
            }
        }

        else{
            $query = "SELECT last_name from actor WHERE actor_id = '$id_to_update'";
            $last_name_array = mysqli_query($conn, $query);
            $result2 = mysqli_fetch_assoc($last_name_array);
            $last_name = $result2['last_name'];
        }
    }

    if(array_filter($errors)){
        //
    }
    
    else{

        $sql = "UPDATE actor SET first_name = '$first_name', last_name = '$last_name', last_update = '$last_update' WHERE actor_id = '$id_to_update'";

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
        <label>Actor Id that you wish to update: </label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_update) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label>First Name: </label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name) ?>">
        <div class="red-text"><?php echo $errors['first_name']; ?></div>

        <label>Last Name: </label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name) ?>">
        <div class="red-text"><?php echo $errors['last_name']; ?></div>

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