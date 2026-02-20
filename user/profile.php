<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include("../database/db.php");

$user_id = $_SESSION['user_id'];
$user_sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
$user_result = mysqli_query($conn, $user_sql);
$user_row = mysqli_fetch_assoc($user_result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile - Calorie System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('../bootstrap/cdn.html'); ?>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f8f9fa;
        }

        .profile-card {
            max-width: 500px;
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 40px;
            background: #ffffff;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-modern {
            border-radius: 25px;
        }
    </style>
</head>

<body>

    <?php include("header.php"); ?>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">

        <div class="profile-card">

            <h4 class="mb-4 fw-bold text-center">Update Profile</h4>

            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> text-center">
                    <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    unset($_SESSION['msg_type']);
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location.href = "profile.php";
                        }, 2000);
                    </script>
                </div>
            <?php endif; ?>

            <form id="updateForm" action="user_action.php" method="post">

                <input type="hidden" name="user_id" value="<?= $user_row["user_id"]; ?>">
                <input type="hidden" name="oldpwd" id="oldpwd" value="<?= $user_row["password"]; ?>">

                <div class="mb-3">
                    <input type="text" id="username" name="name" class="form-control" placeholder="Username" value="<?= $user_row["name"]; ?>">
                    <small class="text-danger" id="usernameError"></small>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" value="<?= $user_row["email"]; ?>" readonly>
                </div>

                <div class="mb-3">
                    <input type="password" id="password" name="password" class="form-control" placeholder="New Password (optional)">
                    <small class="text-danger" id="passwordError"></small>
                </div>

                <div class="mb-4">
                    <input type="number" id="calorie" name="calorie" class="form-control" placeholder="Daily Calorie Limit" value="<?= $user_row["daily_calorie_limit"]; ?>">
                    <small class="text-danger" id="calorieError"></small>
                </div>

                <div class="d-grid">
                    <button type="submit" name="update" class="btn btn-primary btn-modern">
                        Update Profile
                    </button>
                </div>

            </form>

        </div>

    </div>

    <script>
        document.getElementById("updateForm").addEventListener("submit", function(e) {

            let username = document.getElementById("username").value.trim();
            let password = document.getElementById("password").value.trim();
            let oldpwd = document.getElementById("oldpwd").value.trim();
            let calorie = document.getElementById("calorie").value.trim();

            let usernameRegex = /^[A-Za-z]+$/;
            let calorieRegex = /^[1-9][0-9]*$/;

            let valid = true;

            document.getElementById("usernameError").innerText = "";
            document.getElementById("passwordError").innerText = "";
            document.getElementById("calorieError").innerText = "";

            if (username === "") {
                document.getElementById("usernameError").innerText = "Username is required";
                valid = false;
            } else if (!usernameRegex.test(username)) {
                document.getElementById("usernameError").innerText = "Alphabetic characters only";
                valid = false;
            }

            if (password !== "" && password === oldpwd) {
                document.getElementById("passwordError").innerText =
                    "New password cannot be same as old password";
                valid = false;
            }

            if (!calorieRegex.test(calorie)) {
                document.getElementById("calorieError").innerText = "Enter valid number";
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
            }

        });
    </script>

</body>

</html>