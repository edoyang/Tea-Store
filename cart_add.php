<?php
session_start();

include 'db_connect.php';

if (!isset($_SESSION['shopping_cart'])) {
    $_SESSION['shopping_cart'] = array();
}

if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        if (!isset($_SESSION['shopping_cart'][$product_id])) {
            $_SESSION['shopping_cart'][$product_id] = [
                'name' => $product['product_name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        } else {
            $_SESSION['shopping_cart'][$product_id]['quantity']++;
        }
        echo $_SESSION['shopping_cart'][$product_id]['quantity'];
    } else {
        echo "Product does not exist!";
    }
    $stmt->close();
} else {
    echo "Invalid product ID!";
}
?>
