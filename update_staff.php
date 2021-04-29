<!DOCTYPE html>
<html>

<head>
    <meta <charset="utf-8" />
</head>

<body>

    <?php

    include('templates/header.php');
    include('config/connect.php');

    $id_to_update = '';
    $first_name = '';
    $last_name = '';
    $address_id = '';
    $picture = '';
    $store_id = '';
    $stmt = '';
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $last_update = date("Y-m-d H:i:s");
    $errors = array('id' => '', 'first_name' => '', 'last_name' => '', 'address_id' => '', 'picture' => '', 'store_id' => '');

    $pdo = new PDO("mysql:host=localhost;dbname=" . $DATABASE_NAME . "", $USERNAME, $PASSWORD);



    //if upload button is clicked
    if (isset($_POST['submit'])) {

        $id_to_update = $_POST['id'];

        if (empty($_POST['id'])) {
            $errors['id'] = 'ID is required. <br />';
        } else {
            $sql_check_id = "SELECT staff_id FROM staff WHERE staff_id = $id_to_update";
            $result_check_id = mysqli_query($conn, $sql_check_id);

            if (mysqli_num_rows($result_check_id) == 0) {
                $errors['id'] = 'ID is not found in the table. <br />';
            }
        }

        if (empty($_POST['first_name']) and empty($_POST['last_name']) and empty($_POST['address_id']) and empty($_FILES['picture']['tmp_name']) and empty($_POST['store_id'])) {
            $errors['first_name'] = 'Please key in the value that you want to update in the appropriate place. <br />';
            $errors['last_name'] = 'Please key in the value that you want to update in the appropriate place. <br />';
            $errors['address_id'] = 'Please key in the value that you want to update in the appropriate place. <br />';
            $errors['picture'] = 'Please upload a picture if you wish to. <br />';
            $errors['store_id'] = 'Please key in the value that you want to update in the appropriate place. <br />';
        } else {

            if (!empty($_POST['first_name'])) {
                $first_name = $_POST['first_name'];
                if (!preg_match('/^[a-zA-Z\s]+$/', $first_name)) {
                    $errors['first_name'] = 'First name must be letters and/or spaces only.';
                }
            } else {
                $query = "SELECT first_name from staff WHERE staff_id = '$id_to_update'";
                $first_name_array = mysqli_query($conn, $query);
                $result2 = mysqli_fetch_assoc($first_name_array);
                $first_name = $result2['first_name'];
            }

            if (!empty($_POST['last_name'])) {
                $last_name = $_POST['last_name'];
                if (!preg_match('/^[a-zA-Z\s]+$/', $last_name)) {
                    $errors['last_name'] = 'Last name must be letters and/or spaces only.';
                }
            } else {
                $query = "SELECT last_name from staff WHERE staff_id = '$id_to_update'";
                $last_name_array = mysqli_query($conn, $query);
                $result3 = mysqli_fetch_assoc($last_name_array);
                $last_name = $result3['last_name'];
            }

            if (!empty($_POST['address_id'])) {
                $address_id = $_POST['address_id'];
            } else {
                $query = "SELECT address_id from staff WHERE staff_id = '$id_to_update'";
                $address_id_array = mysqli_query($conn, $query);
                $result4 = mysqli_fetch_assoc($address_id_array);
                $address_id = $result4['address_id'];
            }

            if (!empty($_FILES['picture']['tmp_name'])) {
                $query = "UPDATE staff SET picture=? WHERE staff_id=?";

                $name = $_FILES['picture']['name'];
                $type = $_FILES['picture']['type'];
                $picture = file_get_contents($_FILES['picture']['tmp_name']);
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(1, $picture);
                $stmt->bindParam(2, $id_to_update);

                // image file directory
                $target = "images/" . basename($name);
            }
            else{
                $query = "UPDATE staff SET picture=? WHERE staff_id=?";
                
                $query_get_old_picture = "SELECT picture FROM staff WHERE staff_id = '$id_to_update'";
                $picture_array = mysqli_query($conn, $query_get_old_picture);
                $result5 = mysqli_fetch_assoc($picture_array);
                //header("Content-type: image/jpeg");
                $picture = $result5['picture'];
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(1, $picture);
                $stmt->bindParam(2, $id_to_update);

                // image file directory
                $target = "images/" . basename($name);
            }

            if (!empty($_POST['store_id'])) {
                $store_id = $_POST['store_id'];
            } else {
                $query = "SELECT store_id from staff WHERE staff_id = '$id_to_update'";
                $store_id_array = mysqli_query($conn, $query);
                $result1 = mysqli_fetch_assoc($store_id_array);
                $store_id = $result1['store_id'];
            }
        }

        if (array_filter($errors)) {
            //
        } else {
            $sql = "UPDATE staff SET first_name = '$first_name', last_name = '$last_name', address_id = '$address_id', store_id = '$store_id', last_update = '$last_update' WHERE staff_id = '$id_to_update'";
            $stmt->execute();
            if (!empty($_FILES['picture']['tmp_name'])) {
                if (move_uploaded_file($_FILES['picture']['tmp_name'], $target)) {
                    $msg = "Image uploaded successfully";
                } else {
                    $msg = "Failed to upload image";
                }
            }

            if (mysqli_query($conn, $sql)) { ?>
                <script>
                    window.location = 'staff.php';
                </script>
            <?php }
            else {
                echo 'query error: ' . mysqli_error($conn);
            }
        }
    }

    ?>

    <form action="#" class="white" method="POST" enctype="multipart/form-data">
        <label>Staff Id that you wish to update: </label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id_to_update) ?>">
        <div class="red-text"><?php echo $errors['id']; ?></div>

        <label>First Name: </label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name) ?>">
        <div class="red-text"><?php echo $errors['first_name']; ?></div>

        <label>Last Name: </label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name) ?>">
        <div class="red-text"><?php echo $errors['last_name']; ?></div>

        <label>Address Id: </label>
        <input type="text" name="address_id" value="<?php echo htmlspecialchars($address_id) ?>">
        <div class="red-text"><?php echo $errors['address_id']; ?></div>

        <label>Picture</label><br><br>
        <div>
            <input type="file" name="picture" />
        </div><div class="red-text"><?php echo $errors['picture']; ?></div><br>

        <label>Store Id: </label>
        <input type="text" name="store_id" value="<?php echo htmlspecialchars($store_id) ?>">
        <div class="red-text"><?php echo $errors['store_id']; ?></div>

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