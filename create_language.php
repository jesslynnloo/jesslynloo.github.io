<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$query_last_id = "SELECT language_id from language ORDER BY language_id DESC LIMIT 1";
$id_array = mysqli_query($conn, $query_last_id);
$result1 = mysqli_fetch_assoc($id_array);
$id_to_create = $result1['language_id']+1;

$name = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'name'=>'');

if(isset($_POST['submit'])){

    if(empty($_POST['name'])){
        $errors['name'] = 'Name is required. <br />';
    }
    else{
        $name = $_POST['name'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $name)){
            $errors['name'] = 'Name must be letters and/or spaces only.';
        }
    }

    if(array_filter($errors)){
        //
    }
    
    else{
        $sql = "INSERT INTO language (language_id, name, last_update) VALUES ('$id_to_create', '$name', '$last_update')";

        if(mysqli_query($conn, $sql)){
            header('Location: language.php');
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

    <form action="create_language.php" class="white" method="POST">
		<label>Language Id</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_create) ?>" readonly>
        <div class="red-text"><?php echo $errors['id']; ?></div>

		<label>Name</label>
		<input type="text" name="name" value="<?php echo htmlspecialchars($name) ?>">
        <div class="red-text"><?php echo $errors['name']; ?></div>

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