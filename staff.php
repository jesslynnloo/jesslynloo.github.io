<?php
include('templates/header.php');
include('config/connect.php');
$table_id = 0;

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        .myselect {
            width: 100%;
            height: auto;
            padding: 16px 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f1f1f1;
            display: inline-block !important;
        }

        #myInput {
            background-image: url('/css/searchicon.png');
            background-position: 10px 10px;
            background-repeat: no-repeat;
            width: 95%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }

        #myTable {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
            font-size: 18px;
        }

        #myTable th,
        #myTable td {
            text-align: left;
            padding: 12px;
        }

        #myTable tr {
            border-bottom: 1px solid #ddd;
        }

        #myTable tr.header,
        #myTable tr:hover {
            background-color: #f1f1f1;
        }

        #content {
            width: 50%;
            margin: 20px auto;
            border: 1px solid #cbcbcb;
        }

        #img_div {
            width: 80%;
            padding: 5px;
            margin: 15px auto;
            border: 1px solid #cbcbcb;
        }

        #img_div:after {
            content: "";
            display: block;
            clear: both;
        }

        img {
            float: left;
            margin: 5px;
            width: 250px;
            min-height: 100px;
        }
    </style>
</head>

<body>

    <h2 class="center"><b>Staff</b></h2>

    <form action="read.php" method="POST">
        <input type="hidden" name="id" value="">
        <input type="submit" name="back" value="Go to view table page" class="left btn brand z-depth-0">

    </form>

    <form action="staff.php" method="POST">
        <label for="order">Order by:</label>
        <select name="order_list" id="order_list" class="myselect">
            <option value="staff_id">Staff ID</option>
            <option value="first_name">First Name</option>
            <option value="last_name">Last Name</option>
            <option value="address_id">Address ID</option>
            <option value="store_id">Store ID</option>
            <option value="last_update">Last Update</option>
        </select>
        <br><br>
        <input type="submit" name="order_submit" value="Submit" class="left btn brand z-depth-0">
    </form>

    <br>
    <h5>Type in staff's first name: </h5>
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for staff's first name.." title="Type in staff's first name">

    <table id="myTable">
        <tr class="header">
            <th style="width:10%;">Staff ID</th>
            <th style="width:20%;">First Name</th>
            <th style="width:20%;">Last Name</th>
            <th style="width:10%;">Address ID</th>
            <th style="width:10%;">Picture</th>
            <th style="width:10%;">Store ID</th>
            <th style="width:20%;">Last Update</th>
        </tr>

        <?php
        require "config/connect.php";

        $query = "SELECT * FROM staff";

        if (isset($_POST['order_list'])) {
            $query = "SELECT * FROM staff ORDER BY " . $_POST['order_list'] . ", staff_id";
        }

        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr><td>' . $row['staff_id'] . '</td><td>' . $row['first_name'] . '</td><td>' .
                $row['last_name'] . '</td><td>' . $row['address_id'] . '</td><td>' .
                "<img src='data:jpeg" . ";base64," . base64_encode($row['picture']) . "' >" . '</td><td>' .
                $row['store_id'] . '</td><td>' . $row['last_update'] . "</td></tr>";
        }
        ?>
    </table>

    <script>
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

    <h2></h2>

</body>

</html>