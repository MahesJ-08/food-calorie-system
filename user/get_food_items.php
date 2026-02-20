<?php

include("../database/db.php");

if (isset($_POST['food_id'])) {
    $food_id = $_POST['food_id'];

    $sql = "SELECT * FROM tbl_food_items WHERE food_id = '$food_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['item_id']}'
            data-unit='{$row['unit']}'
            data-calories='{$row['calories_per_unit']}'>
            {$row['food_item']}
            </option>";
        }
    } else {
        echo "<option value=''>No food items found</option>";
    }
}

