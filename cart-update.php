<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Loop through the cart items and update quantities from the form
foreach($_SESSION['cart'] as $productId => $productQty) {
    // Update the cart quantity using the posted values
    if (isset($_POST['product'][$productId]['quantity'])) {
        $_SESSION['cart'][$productId] = $_POST['product'][$productId]['quantity'];
    }
}

// Set a success message for the cart update
$_SESSION['message'] = 'Cart update success';

// Redirect back to the cart page
header('location: cart.php');
exit;
?>
