<?php

include("../database/db.php");

if (isset($_GET['id'])) {
    $log_id = $_GET['id'];

    $delete_sql = "DELETE FROM user_food_log WHERE id = '$log_id'";
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: add_calories.php");
        exit();
    } else {
        echo "Error deleting log: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}