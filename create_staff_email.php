<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$query_last_id = "SELECT email_id from staff_email ORDER BY email_id DESC LIMIT 1";
$id_array = mysqli_query($conn, $query_last_id);
$result1 = mysqli_fetch_assoc($id_array);
$id_to_create = $result1['email_id']+1;

$staff_id = '';
$email = '';
$active ='';
$username = '';
$password = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'staff_id'=>'', 'email'=>'', 'active'=>'', 'username'=>'', 'password'=>'');

if(isset($_POST['submit'])){

    if(empty($_POST['staff_id'])){
        $errors['staff_id'] = 'Staff Id is required. <br />';
    }
    else{
        $staff_id = $_POST['staff_id'];
    }

    if(empty($_POST['email'])){
        $errors['email'] = 'Email is required. <br />';
    }
    else{
        $email = $_POST['email'];
    }

    if(empty($_POST['active'])){
        $errors['active'] = 'Active is required. <br />';
    }
    else{
        $active = $_POST['active'];
    }

    if(empty($_POST['username'])){
        $errors['username'] = 'Username is required. <br />';
    }
    else{
        $username = $_POST['username'];
    }

    if(array_filter($errors)){
        //
    }
    
    else{
        $password = $_POST['password'];
        $sql = "INSERT INTO staff_email (email_id, staff_id, email, active, username, password, last_update) VALUES ('$id_to_create', '$staff_id', '$email', '$active', '$username', '$password', '$last_update')";

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

    <form action="create_staff_email.php" class="white" method="POST">
		<label>Email Id</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_create) ?>" readonly>
        <div class="red-text"><?php echo $errors['id']; ?></div>

		<label>Staff Id</label>
		<input type="text" name="staff_id" value="<?php echo htmlspecialchars($staff_id) ?>">
        <div class="red-text"><?php echo $errors['staff_id']; ?></div>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <div class="red-text"><?php echo $errors['email']; ?></div>

        <label>Active</label>
        <input type="text" name="active" value="<?php echo htmlspecialchars($active) ?>">
        <div class="red-text"><?php echo $errors['active']; ?></div>

        <label>Username</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($username) ?>">
        <div class="red-text"><?php echo $errors['username']; ?></div>

        <label>Password</label>
        <input type="password" name="password" value="">

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