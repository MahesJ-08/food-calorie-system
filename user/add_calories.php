<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include("../database/db.php");

$user_id = $_SESSION['user_id'];

$type_sql = "select * from tbl_food_types";
$type_result = mysqli_query($conn, $type_sql);


$history_sql = "select * from tbl_calorie where user_id = '$user_id' order BY consumed_date DESC";
$history_result = mysqli_query($conn, $history_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Calories</title>

    <?php include('../bootstrap/cdn.html'); ?>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 15px;
        }
    </style>
</head>

<body>

    <?php include("header.php"); ?>

    <div class="container py-5">
        <div class="row g-4">

            <div class="col-lg-5">
                <div class="card shadow border-0">
                    <div class="card-header bg-success text-white text-center">
                        <h5 class="mb-0">Add Food Intake</h5>
                    </div>
                    <div class="card-body p-4">

                        <?php if (isset($_SESSION['message'])): ?>
                            <div class="alert alert-success text-center">
                                <?= $_SESSION['message']; ?>
                            </div>
                            <?php unset($_SESSION['message']); ?>
                            <script>
                                setTimeout(function() {
                                    window.location.href = "add_calories.php";
                                }, 2000);
                            </script>
                        <?php endif; ?>

                        <form action="user_action.php" method="post">

                            <input type="hidden" name="user_id" value="<?= $user_id ?>">

                            <div class=" row mb-3">
                                <div class="col">
                                    <label class="form-label fw-semibold">Food Type</label>
                                    <select name="food_id" id="foodSelect" class="form-select" required>
                                        <option value="">-- Select Food --</option>
                                        <?php while ($row = mysqli_fetch_assoc($type_result)): ?>
                                            <option value="<?= $row['food_id']; ?>">
                                                <?= $row['food_type']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label fw-semibold">Food Item</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Quantity (grams)</label>
                                <input type="number"
                                    name="quantity"
                                    id="quantityInput"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Total Calories</label>
                                <input type="number"
                                    id="calorieInput"
                                    class="form-control"
                                    readonly>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Date</label>
                                <input type="date"
                                    name="consumed_date"
                                    class="form-control"
                                    value="<?= date('Y-m-d'); ?>"
                                    readonly>
                            </div>

                            <div class="d-grid">
                                <button type="submit"
                                    name="add_intake"
                                    class="btn btn-success">
                                    Save Intake
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow border-0">
                    <div class="card-header bg-dark text-white text-center">
                        <h5 class="mb-0">Food Intake History</h5>
                    </div>
                    <div class="card-body table-responsive">

                        <table class="table table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Food</th>
                                    <th>Quantity</th>
                                    <th>Calories</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($history_result) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($history_result)): ?>
                                        <tr>
                                            <td><?= $row['food_taken']; ?></td>
                                            <td><?= $row['quantity_taken']; ?> g</td>
                                            <td><?= number_format($row['total_calories'], 2); ?> kcal</td>
                                            <td><?= $row['consumed_date']; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-muted">
                                            No Intake Records Found
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById("quantityInput").addEventListener("input", calculateCalories);
        document.getElementById("foodSelect").addEventListener("change", calculateCalories);

        function calculateCalories() {

            let foodSelect = document.getElementById("foodSelect");
            let quantityInput = document.getElementById("quantityInput").value;
            let calorieInput = document.getElementById("calorieInput");

            let selectedOption = foodSelect.options[foodSelect.selectedIndex];

            if (!selectedOption || quantityInput === "") {
                calorieInput.value = "";
                return;
            }

            let baseQuantity = selectedOption.getAttribute("data-quantity");
            let baseCalories = selectedOption.getAttribute("data-calories");

            if (baseQuantity && baseCalories) {

                let calculatedCalories = (quantityInput / baseQuantity) * baseCalories;

                calorieInput.value = calculatedCalories.toFixed(2);
            }
        }
    </script>

</body>

</html>