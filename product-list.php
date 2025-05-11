<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Sample static product list (instead of fetching from the database)
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [
        ['id' => 1, 'product_name' => 'ดอกกุหลาบ', 'price' => 50, 'detail' => 'รายละเอียดของดอกกุหลาบ', 'profile_image' => 'rose.jpg'],
        ['id' => 2, 'product_name' => 'ดอกทิวลิป', 'price' => 60, 'detail' => 'รายละเอียดของดอกทิวลิป', 'profile_image' => 'tulip.jpg'],
        ['id' => 3, 'product_name' => 'ดอกลิลลี่', 'price' => 70, 'detail' => 'รายละเอียดของดอกลิลลี่', 'profile_image' => 'lily.jpg'],
        
    ];
}
$products = $_SESSION['products'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/solid.min.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary">
    <?php include 'include/menu.php'; ?>
    <div class="container" style="margin-top: 30px;">
        <?php if(!empty($_SESSION['message'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <h4><strong>Shop list</strong></h4><br>
        <div class="row d-flex">
            <?php if(count($products) > 0): ?>
                <?php foreach($products as $product): ?>
                <div class="col-3 mb-3">
                    <div class="card" style="width: 18rem;">                        
                        <?php if(!empty($product['profile_image'])): ?>
                            <img src="/upload_image/<?php echo $product['profile_image']; ?>" class="card-img-top" width="100" alt="Product Image">
                        <?php else: ?>
                            <img src="/assets/images/no-image.png" class="card-img-top" width="100" alt="Product Image">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                            <p class="card-text text-success fw-bold mb-0"><?php echo number_format($product['price'], 2); ?> Baht</p>
                            <p class="card-text text-muted"><?php echo nl2br($product['detail']); ?></p>
                            <a href="cart-add.php?id=<?php echo $product['id']; ?>" class="btn btn-primary w-100"><i class="fa-solid fa-cart-plus me-1"></i>Add Cart</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <h4 class="text-danger">ไม่มีรายการสินค้า</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="<?php echo $base_url; ?>assets/js/bootstrap.min.js"></script>
</body>
</html>
