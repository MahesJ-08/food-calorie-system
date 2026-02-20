<?php

session_start();

include("../database/db.php");

if (isset($_POST["login"])) 
{
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql1 = "select * from tbl_admin where username = '$username' and password = '$password'";
    $result = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['message'] = "Login Successful! ";
        $_SESSION['msg_type'] = "success";

        header("Location: index.php");
        exit();
    } else {
        $_SESSION['message'] = "Invalid email or password! ";
        $_SESSION['msg_type'] = "danger";

        header("Location: index.php");
        exit();
    }
}

if (isset($_POST["add_food"])) 
{
    $food_type = $_POST["foodtype"];

    $add_sql = "insert into tbl_food_types(food_type) values('$food_type')";
    if(mysqli_query($conn, $add_sql))
    {
        $_SESSION['message'] = "Food Type Added Successful! ";
        $_SESSION['msg_type'] = "success";
    }
    else
    {
        $_SESSION['message'] = "Error to add! ";
        $_SESSION['msg_type'] = "danger";
    }
    
    header("Location: food_type.php");
    exit();
}

if (isset($_POST["update_food"])) 
{
    $food_id = $_POST["food_id"];
    $food_type = $_POST["food_type"];

    $edit_sql = "update tbl_food_types set food_type = '$food_type' where food_id = '$food_id')";
    if(mysqli_query($conn, $edit_sql))
    {
        $_SESSION['message'] = "Food Type Updated Successful! ";
        $_SESSION['msg_type'] = "success";
    }
    else
    {
        $_SESSION['message'] = "Error to Update! ";
        $_SESSION['msg_type'] = "danger";
    }
    
    header("Location: food_type.php");
    exit();
}

if (isset($_POST["add_item"])) 
{
    $food_id = $_POST["food_id"];
    $food_item = $_POST["fooditem"];
    $unit = $_POST["unit"];
    $Kcal = $_POST["kcal"];

    $addItem_sql = "insert into tbl_food_items(food_id,food_item,unit,calories_per_unit) values('$food_id','$food_item','$unit','$Kcal')";
    if(mysqli_query($conn, $addItem_sql))
    {
        $_SESSION['message'] = "Food Item Added Successful! ";
        $_SESSION['msg_type'] = "success";
    }
    else
    {
        $_SESSION['message'] = "Error to add items! ";
        $_SESSION['msg_type'] = "danger";
    }
    
    header("Location: food_item.php");
    exit();
}

if (isset($_POST["update_item"])) 
{
    $item_id = $_POST["item_id"];
    $food_id = $_POST["food_id"];
    $food_item = $_POST["fooditem"];
    $unit = $_POST["unit"];
    $kcal = $_POST["kcal"];

    $edit_sql = "update tbl_food_items set food_id = '$food_id',food_item = '$food_item',unit = '$unit',calories_per_unit = '$kcal' where item_id = '$item_id'";
    if(mysqli_query($conn, $edit_sql))
    {
        $_SESSION['message'] = "Food Item Updated Successful! ";
        $_SESSION['msg_type'] = "success";
    }
    else
    {
        $_SESSION['message'] = "Error to Update!".mysqli_error($conn);
        $_SESSION['msg_type'] = "danger";
    }
    
    header("Location: food_item.php");
    exit();
}
