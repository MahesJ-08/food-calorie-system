<?php
session_start();
include("database/db.php");

if(isset($_POST["register"]))
    {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $sql1 = "select * from tbl_user where email = '$email'";
        $result = mysqli_query($conn, $sql1);
        if(mysqli_num_rows($result) > 0)
        {
            $_SESSION['message'] = "Email already exists!";
            $_SESSION['msg_type'] = "danger";
            $_SESSION["redirect"] = '';

            header("Location: register.php");
            exit();
        }
        else
        {
            $sql = "insert into tbl_user(name,email,password) values('$name','$email','$password')";

            if(mysqli_query($conn, $sql))
            {
                $_SESSION['message'] = "Registration Successful! ";
                $_SESSION['msg_type'] = "success";
                $_SESSION["redirect"] = '<a href="login.php">Login</a>';
            }
            else
            {
                $_SESSION['message'] = "Something went wrong!";
                $_SESSION['msg_type'] = "warning";
                $_SESSION["redirect"] = '';

            }
            header("Location: register.php");
            exit();
        }
    }

if(isset($_POST["login"]))
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        $sql1 = "select * from tbl_user where email = '$email' and password = '$password'";
        $result = mysqli_query($conn, $sql1);
        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['message'] = "Login Successful! ";
            $_SESSION['msg_type'] = "success";

            header("Location: login.php");
            exit();
        }
        else
        {
            $_SESSION['message'] = "Invalid email or password! ";
            $_SESSION['msg_type'] = "danger";

            header("Location: login.php");
            exit();   
        }
    }

?>