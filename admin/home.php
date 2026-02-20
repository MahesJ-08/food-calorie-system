<?php
session_start();

if(!isset($_SESSION["admin_id"]))
{
    header("Location: index.php");
    exit();
}

include("../database/db.php");

/* ================== FOOD TYPES COUNT ================== */
$food_sql = "SELECT COUNT(food_id) AS ftc FROM tbl_food_types";
$food_result = mysqli_query($conn, $food_sql);
$food_row = mysqli_fetch_assoc($food_result);
$food_count = $food_row['ftc'] ?? 0;

/* ================== FOOD ITEMS COUNT ================== */
$item_sql = "SELECT COUNT(item_id) AS ftc FROM tbl_food_items";
$item_result = mysqli_query($conn, $item_sql);
$item_row = mysqli_fetch_assoc($item_result);
$item_count = $item_row['ftc'] ?? 0;

/* ================== USERS COUNT ================== */
$user_sql = "SELECT COUNT(user_id) AS uc FROM tbl_user";
$user_result = mysqli_query($conn, $user_sql);
$user_row = mysqli_fetch_assoc($user_result);
$user_count = $user_row['uc'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('../bootstrap/cdn.html'); ?>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .dashboard-title {
            font-weight: 700;
            font-size: 30px;
            margin-bottom: 40px;
        }

        .dashboard-card {
            border-radius: 20px;
            transition: all 0.3s ease-in-out;
            position: relative;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 42px;
            font-weight: bold;
            margin-top: 10px;
        }

        .card-icon {
            font-size: 50px;
            opacity: 0.15;
            position: absolute;
            right: 20px;
            bottom: 15px;
        }

        .card-description {
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>

<body>

    <!-- Navbar (Not Changed) -->
    <?php include("admin_header.php"); ?>

    <div class="container py-5">

        <div class="text-center dashboard-title">
            Admin Dashboard Overview
        </div>

        <div class="row g-4">

            <!-- Food Types -->
            <div class="col-lg-4 col-md-6">
                <div class="card dashboard-card shadow border-0 p-4 bg-white">
                    <h6 class="text-muted">Total Food Types</h6>
                    <div class="stat-number text-success">
                        <?= $food_count; ?>
                    </div>
                    <div class="card-description">
                        Number of food categories available
                    </div>
                    <i class="bi bi-grid-fill text-success card-icon"></i>
                </div>
            </div>

            <!-- Food Items -->
            <div class="col-lg-4 col-md-6">
                <div class="card dashboard-card shadow border-0 p-4 bg-white">
                    <h6 class="text-muted">Total Food Items</h6>
                    <div class="stat-number text-warning">
                        <?= $item_count; ?>
                    </div>
                    <div class="card-description">
                        Total items added in system
                    </div>
                    <i class="bi bi-basket-fill text-warning card-icon"></i>
                </div>
            </div>

            <!-- Users -->
            <div class="col-lg-4 col-md-6">
                <div class="card dashboard-card shadow border-0 p-4 bg-white">
                    <h6 class="text-muted">Total Registered Users</h6>
                    <div class="stat-number text-primary">
                        <?= $user_count; ?>
                    </div>
                    <div class="card-description">
                        Users registered in the platform
                    </div>
                    <i class="bi bi-people-fill text-primary card-icon"></i>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
