<?php
session_start();
include 'db_connect.php';

if (isset($_POST['product_ids']) && isset($_POST['quantities'])) {
    $product_ids = $_POST['product_ids'];
    $quantities = $_POST['quantities'];
    $user_id = $_SESSION['user_id'];
    $total_price = 0;

    // Begin transaction
    $conn->begin_transaction();

    // Prepare statements for later use
    $price_stmt = $conn->prepare("SELECT price, stocks FROM products WHERE product_id = ?");
    $update_stock_stmt = $conn->prepare("UPDATE products SET stocks = stocks - ? WHERE product_id = ?");

    // Calculate total price and update stock
    foreach ($product_ids as $index => $product_id) {
        $quantity = $quantities[$index];

        // Fetch product price and stock
        $price_stmt->bind_param("i", $product_id);
        $price_stmt->execute();
        $result = $price_stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $total_price += $row['price'] * $quantity;

            // Check if enough stock is available
            if ($row['stocks'] < $quantity) {
                echo "Not enough stock for product ID $product_id.";
                $conn->rollback();
                exit;
            }

            // Update stock
            $update_stock_stmt->bind_param("ii", $quantity, $product_id);
            $update_stock_stmt->execute();
        }
    }

    // Insert into orders table
    $order_stmt = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
    $order_stmt->bind_param("id", $user_id, $total_price);
    $order_stmt->execute();
    $order_id = $conn->insert_id;

    // Insert into order_details table
    $details_stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, product_name, quantity) VALUES (?, ?, ?, ?)");
    foreach ($product_ids as $index => $product_id) {
        $quantity = $quantities[$index];
        $product_name = ''; // Fetch product name as before

        $details_stmt->bind_param("iisi", $order_id, $product_id, $product_name, $quantity);
        $details_stmt->execute();
    }

    // Commit transaction
    $conn->commit();

    $_SESSION['shopping_cart'] = array();

    echo "Order placed successfully!";
    echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 3000);</script>";
} else {
    echo "No products to order!";
}
?>
