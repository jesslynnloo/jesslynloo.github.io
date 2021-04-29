<?php 

include('config/connect.php');

$sql = 'SHOW tables';

$result = mysqli_query($conn, $sql);

$i = 0;

if(isset($_POST['submit'])){
    if($_POST['table_id'] == 1){
        header('Location: update_actor.php');
    }
    elseif($_POST['table_id'] == 2){
        header('Location: update_address.php');
    }
    elseif($_POST['table_id'] == 3){
        header('Location: update_category.php');
    }
    elseif($_POST['table_id'] == 4){
        header('Location: update_city.php');
    }
    elseif($_POST['table_id'] == 5){
        header('Location: update_country.php');
    }
    elseif($_POST['table_id'] == 6){
        header('Location: update_customer.php');
    }
    elseif($_POST['table_id'] == 7){
        header('Location: update_customer_email.php');
    }
    elseif($_POST['table_id'] == 8){
        header('Location: update_feature.php');
    }
    elseif($_POST['table_id'] == 9){
        header('Location: update_film.php');
    }
    elseif($_POST['table_id'] == 10){
        header('Location: update_film_actor.php');
    }
    elseif($_POST['table_id'] == 11){
        header('Location: update_film_category.php');
    }
    elseif($_POST['table_id'] == 12){
        header('Location: update_film_feature.php');
    }
    elseif($_POST['table_id'] == 13){
        header('Location: update_inventory.php');
    }
    elseif($_POST['table_id'] == 14){
        header('Location: update_language.php');
    }
    elseif($_POST['table_id'] == 15){
        header('Location: update_payment.php');
    }
    elseif($_POST['table_id'] == 16){
        header('Location: update_rental.php');
    }
    elseif($_POST['table_id'] == 17){
        header('Location: update_staff.php');
    }
    elseif($_POST['table_id'] == 18){
        header('Location: update_staff_email.php');
    }
    elseif($_POST['table_id'] == 19){
        header('Location: update_store.php');
    }
}

?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php');?>




    <h6 class="center">All tables:</h6>
    <table>
        <tr>
            <th style="width:20%;">Table ID</th>
            <th style="width:50%;">Table</th>
        </tr>

        
       <?php while($table = mysqli_fetch_array($result)){
            $i++; ?>
            
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $table[0]; ?></td>
            </tr>
        <?php } ?>
    </table>


    <h4 class="center">Update data</h4>
    <form action="update.php" class="white" method="POST">
        <label>Table_id that you want to choose to update data from: </label>
        <input type="text" name="table_id" value="">
        <div class="red-text"></div>
        <div class="center">
            <input type="submit" name="submit" value="Next" class="btn brand z-depth-0">
        </div>
    </form>

    <form action="index.php" method="POST">
        <input type="hidden" name="id" value="">
        <input type="submit" name="back" value="Back to main menu" class=" right btn brand z-depth-0">

    </form>

    


</html>