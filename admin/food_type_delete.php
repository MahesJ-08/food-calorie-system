<?php 

session_start();

include("../database/db.php");

$food_id = $_GET["food_id"];

$sql = "delete from tbl_food_types where food_id = '$food_id'";

if(mysqli_query($conn, $sql))
{

    $sql1 = "delete from tbl_food_items where food_id = '$food_id'";

    mysqli_query($conn, $sql1);

    header("Location: food_type.php");
    exit();
}


?>