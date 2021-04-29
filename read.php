<?php 

include('config/connect.php');

$sql = 'SHOW tables';

$result = mysqli_query($conn, $sql);

$i = 0;

if(isset($_POST['submit'])){
    if($_POST['view'] == 1){
        header('Location: actor.php');
    }
    elseif($_POST['view'] == 2){
        header('Location: address.php');
    }
    elseif($_POST['view'] == 3){
        header('Location: category.php');
    }
    elseif($_POST['view'] == 4){
        header('Location: city.php');
    }
    elseif($_POST['view'] == 5){
        header('Location: country.php');
    }
    elseif($_POST['view'] == 6){
        header('Location: customer.php');
    }
    elseif($_POST['view'] == 7){
        header('Location: customer_email.php');
    }
    elseif($_POST['view'] == 8){
        header('Location: feature.php');
    }
    elseif($_POST['view'] == 9){
        header('Location: film.php');
    }
    elseif($_POST['view'] == 10){
        header('Location: film_actor.php');
    }
    elseif($_POST['view'] == 11){
        header('Location: film_category.php');
    }
    elseif($_POST['view'] == 12){
        header('Location: film_feature.php');
    }
    elseif($_POST['view'] == 13){
        header('Location: inventory.php');
    }
    elseif($_POST['view'] == 14){
        header('Location: language.php');
    }
    elseif($_POST['view'] == 15){
        header('Location: payment.php');
    }
    elseif($_POST['view'] == 16){
        header('Location: rental.php');
    }
    elseif($_POST['view'] == 17){
        header('Location: staff.php');
    }
    elseif($_POST['view'] == 18){
        header('Location: staff_email.php');
    }
    elseif($_POST['view'] == 19){
        header('Location: store.php');
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


    <h4 class="center">View tables</h4>
    <form action="#" class="white" method="POST">
        <label>Table that you wish to view (Please key in Table ID): </label>
        <input type="text" name="view" value="">
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