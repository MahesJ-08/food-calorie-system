<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include("../database/db.php");

$user_id = $_SESSION['user_id'];

$limit_sql = "SELECT daily_calorie_limit FROM tbl_user WHERE user_id = '$user_id'";
$limit_result = mysqli_query($conn, $limit_sql);
$limit_row = mysqli_fetch_assoc($limit_result);

$set_limit = $limit_row['daily_calorie_limit'] ?? 0;

$current_date = date('Y-m-d');

$calorie_sql = "SELECT SUM(total_calories) AS cc 
                FROM tbl_calorie 
                WHERE user_id = '$user_id' 
                AND consumed_date = '$current_date'";

$calorie_result = mysqli_query($conn, $calorie_sql);
$calorie_row = mysqli_fetch_assoc($calorie_result);

$total_calorie = $calorie_row['cc'] ?? 0;

$food_sql = "SELECT COUNT(food_id) AS fc 
             FROM tbl_food 
             WHERE user_id = '$user_id'";

$food_result = mysqli_query($conn, $food_sql);
$food_row = mysqli_fetch_assoc($food_result);

$food_count = $food_row['fc'] ?? 0;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <?php include('../bootstrap/cdn.html'); ?>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .dashboard-card {
            border-radius: 20px;
            transition: 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
        }

        .progress {
            height: 20px;
            border-radius: 20px;
        }

        .progress-bar {
            font-weight: 600;
        }
    </style>

</head>

<body>

    <?php include("header.php"); ?>

    <div class="container py-5">

        <div class="row g-4">

            <div class="col-lg-6 col-md-12">
                <div class="card dashboard-card shadow border-0 p-4">
                    <h5 class="text-muted">Today's Calories</h5>
                    <div class="stat-number text-success">
                        <?= number_format($total_calorie, 2); ?> kcal
                    </div>

                    <small class="text-muted">
                        Daily Limit: <?= $set_limit; ?> kcal
                    </small>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card dashboard-card shadow border-0 p-4">
                    <h5 class="text-muted">Total Foods Added</h5>
                    <div class="stat-number text-primary">
                        <?= $food_count; ?>
                    </div>
                    <small class="text-muted">
                        Foods in your list
                    </small>
                </div>
            </div>

        </div>

    </div>

    <div class="modal fade" id="limitModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">⚠ Daily Limit Exceeded</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <h5>You have exceeded your daily calorie limit!</h5>
                    <p class="mb-0">
                        Limit: <?= $set_limit; ?> kcal <br>
                        Consumed: <?= number_format($total_calorie, 2); ?> kcal
                    </p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Okay
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($total_calorie > $set_limit && $set_limit > 0): ?>
                var myModal = new bootstrap.Modal(document.getElementById('limitModal'));
                myModal.show();
            <?php endif; ?>
        });
    </script>

</body>

</html>