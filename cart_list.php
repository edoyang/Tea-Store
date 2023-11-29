<?php
function displayCartItems($shopping_cart) {
    if (empty($shopping_cart)) {
        return "<li>Your cart is empty.</li>";
    }

    $cartContents = '<form id="cart-form" action="checkout.php" method="post">';
    foreach ($shopping_cart as $id => $details) {
        $cartContents .= "<div class='cart-item' id='cart-item-{$id}'>";
        $cartContents .= "<p>" . htmlspecialchars($details['name']) . " x" . $details['quantity'] . "</p>";
        $cartContents .= "<button type='button' onclick='removeFromCart({$id})'>Remove</button>";
        $cartContents .= "<input type='hidden' name='product_ids[]' value='{$id}'>";
        $cartContents .= "<input type='hidden' name='quantities[]' value='{$details['quantity']}'>";
        $cartContents .= "</div>";
    }
    $cartContents .= "<button type='submit' style='float: right;'>Submit Order</button>";
    $cartContents .= '</form>';

    return $cartContents;
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
            // Update the cart counter or any other elements as needed
        }
    };
    xhr.send('product_id=' + productId);
}
</script>
