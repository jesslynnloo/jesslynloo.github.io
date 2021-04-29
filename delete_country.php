<?php
ob_start();
include('templates/header.php');
include('config/connect.php');


$country = '';
$id_to_delete = '';
$errors = array('id'=>'', 'country'=>'');
if(isset($_POST['submit'])){

    $id_to_delete = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'ID is required. <br />';
    }
    else{
        $sql_check_id = "SELECT country_id FROM country WHERE country_id = $id_to_delete";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if(mysqli_num_rows($result_check_id) == 0){
            $errors['id'] = 'ID is not found in the table. <br />';
        
        }
    }

    if(empty($_POST['country'])){
        $errors['country'] = 'Country is required. <br />';
    }
    else{
        $country = $_POST['country'];
        
        if(mysqli_num_rows($result_check_id) > 0){

            $sql = "SELECT country FROM country WHERE country_id = $id_to_delete";
            $result = mysqli_query($conn, $sql);
            $result_array = mysqli_fetch_array($result);

            if($country != $result_array[0]){
                $errors['country'] = 'The id and country do not match!';
            }
            
        }
    }


    if(array_filter($errors)){
        //
    }
    
    else{
        $id_to_delete = $_POST['id'];


        $sql = "DELETE FROM country WHERE country_id = $id_to_delete";

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

<form action="#" class="white" method="POST">
        <label>id that you wish to delete: </label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_delete) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>
        <label>Country: </label>
        <input type="text" name="country" value="<?php echo htmlspecialchars($country) ?>">
        <div class="red-text"><?php echo $errors['country']; ?></div>
        <div class="center">
            <input type="submit" name="submit" value="Next" class="btn brand z-depth-0">
        </div>
    </form>

    <form action="delete.php" method="POST">
        <input type="hidden" name="id" value="">
        <input type="submit" name="back" value="Back to previous page" class=" right btn brand z-depth-0">

    </form>

</body>

</html>