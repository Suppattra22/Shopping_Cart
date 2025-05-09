<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// ตรวจสอบการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $product_name = $_POST['product_name'] ?? '';
    $price = $_POST['price'] ?? '';
    $detail = $_POST['detail'] ?? '';
    $image = $_FILES['profile_image']['name'] ?? '';

    // อัปโหลดรูปภาพ
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "upload_image/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
    }

    // ดึงข้อมูลเดิม
    if (!isset($_SESSION['products'])) {
        $_SESSION['products'] = [];
    }

    // ถ้าเป็นการเพิ่มข้อมูลใหม่
    if (empty($id)) {
        $new_id = count($_SESSION['products']) + 1;
        $_SESSION['products'][] = [
            'id' => $new_id,
            'product_name' => $product_name,
            'price' => $price,
            'detail' => $detail,
            'profile_image' => $image,
        ];
        $_SESSION['message'] = "เพิ่มสินค้าสำเร็จแล้ว";
    } else {
        // ถ้าเป็นการอัปเดต
        foreach ($_SESSION['products'] as &$product) {
            if ($product['id'] == $id) {
                $product['product_name'] = $product_name;
                $product['price'] = $price;
                $product['detail'] = $detail;
                if (!empty($image)) {
                    $product['profile_image'] = $image;
                }
                $_SESSION['message'] = "แก้ไขสินค้าสำเร็จแล้ว";
                break;
            }
        }
    }

    header("Location: product-list.php");
    exit;
}
?>