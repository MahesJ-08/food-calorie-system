<?php

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header("Location: index.php");
    exit();
}

include("../database/db.php");

$type_sql = "select * from tbl_food_types";
$type_result = mysqli_query($conn, $type_sql);

$edit_mode = false;
$food_id = "";
$food_type = "";
$food_item = "";
$unit = "";
$kcal = "";


if (isset($_GET['item_id'])) {

    $edit_mode = true;
    $item_id = $_GET['item_id'];

    $edit_sql = "SELECT * FROM tbl_food_items WHERE item_id = '$item_id'";
    $edit_result = mysqli_query($conn, $edit_sql);

    if ($edit_result && mysqli_num_rows($edit_result) > 0) {
        $edit_row = mysqli_fetch_assoc($edit_result);

        $food_id   = $edit_row['food_id'];
        $food_item = $edit_row['food_item'];
        $unit      = $edit_row['unit'];
        $kcal      = $edit_row['calories_per_unit'];
    } else {
        $edit_mode = false;
    }
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
                                        window.location.href = "food_item.php";
                                    }, 1500);
                                </script>
                            </div>
                        <?php endif; ?>

                        <form action="admin_action.php" method="post" id="addItems">

                            <?php if ($edit_mode): ?>
                                <input type="hidden" name="item_id" value="<?= $item_id ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Food Type</label>
                                <select name="food_id" id="foodSelect" class="form-select" required>
                                    <option value="">-- Select Food --</option>
                                    <?php while ($row = mysqli_fetch_assoc($type_result)): ?>
                                        <option value="<?= $row['food_id']; ?>"
                                        <?= ($row['food_id'] == $food_id) ? "selected" : "" ?>>
                                            <?= $row['food_type']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Food Items</label>
                                <input type="text" class="form-control" id="fooditem" name="fooditem"  value="<?= $food_item ?>" placeholder="Enter Food Items">
                                <small class="text-danger" id="fooditemsError"></small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Per Unit (g/ml/piece)</label>
                                <input type="text" class="form-control" id="unit" name="unit" value="<?= $unit ?>" placeholder="Enter Unit">
                                <small class="text-danger" id="unitError"></small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Calories Per Unit (Kcal)</label>
                                <input type="text" class="form-control" id="kcal" name="kcal" value="<?= $kcal ?>"  placeholder="Enter Calories Per Unit">
                                <small class="text-danger" id="unitError"></small>
                            </div>

                            <div class="d-grid">
                                <?php if ($edit_mode): ?>
                                    <button type="submit" name="update_item" class="btn btn-warning">
                                        Update
                                    </button>
                                <?php else: ?>
                                    <button type="submit" name="add_item" class="btn btn-primary">
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
                                    <th>Food Item</th>
                                    <th>Unit</th>
                                    <th>Calories Per Unit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql1 = "select * from tbl_food_items inner join tbl_food_types on tbl_food_items.food_id = tbl_food_types.food_id order by tbl_food_types.food_type asc";
                                $result1 = mysqli_query($conn, $sql1);
                                if (mysqli_num_rows($result1) > 0) {
                                    $i = 1;
                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $row1["food_type"] ?></td>
                                            <td><?= $row1["food_item"] ?></td>
                                            <td><?= $row1["unit"] ?></td>
                                            <td><?= $row1["calories_per_unit"] ?></td>
                                            <td>
                                                <a href="food_item.php?item_id=<?= $row1["item_id"] ?>" class="btn btn-sm btn-outline-info m-1">Edit</a>
                                                <a href="food_item_delete.php?item_id=<?= $row1["item_id"] ?>" class="btn btn-sm btn-outline-danger m-1">Delete</a>
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


</body>

</html>