<?php 

session_start();

include("../database/db.php");

$food_id = $_GET["food_id"];

$sql = "delete from tbl_food where food_id = '$food_id'";

if(mysqli_query($conn, $sql))
{
    header("Location: food.php");
    exit();
}


?>