<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Product View
                <a href="products.php" class="btn btn-danger mx-2 btn-sm float-end">Back</a>
            </h4>
        </div>
        <div class="card-body text-center">

            <?php
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $productId = validate($_GET['id']); // Ensure this is a valid function to sanitize input
                
                $query = "SELECT * FROM products WHERE id='$productId'";
                $productResult = mysqli_query($conn, $query);
                
                if ($productResult && mysqli_num_rows($productResult) > 0) {
                    $productData = mysqli_fetch_assoc($productResult);
                    ?>

                    <div class="card card-body shadow border-1 mb-4">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-6 text-center">
                                <img src="<?= !empty($productData['image']) ? '../'.$productData['image'] : '../assets/images/no-img.jpg'; ?>" 
                                     style="width:100%;max-width:300px;border: 2px solid #ddd;" 
                                     alt="Product Image" />
                                <div class="mt-2">
                                    <h5 class="text-primary fw-bold">Price: ₱ <?= number_format($productData['price'], 2); ?></h5>
                                </div>
                            </div>
                            <div class="col-md-6 text-start">
                                <label class="mb-2 d-block">
                                    <strong class="text-info" style="font-size: 1.25rem;">Product Name:</strong> 
                                    <span style="font-size: 1.2rem;"><?= htmlspecialchars($productData['name']); ?></span>
                                </label>
                                <label class="mb-2 d-block">
                                    <strong class="text-info" style="font-size: 1.25rem;">Description:</strong> 
                                    <span style="font-size: 1.2rem;"><?= htmlspecialchars($productData['description']); ?></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <?php
                } else {
                    echo '<h5>No Product Found!</h5>';
                }
            } else {
                ?>
                <div class="text-center py-5">
                    <h5>No Product ID Provided</h5>
                    <div>
                        <a href="products.php" class="btn btn-primary mt-4 w-25">Go back to products</a>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
