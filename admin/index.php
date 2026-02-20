<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Calorie System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include("../bootstrap/cdn.html"); ?>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .image-section {
            background: url("../images/login.png") center center/cover no-repeat;
            position: relative;
            min-height: 300px;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0,0,0,0.6), rgba(0,0,0,0.3));
        }

        .content {
            position: relative;
            z-index: 2;
        }

        .login-card {
            border-radius: 20px;
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        @media (max-width: 991px) {
            .image-section {
                min-height: 250px;
            }
        }

        @media (max-width: 576px) {
            .image-section {
                min-height: 200px;
                text-align: center;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="fa-solid fa-house me-2"></i>Calorie System
        </a>
    </div>
</nav>

<div class="container-fluid px-0">
    <div class="row g-0 min-vh-100">

        <div class="col-12 col-md-5 col-lg-6 image-section d-flex align-items-center justify-content-center text-white text-center p-4">
            <div class="overlay"></div>
            <div class="content">
                <h1 class="fw-bold">Welcome Back!</h1>
                <p class="lead">
                    Login to continue tracking.
                </p>
            </div>
        </div>

        <div class="col-12 col-md-7 col-lg-6 d-flex align-items-center justify-content-center bg-light p-4">
            <div class="card login-card p-4 p-md-5 w-100" style="max-width:450px;">

                <h3 class="text-center mb-4 fw-bold">Login</h3>

                <?php if(isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> text-center">
                        <?php
                        echo $_SESSION['message'];
                        $type = $_SESSION['msg_type'];
                        unset($_SESSION['message']);
                        unset($_SESSION['msg_type']);
                        ?>
                    </div>

                    <?php if($type == "success"): ?>
                        <script>
                            setTimeout(function(){
                                window.location.href = "home.php";
                            }, 1500);
                        </script>
                    <?php endif; ?>

                <?php endif; ?>

                <form id="loginForm" action="admin_action.php" method="post">

                    <div class="mb-3">
                        <input type="text" id="username" name="username"
                               class="form-control form-control-lg"
                               placeholder="Username">
                        <small class="text-danger" id="UsernameError"></small>
                    </div>

                    <div class="mb-4">
                        <input type="password" id="password" name="password"
                               class="form-control form-control-lg"
                               placeholder="Password">
                        <small class="text-danger" id="passwordError"></small>
                    </div>

                    <div class="d-grid">
                        <button type="submit" name="login"
                                class="btn btn-primary btn-lg rounded-pill">
                            Login
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<script>
document.getElementById("loginForm").addEventListener("submit", function(e){

    let username = document.getElementById("username").value.trim();
    let password = document.getElementById("password").value.trim();

    let usernameRegex = /^[A-Za-z]+$/;
    let valid = true;

    document.getElementById("usernameError").innerText = "";
    document.getElementById("passwordError").innerText = "";

    if(email === ""){
        document.getElementById("usernameError").innerText = "Username is required";
        valid = false;
    }
    else if(!usernameRegex.test(username)){
        document.getElementById("usernameError").innerText = "Enter valid Username";
        valid = false;
    }

    if(password === ""){
        document.getElementById("passwordError").innerText = "Password is required";
        valid = false;
    }

    if(!valid){
        e.preventDefault();
    }
});
</script>

</body>
</html>
