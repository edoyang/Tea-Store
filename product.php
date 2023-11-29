<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
</head>
<body>
    <?php
    include 'db_connect.php';
    include 'navbar.php';

    if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
        $searchTerm = $conn->real_escape_string($_GET['query']);
        $currentProductName = $searchTerm; 

        $stmt = $conn->prepare("SELECT * FROM products WHERE product_name = ?");
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<img src="' . htmlspecialchars($row["images"]) . '" alt="' . htmlspecialchars($row["product_name"]) . '">';
                echo "<h2>" . htmlspecialchars($row['product_name']) . "</h2>";
                echo "<p>" . htmlspecialchars($row['product_price']) . "</p>";
            }
        } else {
            echo "<p>Sorry, there is no product matched with your search result.</p>";
            ob_start();
            $hasRecommendations = include 'product_recommendation.php';
            $recommendationsOutput = ob_get_clean();

            if ($hasRecommendations) {
                echo "<h3>Are you looking for this?</h3>";
                echo $recommendationsOutput;
            } else {
                echo "<h3>Check our newly added products</h3>";
            }
        }

        if ($stmt) {
            $stmt->close();
        }

        if ($conn) {
            $conn->close();
        }
    }
    ?>
</body>
</html>