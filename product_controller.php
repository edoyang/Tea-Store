<div class="product-controller">
    <button>SORT BY</button>
    <?php
    $sql = "SELECT product_id, product_name, price, images FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="tea-products">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product">';
            echo '<div class="product-image">';
            echo '<img src="' . htmlspecialchars($row["images"]) . '" alt="' . htmlspecialchars($row["product_name"]) . '">';
            echo '</div>';
            echo '<p>' . htmlspecialchars($row["product_name"]) . '</p>';
            echo '<p>$' . number_format($row["price"], 2) . '</p>';
            if (isset($_SESSION['user_id'])) {
                echo '<button onclick="addToCart(' . $row['product_id'] . ')">Add to Cart</button>';
            } else {
                echo '<a href="login.php">Login to Add to Cart</a>';
            }
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo "<p>No products found</p>";
    }
    ?>
</div>

<script>
function addToCart(productId) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'cart_add.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            var cartList = document.getElementById('cart-items');
            cartList.innerHTML = xhr.responseText; // Assuming you return the <li> elements for the cart
            var cartCounter = document.getElementById('cart-counter');
            cartCounter.textContent = cartList.getElementsByTagName('li').length; // Update the counter based on the number of <li> elements
        }
    };
    xhr.send('product_id=' + productId);
}

</script>
