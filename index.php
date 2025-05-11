<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// ตัวอย่างข้อมูลสินค้า
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [
        ['id' => 1, 'product_name' => 'ดอกกุหลาบ', 'price' => 50, 'detail' => 'รายละเอียดของดอกกุหลาบ', 'profile_image' => 'rose.jpg'],
        ['id' => 2, 'product_name' => 'ดอกทิวลิป', 'price' => 60, 'detail' => 'รายละเอียดของดอกทิวลิป', 'profile_image' => 'tulip.jpg'],
        ['id' => 3, 'product_name' => 'ดอกลิลลี่', 'price' => 70, 'detail' => 'รายละเอียดของดอกลิลลี่', 'profile_image' => 'lily.jpg'],
        
    ];
}

$products = $_SESSION['products'];
$rows = count($products);

// ฟอร์มสำหรับสินค้า
$result = [
    'id' => '',
    'product_name' => '',
    'price' => '',
    'detail' => '',
    'product_image' => '',
];

// เลือกสินค้าเพื่อแก้ไข
if (!empty($_GET['id'])) {
    $product_id = $_GET['id'];
    $product_found = false;

    foreach ($products as $product) {
        if ($product['id'] == $product_id) {
            $result = $product;
            $product_found = true;
            break;
        }
    }

    if (!$product_found) {
        header('location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Product</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/solid.min.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary">
    <?php include 'include/menu.php'; ?>
    <div class="container" style="margin-top: 30px;">
        <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <h4><strong>Manage Product</strong></h4>
        <div class="row g-5">
            <div class="col-md-8 col-sm-12">
                <form action="product-form.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" value="<?php echo $result['product_name']; ?>">
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Price</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $result['price']; ?>">
                        </div>

                        <div class="col-sm-6">
                            <?php if (!empty($result['profile_image'])): ?>
                                <div>
                                    <img src="upload_image/<?php echo $result['profile_image']; ?>" width="100" alt="Product Image">
                                </div>
                            <?php endif; ?>
                            <label for="formFile" class="form-label">Image</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/png, image/jpg, image/jpeg">
                        </div>

                        <div class="col-sm-12">
                            <label class="form-label">Detail</label>
                            <textarea name="detail" class="form-control" rows="3"><?php echo $result['detail']; ?></textarea>
                        </div>
                    </div>
                    <?php if (empty($result['id'])): ?>
                        <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk me-1"></i>Create</button>
                    <?php else: ?>
                        <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk me-1"></i>Update</button>
                    <?php endif; ?>

                    <a role="button" class="btn btn-secondary" href="index.php"><i class="fa-solid fa-rotate-left me-1"></i>Cancel</a>
                    <hr class="my-4">
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table table-bordered border-success">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Image</th>
                            <th>Product Name</th>
                            <th style="width: 200px;">Price</th>
                            <th style="width: 200px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($rows > 0): ?>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($product['profile_image'])): ?>
                                        <img src="upload_image/<?php echo $product['profile_image']; ?>" width="100" alt="Product Image">
                                    <?php else: ?>
                                        <img src="assets/images/no-image.png" width="100" alt="Product Image">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo $product['product_name']; ?>
                                    <div>
                                        <small class="text-muted"><?php echo nl2br($product['detail']); ?></small>
                                    </div>
                                </td>
                                <td><?php echo number_format((float)$product['price'] ?: 0, 2); ?></td>
                                <td>
                                    <a role="button" href="product-list.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-dark"><i class="fa-regular fa-pen-to-square me-1"></i>Edit</a>
                                    <a onclick="return confirm('Are your sure you want to delete?');" role="button" href="product-delete.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-danger"><i class="fa-solid fa-trash me-1"></i>Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4"><h4 class="text-center text-danger">ไม่มีรายการสินค้า</h4></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
