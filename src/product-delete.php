<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check if product ID exists in the session or URL parameter
if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_SESSION['products'])) {
        foreach ($_SESSION['products'] as $index => $product) {
            if ($product['id'] == $id) {
                unset($_SESSION['products'][$index]);
                // รีจัด array ให้เรียง index ใหม่
                $_SESSION['products'] = array_values($_SESSION['products']);
                break;
            }
        }
    }

    $_SESSION['message'] = 'Product Deleted successfully.';
    header('Location: product-list.php');
    exit;
}
?>
