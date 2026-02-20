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
                FROM user_food_log 
                WHERE user_id = '$user_id' 
                AND consumed_date = '$current_date'";

$calorie_result = mysqli_query($conn, $calorie_sql);
$calorie_row = mysqli_fetch_assoc($calorie_result);

$total_calorie = $calorie_row['cc'] ?? 0;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('../bootstrap/cdn.html'); ?>

    <style>
        body {
            background: linear-gradient(135deg, #e9f5ec, #f8f9fa);
            min-height: 100vh;
        }

        .dashboard-card {
            border-radius: 20px;
            transition: 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 40px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <?php include("header.php"); ?>

    <div class="container py-5">

        <div class="row justify-content-center g-4">
            <div class="col-lg-5 col-md-6">
                <div class="card dashboard-card shadow border-0 p-4 text-center">
                    <h5 class="text-muted mb-3">Today's Calories</h5>

                    <div class="stat-number text-success">
                        <?= number_format($total_calorie, 2); ?> kcal
                    </div>

                    <p class="mt-2 text-muted">
                        Daily Limit: <?= $set_limit; ?> kcal
                    </p>

                    <?php
                    $percentage = 0;
                    if ($set_limit > 0) {
                        $percentage = ($total_calorie / $set_limit) * 100;
                        if ($percentage > 100) {
                            $percentage = 100;
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="col-lg-5 col-md-6">
                <div class="card dashboard-card shadow border-0 p-4 text-center">

                    <h5 class="text-muted mb-3">Remaining Calories</h5>

                    <?php
                    $remaining = $set_limit - $total_calorie;
                    ?>

                    <div class="stat-number 
                    <?= ($remaining < 0) ? 'text-danger' : 'text-primary'; ?>">
                        <?= number_format($remaining, 2); ?> kcal
                    </div>

                    <?php if ($remaining < 0): ?>
                        <p class="text-danger fw-semibold mt-2">
                            You have exceeded your limit!
                        </p>
                    <?php else: ?>
                        <p class="text-muted mt-2">
                            You are within your daily target.
                        </p>
                    <?php endif; ?>

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