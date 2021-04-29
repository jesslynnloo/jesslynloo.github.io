<?php
require "login.php";

$conn = mysqli_connect('localhost:3306', $USERNAME, $PASSWORD, $DATABASE_NAME);

if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
}
