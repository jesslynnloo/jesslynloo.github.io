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
    </style>
</head>

<body>

    <h2 class="center"><b>Rental</b></h2>

    <form action="read.php" method="POST">
        <input type="hidden" name="id" value="">
        <input type="submit" name="back" value="Go to view table page" class="left btn brand z-depth-0">

    </form>

    <form action="rental.php" method="POST">
        <label for="order">Order by:</label>
        <select name="order_list" id="order_list" class="myselect">
            <option value="rental_id">Rental ID</option>
            <option value="rental_date">Rental Date</option>
            <option value="inventory_id">Inventory ID</option>
            <option value="customer_id">Customer ID</option>
            <option value="return_date">Return Date</option>
            <option value="staff_id">Staff ID</option>
            <option value="last_update">Last Update</option>
        </select>
        <br><br>
        <input type="submit" name="order_submit" value="Submit" class="left btn brand z-depth-0">
    </form>

    <br>
    <h5>Type in rental ID: </h5>
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for rental ID..." title="Type in rental ID">

    <table id="myTable">
        <tr class="header">
            <th style="width:10%;">Rental ID</th>
            <th style="width:20%;">Rental Date</th>
            <th style="width:10%;">Inventory ID</th>
            <th style="width:10%;">Customer ID</th>
            <th style="width:20%;">Return Date</th>
            <th style="width:10%;">Staff ID</th>
            <th style="width:20%;">Last Update</th>
        </tr>

        <?php
        require "config/connect.php";

        $query = "SELECT * FROM rental";

        if (isset($_POST['order_list'])) {
            $query = "SELECT * FROM rental ORDER BY " . $_POST['order_list'] . ", rental_id";
        }

        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr><td>' . $row['rental_id'] . '</td><td>' . $row['rental_date'] . '</td><td>' .
                $row['inventory_id'] . '</td><td>' . $row['customer_id'] . '</td><td>' . $row['return_date'] . '</td><td>' .
                $row['staff_id'] . '</td><td>' . $row['last_update'] . "</td></tr>";
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
                td = tr[i].getElementsByTagName("td")[0];
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