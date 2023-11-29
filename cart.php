<link rel="stylesheet" href="cart.css">
<?php
include 'cart_list.php';
if (!isset($_SESSION['shopping_cart'])) {
    $_SESSION['shopping_cart'] = array();
}
?>

<div id="cart-icon" onclick="toggleCartDisplay()">
    <img src="assets/cart.svg" alt="Cart">
    <span id="cart-counter"><?php echo count($_SESSION['shopping_cart']); ?></span>
</div>

<div id="cart-list">
    <button onclick="toggleCartDisplay()">Close</button>
    <h3>Your Shopping Cart</h3>
    <ul id="cart-items">
        <?php echo displayCartItems($_SESSION['shopping_cart']); ?>
    </ul>
</div>

<script>
function toggleCartDisplay() {
    var cartList = document.getElementById("cart-list");
    cartList.style.display = cartList.style.display === "block" ? "none" : "block";
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