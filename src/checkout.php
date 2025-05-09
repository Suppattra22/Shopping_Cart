<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!doctype html>

<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Checkout</title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/brands.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/solid.css" rel="stylesheet">
</head>

<body class="bg-body-tertiary">
    <?php include 'include/menu.php' ?>
    <div class="container" style="margin-top: 30px;">
        <?php if(!empty($_SESSION['message'])) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <h4 class="mb-3">Checkout</h4>
        <form action="/checkout-process.php" method="post">
            <div class="row g-5">
                <div class="col-md-6 col-lg-7">                
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label class="form-label">Fullname</label>
                            <input type="text" name="fullname" class="form-control" placeholder="" value="">                            
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Tel.</label>
                            <input type="text" name="tel" class="form-control" placeholder="" value="">                            
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="" value="">                            
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="text-end">
                        <a href="/product-list.php" class="btn btn-secondary btn-lg" role="button">Back to product</a>
                        <button class="btn btn-primary btn-lg" type="submit">Continue to checkout</button>
                    </div>                
                </div>
                <div class="col-md-6 col-lg-5 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Your cart</span>
                        <span class="badge bg-primary rounded-pill"><?php echo count($_SESSION['cart']); ?></span>
                    </h4>

                    <?php if(!empty($_SESSION['cart'])): ?>
                    <ul class="list-group mb-3">
                        <?php
                        $grand_total = 0;
                        $productsList = $_SESSION['products'] ?? [];
                        $products = [];
                        foreach ($productsList as $item) {
                            $products[$item['id']] = $item;
                        }
                        ?>
                        <?php foreach ($_SESSION['cart'] as $productId => $productQty): ?>
                            <?php
                            $productName = isset($products[$productId]) && isset($products[$productId]['product_name']) ? $products[$productId]['product_name'] : 'Unknown Product';
                            $productPrice = isset($products[$productId]) && isset($products[$productId]['price']) ? $products[$productId]['price'] : 0;
                            $totalPrice = $productPrice * $productQty;
                            $grand_total += $totalPrice;
                            ?>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0"><?php echo htmlspecialchars($productName); ?> (<?php echo $productQty; ?>)</h6>
                                    <small class="text-body-secondary">Price: ฿<?php echo number_format($productPrice, 2); ?></small>
                                    <input type="hidden" name="product[<?php echo $productId; ?>][price]" value="<?php echo $productPrice; ?>">
                                    <input type="hidden" name="product[<?php echo $productId; ?>][name]" value="<?php echo htmlspecialchars($productName); ?>">
                                </div>
                                <span class="text-body-secondary">฿<?php echo number_format($totalPrice, 2); ?></span>
                            </li>
                        <?php endforeach; ?>
                        <li class="list-group-item d-flex justify-content-between bg-body-tertiary">
                            <div class="text-success">
                                <h6 class="my-0">Grand Total</h6>
                                <small>amount</small>
                            </div>
                            <span class="text-success"><strong>฿<?php echo number_format($grand_total, 2); ?></strong></span>
                        </li>
                    </ul>
                    <input type="hidden" name="grand_total" value="<?php echo $grand_total; ?>">
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>                   
</body>
</html>
