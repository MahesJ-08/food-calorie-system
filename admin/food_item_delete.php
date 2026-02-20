<?php 

session_start();

include("../database/db.php");

$item_id = $_GET["item_id"];

$sql = "delete from tbl_food_items where item_id = '$item_id'";

if(mysqli_query($conn, $sql))
{
    header("Location: food_item.php");
    exit();
}


?>