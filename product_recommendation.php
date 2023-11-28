<?php
// product_recommendation.php
include 'db_connect.php';

$recommendations = [];
$foundRecommendations = false;

$sql = "SELECT * FROM products WHERE product_name LIKE ? LIMIT 10";
$stmt_recommendation = $conn->prepare($sql);
$searchTerm = '%' . $currentProductName . '%';
$stmt_recommendation->bind_param("s", $searchTerm);
$stmt_recommendation->execute();
$result_recommendation = $stmt_recommendation->get_result();

if ($result_recommendation && $result_recommendation->num_rows > 0) {
    $foundRecommendations = true;
    while ($row = $result_recommendation->fetch_assoc()) {
        array_push($recommendations, $row);
    }
}

foreach ($recommendations as $product) {
    echo '<div>' . htmlspecialchars($product['product_name']) . '</div>';
    // Display each product
}

$stmt_recommendation->close();

return $foundRecommendations; // Return whether recommendations were found
?>