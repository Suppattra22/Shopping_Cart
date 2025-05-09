<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if an item ID is provided
if(!empty($_GET['id'])) {
    // Remove the item from the cart session
    unset($_SESSION['cart'][$_GET['id']]);
    
    // Set a success message
    $_SESSION['message'] = 'Cart delete success';
}

// Redirect back to the cart page
header('location: cart.php');
exit;
?>
