<?php
ob_start();
include('templates/header.php');
include('config/connect.php');

$streetAddress = $district = '';
$id_to_delete = '';
$errors = array('id'=>'', 'street_address'=>'', 'district'=>'');
if(isset($_POST['submit'])){

    $id_to_delete = $_POST['id'];

    if(empty($_POST['id'])){
        $errors['id'] = 'ID is required. <br />';
    }
    else{
        $sql_check_id = "SELECT address_id FROM address WHERE address_id = $id_to_delete";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if(mysqli_num_rows($result_check_id) == 0){
            $errors['id'] = 'ID is not found in the table. <br />';
        
        
        }
    }

    if(empty($_POST['street_address'])){
        $errors['street_address'] = 'Street address is required. <br />';
    }
    else{
        $streetAddress = $_POST['street_address'];
        
        if(mysqli_num_rows($result_check_id) > 0){

            $sql = "SELECT street_address FROM address WHERE address_id = $id_to_delete";
            $result = mysqli_query($conn, $sql);
            $result_array = mysqli_fetch_array($result);

            if($streetAddress != $result_array[0]){
                $errors['street_address'] = 'The id and street address do not match!';
            }
            
        }
    }


    if(empty($_POST['district'])){
        $errors['district'] = 'District is required. <br />';
    }
    else{

        $district = $_POST['district'];
        


        if(mysqli_num_rows($result_check_id) > 0){
            $sql = "SELECT district FROM address WHERE address_id = $id_to_delete";
            $result = mysqli_query($conn, $sql);
            $result_array = mysqli_fetch_array($result);

            if($district != $result_array[0]){
                $errors['district'] = 'The id and district do not match!';
            }
            
        }
    }


    
            
        
        

    
    

    
    if(array_filter($errors)){
        //
    }
    
    else{
        $id_to_delete = $_POST['id'];

        $sql = "DELETE FROM address WHERE address_id = $id_to_delete";

        if(mysqli_query($conn, $sql)){
            header('Location: address.php');
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
        <label>Street address: </label>
        <input type="text" name="street_address" value="<?php echo htmlspecialchars($streetAddress) ?>">
        <div class="red-text"><?php echo $errors['street_address']; ?></div>
        <label>District: </label>
        <input type="text" name="district" value="<?php echo htmlspecialchars($district) ?>">
        <div class="red-text"><?php echo $errors['district']; ?></div>
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