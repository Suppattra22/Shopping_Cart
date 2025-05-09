<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if cart is not empty
if (!empty($_SESSION['cart'])) {
    // เตรียมข้อมูลสินค้า
    $productsList = $_SESSION['products'] ?? [];
    $products = [];
    foreach ($productsList as $item) {
        $products[$item['id']] = $item;
    }

    // คำนวณราคารวม
    $grand_total = 0;
    foreach ($_SESSION['cart'] as $productId => $productQty) {
        if (isset($products[$productId])) {
            $price = $products[$productId]['price'];
            $total = $price * $productQty;
            $grand_total += $total;
        }
    }

    // รับข้อมูลผู้ใช้
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $tel = $_POST['tel'] ?? '';

    // ตั้งข้อความสำเร็จ
    $_SESSION['message'] = 'Checkout order success! Total: ' . number_format($grand_total, 2);

    // ล้างตะกร้า
    unset($_SESSION['cart']);
} else {
    $_SESSION['message'] = 'Checkout not complete. No items in the cart!';
}

// Redirect
header('Location: checkout-success.php');
exit;
?>
