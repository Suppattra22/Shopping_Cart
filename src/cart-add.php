<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id = $_GET['id'] ?? null;
if ($id) {
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
    } else {
        $_SESSION['cart'][$id]++;
    }
    $_SESSION['message'] = 'เพิ่มสินค้าลงตะกร้าเรียบร้อยแล้ว';
}

header('Location: /cart.php');
exit;
?>
