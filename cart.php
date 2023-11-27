<?php
if (!isset($_SESSION['shopping_cart'])) {
    $_SESSION['shopping_cart'] = array();
}
?>

<div id="cart-icon" onclick="toggleCartDisplay()" style="position: fixed; bottom: 60px; right: 10px; cursor: pointer; z-index: 1001;">
    <img src="assets/cart.svg" alt="Cart" style="width: 50px; height: 50px;">
    <span id="cart-counter" style="background-color: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 14px; margin-left: -15px; border: 2px solid white;"><?php echo count($_SESSION['shopping_cart']); ?></span>
</div>

<div id="cart-list" style="display: none; position: fixed; bottom: 10px; right: 10px; width: 300px; background: #FFF; border: 1px solid #000; padding: 10px; box-shadow: 0px 0px 5px rgba(0,0,0,0.2); z-index: 1000;">
    <button onclick="toggleCartDisplay()" style="background-color: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer; float: right;">Close</button>
    <h3>Your Shopping Cart</h3>
    <ul id="cart-items" style="list-style-type: none; padding: 0;">
        <?php foreach ($_SESSION['shopping_cart'] as $product_id => $details): ?>
            <li id="cart-item-<?php echo $product_id; ?>">
                <?php echo htmlspecialchars($details['name']); ?> - Quantity: <?php echo $details['quantity']; ?>
                <button onclick="removeFromCart(<?php echo $product_id; ?>)" style="background-color: #f44336; color: white; border: none; padding: 5px; cursor: pointer;">Remove</button>
            </li>
        <?php endforeach; ?>
        <?php if (empty($_SESSION['shopping_cart'])): ?>
            <li>Your cart is empty.</li>
        <?php endif; ?>
    </ul>
</div>

<script>
function toggleCartDisplay() {
    var cartList = document.getElementById("cart-list");
    cartList.style.display = cartList.style.display === "none" ? "block" : "none";
}

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