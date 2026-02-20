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


$history_sql = "select * from user_food_log inner join tbl_food_items on user_food_log.item_id = tbl_food_items.item_id where user_id = '$user_id' order BY consumed_date DESC";
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

                        <form action="user_action.php" id="calorieForm" method="post">

                            <input type="hidden" name="user_id" value="<?= $user_id ?>">

                            <div class=" row mb-3">
                                <div class="col">
                                    <label class="form-label fw-semibold">Food Type</label>
                                    <select name="food_id" id="foodID" class="form-select" required>
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
                                    <select name="item_id" id="itemSelect" class="form-select" required>
                                        <option value="">--- Select Food Item ---</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Unit (gm/ml/piece)</label>
                                <input type="number" name="quantity" id="quantityInput" class="form-control" min="1">
                                <small class="text-danger" id="unitError"></small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Total Calories</label>
                                <input type="number" id="calorieInput" class="form-control" name="total_calorie" readonly>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Date</label>
                                <input type="date" name="consumed_date" class="form-control" value="<?= date('Y-m-d'); ?>" readonly>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="add_intake" class="btn btn-success">
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
                                    <th>Unit(g/ml/p)</th>
                                    <th>Calories</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($history_result) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($history_result)): ?>
                                        <tr>
                                            <td><?= $row['food_item']; ?></td>
                                            <td><?= $row['quantity']; ?></td>
                                            <td><?= number_format($row['total_calories'], 2); ?> kcal</td>
                                            <td><?= $row['consumed_date']; ?></td>
                                            <td><a href="log_delete.php?id=<?= $row["id"] ?>" class="btn btn-outline-danger">Delete</a></td>
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
        document.getElementById("foodID").addEventListener("change", function() {
            let foodId = this.value;

            if (foodId === 0) {
                document.getElementById("itemSelect").innerHTML = "<option value=''>--- Select Food Item ---</option>";
                return;
            }

            fetch("get_food_items.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "food_id=" + foodId
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById("itemSelect").innerHTML = "<option value=''>-- Select Item --</option>" + data;
                });
        });

        const itemSelect = document.getElementById("itemSelect");
        const quantityInput = document.getElementById("quantityInput");
        const calorieInput = document.getElementById("calorieInput");

        function calculateCalories() {
            let selectedOption = itemSelect.options[itemSelect.selectedIndex];
            let unit = selectedOption.getAttribute("data-unit");
            let calories = selectedOption.getAttribute("data-calories");
            let quantity = quantityInput.value;

            if (calories && quantity && unit) {
                let totalCalories = (calories / unit) * quantity;
                calorieInput.value = totalCalories.toFixed(2);
            } else {
                calorieInput.value = "";
            }
        }

        itemSelect.addEventListener("change", calculateCalories);
        quantityInput.addEventListener("input", calculateCalories);


        document.getElementById("calorieForm").addEventListener("submit", function(e) {
            let quantity = document.getElementById("quantityInput").value.trim();

            document.getElementById("unitError").innerText = "";

            let check = true;

            if (quantity <= 0) {
                e.preventDefault();
                document.getElementById("unitError").innerText = "Please enter a number for unit.";
                check = false;
            }
            if (!check) {
                e.preventDefault();
            }
        });
    </script>

</body>

</html>