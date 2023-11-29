<style>
#cart-icon {
    position: fixed;
    bottom: 60px;
    right: 10px;
    cursor: pointer;
    z-index: 10;
}

#cart-icon img {
    width: 50px;
    height: 50px;
}

#cart-counter {
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 14px;
    margin-left: -15px;
    border: 2px solid white;
}

#cart-list {
    display: none;
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

#cart-list button {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    float: right;
}

#cart-items {
    list-style-type: none;
    padding: 0;
}

#cart-items div {
    color: black;
    border: none;
    padding: 5px;
}

#cart-items button{
    cursor: pointer;
}

.cart-item{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>

<?php
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
        <?php foreach ($_SESSION['shopping_cart'] as $product_id => $details): ?>
            <div class="cart-item" id="cart-item-<?php echo $product_id; ?>">
                <?php echo "<p>" . htmlspecialchars($details['name']) . " x" . $details['quantity'] . "</p>"; ?>
                <button onclick="removeFromCart(<?php echo $product_id; ?>)">Remove</button>
            </div>
        <?php endforeach; ?>
        <?php if (empty($_SESSION['shopping_cart'])): ?>
            <li>Your cart is empty.</li>
        <?php endif; ?>
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