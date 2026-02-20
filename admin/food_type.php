<?php

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header("Location: index.php");
    exit();
}

include("../database/db.php");


$edit_mode = false;
$food_type = "";
$food_id = "";

if (isset($_GET['food_id'])) {

    $edit_mode = true;
    $food_id = $_GET['food_id'];

    $edit_sql = "SELECT * FROM tbl_food_types WHERE food_id = '$food_id'";
    $edit_result = mysqli_query($conn, $edit_sql);
    $edit_row = mysqli_fetch_assoc($edit_result);

    $food_type = $edit_row['food_type'];

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calorie System</title>

    <?php include('../bootstrap/cdn.html'); ?>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .card-header {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn {
            border-radius: 8px;
        }

        table th {
            font-weight: 600;
        }
    </style>

</head>

<body>
    <?php include("admin_header.php"); ?>

    <div class="container py-5">

        <div class="text-center mb-4">
            <h3 class="fw-bold">Food Calorie Management</h3>
            <p class="text-muted mb-0">Add and manage your food</p>
        </div>

        <div class="row g-4">

            <div class="col-lg-4 col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        Food Item
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['message'])): ?>
                            <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> text-center">
                                <?php
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                                unset($_SESSION['msg_type']);
                                ?>
                                <script>
                                    setTimeout(function() {
                                        window.location.href = "food_type.php";
                                    }, 3000);
                                </script>
                            </div>
                        <?php endif; ?>

                        <form action="admin_action.php" method="post" id="addFood">

                            <?php if ($edit_mode): ?>
                                <input type="hidden" name="food_id" value="<?= $food_id ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">Food Type</label>
                                <input type="text" class="form-control" id="foodtype" name="foodtype" value="<?= $food_type ?>" placeholder="Enter food type">
                                <small class="text-danger" id="foodtypeError"></small>
                            </div>

                            <div class="d-grid">
                                <?php if ($edit_mode): ?>
                                    <button type="submit" name="update_food" class="btn btn-warning">
                                        Update
                                    </button>
                                <?php else: ?>
                                    <button type="submit" name="add_food" class="btn btn-primary">
                                        Submit
                                    </button>
                                <?php endif; ?>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white text-center">
                        Food Type List
                    </div>
                    <div class="card-body p-0">
                        <div style="max-height: 320px; overflow-y: auto;">

                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Food Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql1 = "select * from tbl_food_types";
                                $result1 = mysqli_query($conn, $sql1);
                                if (mysqli_num_rows($result1) > 0) {
                                    $i = 1;
                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $row1["food_type"] ?></td>
                                            <td>
                                                <a href="food_type.php?food_id=<?= $row1["food_id"] ?>" class="btn btn-sm btn-outline-info m-1">Edit</a>
                                                <a href="food_type_delete.php?food_id=<?= $row1["food_id"] ?>" class="btn btn-sm btn-outline-danger m-1">Delete</a>
                                            </td>
                                        </tr>
                                <?php
                                    $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


    <script>
        document.getElementById("addFood").addEventListener("submit", function(e) {
            let food_type = document.getElementById("foodtype").value.trim();

            let foodtypeRegex = /^[A-Za-z\s]+$/;

            let valid = true;

            document.getElementById("foodtypeError").innerText = "";

            if (food_type === "") {
                document.getElementById("foodtypeError").innerText = "Food Type required";
                valid = false;
            } else if (!foodtypeRegex.test(food_type)) {
                document.getElementById("foodtypeError").innerText = "Alphabetic characters only";
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
            }

        });
    </script>
</body>

</html>