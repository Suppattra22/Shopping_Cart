<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $product_name = $_POST['product_name'] ?? '';
    $price = $_POST['price'] ?? '';
    $detail = $_POST['detail'] ?? '';
    $image = $_FILES['profile_image']['name'] ?? '';

    $upload_success = true;

    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "upload_image/";

        // สร้างโฟลเดอร์ถ้ายังไม่มี
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($image);

        if (!move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $_SESSION['message'] = "❌ ไม่สามารถอัปโหลดรูปภาพได้";
            $upload_success = false;
        }
    }

    if (!isset($_SESSION['products'])) {
        $_SESSION['products'] = [];
    }

    if ($upload_success) {
        if (empty($id)) {
            $new_id = count($_SESSION['products']) + 1;
            $_SESSION['products'][] = [
                'id' => $new_id,
                'product_name' => $product_name,
                'price' => $price,
                'detail' => $detail,
                'profile_image' => $image,
            ];
            $_SESSION['message'] = "✅ เพิ่มสินค้าสำเร็จแล้ว";
        } else {
            foreach ($_SESSION['products'] as &$product) {
                if ($product['id'] == $id) {
                    $product['product_name'] = $product_name;
                    $product['price'] = $price;
                    $product['detail'] = $detail;
                    if (!empty($image)) {
                        $product['profile_image'] = $image;
                    }
                    $_SESSION['message'] = "✅ แก้ไขสินค้าสำเร็จแล้ว";
                    break;
                }
            }
        }
    }

    header("Location: product-list.php");
    exit;
}
?>
