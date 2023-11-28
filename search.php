<?php
$host = 'localhost';
$dbname = 'tea_store';
$user = 'root';
$pass = ''; 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $searchTerm = $conn->real_escape_string($_GET['query']);
    $sql = "SELECT product_id, product_name, price, images FROM products WHERE product_name LIKE '%$searchTerm%' LIMIT 3";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product-result">';
            echo '<img src="'.$row['images'].'" alt="Product Image" style="width: 50px; height: 50px;">';
            echo '<span>'.htmlspecialchars($row['product_name']).'</span>';
            echo '</div>';
        }
    } else {
        echo '<p>No products found.</p>';
    }
    $conn->close();
    exit;
}
?>

<style>
    .search-container {
        position: relative;
    }
    .product-result {
        display: flex;
        align-items: center;
        background: #f9f9f9;
        padding: 10px;
        border: 1px solid #ddd;
        width: inherit;
        height: 50px;
    }
    .product-result img {
        width: 50px;
        height: 50px;
    }
    .result {
        position: absolute;
        top: 20px;
        left: 0;
        width: 100%; /* Let it expand to the width of the .search-container */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        background: white;
        z-index: 1000; /* Ensure it's above other content */
        display: none; /* Initially hide the result container */
    }

    #searchResult {
        visibility: visible;
    }
</style>

<form action="product.php" method="get">
    <div class="search-container">
        <div class="search-icon"></div>
        <input type="text" name="query" class="search-input" id="searchInput" autocomplete="off" />
        <button type="submit" class="search-btn">Search</button>
        <div class="result" id="searchResult"></div> <!-- Moved inside the search-container -->
    </div>
</form>


<script>
const searchInput = document.getElementById('searchInput');
const searchResult = document.getElementById('searchResult');

searchInput.addEventListener('keyup', function(e) {
    const searchTerm = e.target.value;

    if (searchTerm.length > 0 && searchContainer.classList.contains('active')) {
        fetch('search.php?query=' + encodeURIComponent(searchTerm))
        .then(response => response.text())
        .then(html => {
            searchResult.innerHTML = html;
            searchResult.style.display = 'block'; // Show the results
        });
    } else {
        searchResult.innerHTML = '';
        searchResult.style.display = 'none';
    }
});

document.addEventListener('click', function(event) {
    if (!searchContainer.contains(event.target)) {
        searchContainer.classList.remove('active');
        searchResult.style.visibility = 'hidden';
    }
    else {
        searchResult.style.visibility = 'visible';
    }
});
</script>