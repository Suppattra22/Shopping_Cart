<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$productIds = [];
foreach(($_SESSION['cart'] ?? []) as $cartId => $cartQty) {    
    $productIds[] = $cartId;
}

// Simulate some product data for the cart (just for the sake of example)
$products = [
    1 => ['id' => 1, 'product_name' => 'Flower Bouquet', 'price' => 350, 'profile_image' => 'flower1.jpg', 'detail' => 'A beautiful bouquet of flowers.'],
    2 => ['id' => 2, 'product_name' => 'Rose', 'price' => 100, 'profile_image' => 'rose.jpg', 'detail' => 'A fresh red rose.'],
    3 => ['id' => 3, 'product_name' => 'Tulip', 'price' => 150, 'profile_image' => 'tulip.jpg', 'detail' => 'A bright yellow tulip.']
];

// Filter the products to match the ones in the cart
$cartProducts = [];
foreach ($productIds as $productId) {
    if (isset($products[$productId])) {
        $cartProducts[$productId] = $products[$productId];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

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

        <h4>Cart</h4>
        <div class="row">
            <div class="col-12">
                <form action="cart-update.php" method="post">
                    <table class="table table-bordered border-success">
                        <thead>
                            <tr>
                                <th style="width: 100px;">Image</th>
                                <th>Product Name</th>
                                <th style="width: 200px;">Price</th>
                                <th style="width: 100px;">Quantity</th>
                                <th style="width: 200px;">Total</th>
                                <th style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($cartProducts) > 0): ?>
                                <?php foreach($cartProducts as $product): ?>
                                <tr>
                                    <td>
                                        <?php if(!empty($product['profile_image'])): ?>
                                            <img src="/upload_image/<?php echo $product['profile_image']; ?>" width="100" alt="Product Image">
                                        <?php else: ?>
                                            <img src="/assets/images/no-image.png" width="100" alt="Product Image">
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo $product['product_name']; ?>
                                        <div>
                                            <small class="text-muted"><?php echo nl2br($product['detail']); ?></small>
                                        </div>
                                    </td>
                                    <td><?php echo number_format($product['price'], 2); ?></td>
                                    <td><input type="number" name="product[<?php echo $product['id']; ?>][quantity]" value="<?php echo $_SESSION['cart'][$product['id']]; ?>" class="form-control"></td>
                                    <td><?php echo number_format($product['price'] * $_SESSION['cart'][$product['id']], 2); ?></td>
                                    <td>                                    
                                        <a onclick="return confirm('Are you sure you want to delete?');" role="button" href="/cart-delete.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-danger"><i class="fa-solid fa-trash me-1"></i>Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="6" class="text-end">
                                        <button type="submit" class="btn btn-lg btn-success">Update Cart</button>
                                        <a href="/checkout.php" class="btn btn-lg btn-primary">Checkout Order</a>
                                    </td>
                                </tr>
                            <?php else: ?>
                            <tr>
                                <td colspan="6"><h4 class="text-center text-danger">ไม่มีรายการสินค้าในตะกร้า</h4></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <script src="/assets/js/bootstrap.min.js"></script>
</body>
</html>