<?php
include 'db_connect.php'; // Include your database connection

$newProducts = [];
$sql = "SELECT * FROM products ORDER BY date_added DESC LIMIT 10";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($newProducts, $row);
    }
}

// Display the new products
foreach ($newProducts as $product) {
    echo '<div>';
    echo '<img src="' . htmlspecialchars($product["images"]) . '" alt="' . htmlspecialchars($product["product_name"]) . '" style="width: 50px; height: 50px;">';
    echo '<h4>' . htmlspecialchars($product['product_name']) . '</h4>';
    echo '<p>' . htmlspecialchars($product['price']) . '</p>';
    echo '</div>';
}
?>