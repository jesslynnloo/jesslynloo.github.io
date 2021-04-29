<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$query_last_id = "SELECT feature_id from feature ORDER BY feature_id DESC LIMIT 1";
$id_array = mysqli_query($conn, $query_last_id);
$result1 = mysqli_fetch_assoc($id_array);
$id_to_create = $result1['feature_id']+1;

$special_feature = '';
date_default_timezone_set("Asia/Kuala_Lumpur");
$last_update = date("Y-m-d H:i:s");
$errors = array('id'=>'', 'special_feature'=>'');

if(isset($_POST['submit'])){

    if(empty($_POST['special_feature'])){
        $errors['special_feature'] = 'Special feature is required. <br />';
    }
    else{
        $special_feature = $_POST['special_feature'];
    }

    if(array_filter($errors)){
        //
    }
    
    else{
        $sql = "INSERT INTO feature (feature_id, special_feature, last_update) VALUES ('$id_to_create', '$special_feature', '$last_update')";

        if(mysqli_query($conn, $sql)){
            header('Location: feature.php');
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

    <form action="create_feature.php" class="white" method="POST">
		<label>Feature Id</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_create) ?>" readonly>
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label>Special Feature</label>
		<input type="text" name="special_feature" value="<?php echo htmlspecialchars($special_feature) ?>">
        <div class="red-text"><?php echo $errors['special_feature']; ?></div>

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