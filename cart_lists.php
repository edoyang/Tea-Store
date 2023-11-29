<style>
    .cart-list {
    position: fixed;
    bottom: 10px;
    right: 10px;
    width: 300px;
    background: #FFF;
    border: 1px solid #000;
    padding: 10px;
    box-shadow: 0px 0px 5px rgba(0,0,0,0.2);
    z-index: 1000;
}

.cart-list h3 img {
    width: 24px;
    vertical-align: middle;
}

.close-cart {
    position: absolute;
    top: 5px;
    right: 5px;
}

.btn-danger {
    /* Add styles for your 'btn-danger' class here if needed */
}

.btn-primary {
    /* Add styles for your 'btn-primary' class here if needed */
}

/* Add any other styles as required */
</style>

<div class='cart-list'>
    <h3>Shopping Cart <img src='cart.svg' alt='Cart'></h3>
    <a href="?toggleCart=1" class="close-cart">Close</a>
    <?php
    $total_cost = 0;
    if (count($_SESSION['shopping_cart']) > 0) {
        echo "<table class='table'>";
        echo "<thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr></thead>";
        echo "<tbody>";
        foreach ($_SESSION['shopping_cart'] as $product_id => $details) {
            $total_cost += $details['price'] * $details['quantity'];
            echo "<tr>";
            echo "<td>" . htmlspecialchars($details['name']) . "</td>";
            echo "<td>$" . number_format($details['price'], 2) . "</td>";
            echo "<td>" . $details['quantity'] . "</td>";
            echo "<td>$" . number_format($details['price'] * $details['quantity'], 2) . "</td>";
            echo "<td>";
            echo "<form action='cart_remove.php' method='get'>";
            echo "<input type='hidden' name='product_id' value='" . $product_id . "'>";
            echo "<button type='submit' class='btn btn-danger btn-sm'>Remove</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "<p class='text-end'>Total Cost: <strong>$" . number_format($total_cost, 2) . "</strong></p>";
        echo "<p class='text-end'><a href='checkout.php' class='btn btn-primary'>Proceed to Checkout</a></p>";
    } else {
        echo "<p>Your cart is empty.</p>";
    }
    ?>
</div>