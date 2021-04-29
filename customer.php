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

    <h2 class="center"><b>Customer</b></h2>

    <form action="read.php" method="POST">
        <input type="hidden" name="id" value="">
        <input type="submit" name="back" value="Go to view table page" class="left btn brand z-depth-0">

    </form>

    <form action="customer.php" method="POST">
        <label for="order">Order by:</label>
        <select name="order_list" id="order_list" class="myselect">
            <option value="customer_id">Customer ID</option>
            <option value="store_id">Store ID</option>
            <option value="first_name">First Name</option>
            <option value="last_name">Last Name</option>
            <option value="address_id">Address ID</option>
            <option value="last_update">Last Update</option>
        </select>
        <br><br>
        <input type="submit" name="order_submit" value="Submit" class="left btn brand z-depth-0">
    </form>

    <br>
    <h5>Type in customer's first name: </h5>
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for customer..." title="Type in customer's first name">

    <table id="myTable">
        <tr class="header">
            <th style="width:12%;">Customer ID</th>
            <th style="width:10%;">Store ID</th>
            <th style="width:24%;">First Name</th>
            <th style="width:24%;">Last Name</th>
            <th style="width:11%;">Address ID</th>
            <th style="width:20%;">Last Update</th>
        </tr>

        <?php
        require "config/connect.php";

        $query = "SELECT * FROM customer";

        if (isset($_POST['order_list'])){
            $query = "SELECT * FROM customer ORDER BY " . $_POST['order_list'] . ", customer_id";   
        }

        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr><td>' . $row['customer_id'] . '</td><td>' . $row['store_id'] . '</td><td>' .
                $row['first_name'] . '</td><td>' . $row['last_name'] . '</td><td>' . $row['address_id'] . '</td><td>' .
                $row['last_update'] . "</td></tr>";
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
                td = tr[i].getElementsByTagName("td")[2];
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