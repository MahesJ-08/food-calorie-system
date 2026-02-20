<?php 
session_start();

include("../database/db.php");

if(isset($_POST["update"]))
    {
        $user_id = $_POST["user_id"];
        $name = $_POST["name"];
        $password = $_POST["password"];
        $oldpwd = $_POST["oldpwd"];
        $calorie = $_POST["calorie"];

        if(empty($password))
        {
            $pwd = $oldpwd;
        }
        else
        {
            $pwd = $password;   
        }

        $sql = "update tbl_user set name = '$name',password = '$pwd',daily_calorie_limit = '$calorie' where user_id = '$user_id'";
        if(mysqli_query($conn, $sql))
        {
            $_SESSION['message'] = "Update Successful! ";
            $_SESSION['msg_type'] = "success";   
        }
        else
        {
            $_SESSION['message'] = "Error to Update! ";
            $_SESSION['msg_type'] = "danger";
        }
        
        header("Location: profile.php");
        exit();
    }


    if(isset($_POST["add_food"]))
    {
        $user_id = $_POST["user_id"];
        $foodname = $_POST["foodname"];
        $quantity = $_POST["quantity"];
        $calorie = $_POST["calorie"];

        $sql = "insert into tbl_food(user_id,food_name,quantity,calories) values('$user_id','$foodname','$quantity','$calorie')";

        if(mysqli_query($conn, $sql))
        {
            $_SESSION['message'] = "Food Added Successful! ";
            $_SESSION['msg_type'] = "success";
        }
        else
        {
            $_SESSION['message'] = "Error to add food! ";
            $_SESSION['msg_type'] = "danger";
        }

        header("Location: food.php");
        exit();

    }

    if (isset($_POST['update_food'])) 
    {
        $food_id = $_POST['food_id'];
        $food_name = $_POST['foodname'];
        $quantity = $_POST['quantity'];
        $calories = $_POST['calorie'];

        $update = "update tbl_food set food_name='$food_name',quantity='$quantity',calories='$calories' where food_id='$food_id'";

        if(mysqli_query($conn, $update))
        {
            $_SESSION['message'] = "Food Updated Successfully!";
            $_SESSION['msg_type'] = "warning"; 
        }
        else
        {
            $_SESSION['message'] = "Error to Updated!";
            $_SESSION['msg_type'] = "danger";
        }
        
        header("Location: food.php");
        exit();
    }

    if (isset($_POST['add_intake'])) 
    {
        $user_id = $_POST["user_id"];
        $food_id = $_POST['food_id'];
        $quantity_taken = $_POST['quantity'];
        $consumed_date = $_POST['consumed_date'];

        // Fetch food details
        $food_query = "SELECT food_name, quantity, calories 
                    FROM tbl_food 
                    WHERE food_id = '$food_id' 
                    AND user_id = '$user_id'";

        $food_result = mysqli_query($conn, $food_query);
        $food_row = mysqli_fetch_assoc($food_result);

        if ($food_row) {

            $food_taken = $food_row['food_name'];
            $base_quantity = $food_row['quantity'];
            $base_calories = $food_row['calories'];

            if ($base_quantity > 0) {
                $total_calories = ($quantity_taken / $base_quantity) * $base_calories;
            } else {
                $total_calories = 0;
            }

            $insert = "INSERT INTO tbl_calorie 
                    (user_id, food_id, food_taken, quantity_taken, total_calories, consumed_date)
                    VALUES 
                    ('$user_id', '$food_id', '$food_taken', '$quantity_taken', '$total_calories', '$consumed_date')";

            if (mysqli_query($conn, $insert)) {
                $_SESSION['message'] = "Food Intake Added Successfully!";
                header("Location: add_calories.php");
                exit();
            } else {
                die("Insert Error: " . mysqli_error($conn));
            }
        }
    }

?>