<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$id_to_update = '';
$staff_id = '';
$email = '';
$active ='';
$username = '';
$password = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'staff_id'=>'', 'email'=>'', 'active'=>'', 'username'=>'', 'password'=>'');

if(isset($_POST['submit'])){

    $id_to_update = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'ID is required. <br />';
    }
    else{
        $sql_check_id = "SELECT email_id FROM staff_email WHERE email_id = $id_to_update";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if(mysqli_num_rows($result_check_id) == 0){
            $errors['id'] = 'ID is not found in the table. <br />';        
        }
    }

    if(empty($_POST['staff_id']) and empty($_POST['email']) and empty($_POST['active']) and empty($_POST['username']) and empty($_POST['password'])){
        $errors['staff_id'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['email'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['active'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['username'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
        $errors['password'] = 'Please key in the value that you want to update in the appropriate place. <br />'; 
    }
    else{
        if (!empty($_POST['staff_id'])){
            $staff_id = $_POST['staff_id'];
        }

        else{
            $query = "SELECT staff_id from staff_email WHERE email_id = '$id_to_update'";
            $staff_id_array = mysqli_query($conn, $query);
            $result1 = mysqli_fetch_assoc($staff_id_array);
            $staff_id = $result1['staff_id'];
        }

        if (!empty($_POST['email'])){
            $email = $_POST['email'];
        }

        else{
            $query = "SELECT email from staff_email WHERE email_id = '$id_to_update'";
            $email_array = mysqli_query($conn, $query);
            $result2 = mysqli_fetch_assoc($email_array);
            $email = $result2['email'];
        }

        if (!empty($_POST['active'])){
            $active = $_POST['active'];
        }

        else{
            $query = "SELECT active from staff_email WHERE email_id = '$id_to_update'";
            $active_array = mysqli_query($conn, $query);
            $result3 = mysqli_fetch_assoc($active_array);
            $active = $result3['active'];
        }

        if (!empty($_POST['username'])){
            $username = $_POST['username'];
        }

        else{
            $query = "SELECT username from staff_email WHERE email_id = '$id_to_update'";
            $username_array = mysqli_query($conn, $query);
            $result4 = mysqli_fetch_assoc($username_array);
            $username = $result4['username'];
        }

        if (!empty($_POST['password'])){
            $username = $_POST['password'];
        }

        else{
            $query = "SELECT password from staff_email WHERE email_id = '$id_to_update'";
            $password_array = mysqli_query($conn, $query);
            $result4 = mysqli_fetch_assoc($password_array);
            $password = $result4['password'];
        }
    }

    if(array_filter($errors)){
        //
    }
    
    else{

        $sql = "UPDATE staff_email SET staff_id = '$staff_id', email = '$email', active = '$active', username = '$username', password = '$password', last_update = '$last_update' WHERE email_id = '$id_to_update'";

        if(mysqli_query($conn, $sql)){
            header('Location: staff_email.php');
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
        <label>Email Id that you wish to update: </label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_update) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label>Staff Id: </label>
		<input type="text" name="staff_id" value="<?php echo htmlspecialchars($staff_id) ?>">
        <div class="red-text"><?php echo $errors['staff_id']; ?></div>

        <label>Email: </label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <div class="red-text"><?php echo $errors['email']; ?></div>

        <label>Active: </label>
        <input type="text" name="active" value="<?php echo htmlspecialchars($active) ?>">
        <div class="red-text"><?php echo $errors['active']; ?></div>

        <label>Username: </label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($username) ?>">
        <div class="red-text"><?php echo $errors['username']; ?></div>

        <label>Password: </label>
        <input type="password" name="password" value="">

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