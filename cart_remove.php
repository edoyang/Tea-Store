<?php
session_start();

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    if (isset($_SESSION['shopping_cart'][$product_id])) {
        unset($_SESSION['shopping_cart'][$product_id]);
        echo count($_SESSION['shopping_cart']);
    } else {
        echo "error";
    }
} else {
    echo "error";
}
exit;
?>