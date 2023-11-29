<?php
session_start();
include 'db_connect.php'; // Ensure this is the correct path to your db_connect file

if (isset($_POST['product_ids']) && isset($_POST['quantities'])) {
    $product_ids = $_POST['product_ids'];
    $quantities = $_POST['quantities'];

    // Example: Insert each product as a separate order entry
    foreach ($product_ids as $index => $product_id) {
        $quantity = $quantities[$index];
        // Insert order into Order table logic goes here
        // Example: INSERT INTO Orders (product_id, quantity) VALUES (?, ?)
    }

    $_SESSION['shopping_cart'] = array();

    echo "Order placed successfully!";
    echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 3000);</script>";
} else {
    echo "No products to order!";
}
?>
