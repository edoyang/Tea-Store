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
        
        // Update the session with the new product or increment its quantity
        if (!isset($_SESSION['shopping_cart'][$product_id])) {
            $_SESSION['shopping_cart'][$product_id] = [
                'name' => $product['product_name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        } else {
            $_SESSION['shopping_cart'][$product_id]['quantity']++;
        }
        
        // Now generate the cart output
        ob_start(); // Start output buffer
        foreach ($_SESSION['shopping_cart'] as $id => $details) {
            echo "<li id='cart-item-{$id}'>";
            echo htmlspecialchars($details['name']) . " - Quantity: " . $details['quantity'];
            // Add a remove button or any other elements you need
            echo "</li>";
        }
        $cartContents = ob_get_clean(); // Get the buffer content
        echo $cartContents; // Output the cart contents
    } else {
        echo "Product does not exist!";
    }
    $stmt->close();
} else {
    echo "Invalid product ID!";
}
?>
