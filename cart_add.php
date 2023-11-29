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
        
        // Now generate the cart output
        ob_start(); // Start output buffer
        foreach ($_SESSION['shopping_cart'] as $id => $details) {
            echo "<div class='cart-item' id='cart-item-{$id}'>";
            echo "<p>" . $details['name'] . " x" . $details['quantity'] . "</p>";
            echo "<button onclick='removeFromCart({$id})' style='background-color: #f44336; color: white; border: none; padding: 5px; cursor: pointer;'>Remove</button>";
            echo "</div>";
        }
        $cartContents = ob_get_clean();
        echo $cartContents;
    } else {
        echo "Product does not exist!";
    }
    $stmt->close();
} else {
    echo "Invalid product ID!";
}
?>

<script>
    function removeFromCart(productId) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'cart_remove.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            document.getElementById("cart-item-" + productId).remove();
            document.getElementById("cart-counter").textContent = xhr.responseText;
        }
    };
    xhr.send('product_id=' + productId);
}
</script>