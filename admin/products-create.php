<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Product
                <a href="products.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <form action="code.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Select Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            <?php
                            $categories = getAll('categories');
                            if ($categories) {
                                if (mysqli_num_rows($categories) > 0) {
                                    while ($cateItem = mysqli_fetch_assoc($categories)) {
                                        echo '<option value="' . $cateItem['id'] . '">' . $cateItem['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No Categories Found.</option>';
                                }
                            } else {
                                echo '<option value="">Something Went Wrong!</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Product Name *</label>
                        <input type="text" name="name" required class="form-control" onblur="fetchProductPrice(this.value)" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Price *</label>
                        <input type="text" name="price" required id="price" class="form-control" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Quantity *</label>
                        <input type="text" name="quantity" required class="form-control" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Image *</label>
                        <input type="file" name="image" class="form-control" />
                    </div>

                    <div class="col-md-6">
                        <label>Status (UnChecked=Visible, Checked=Hidden)</label>
                        <br/>
                        <input type="checkbox" name="status" style="width:30px;height:30px;">
                    </div>
                    <div class="col-md-6 mb-3 text-end">
                        <br/>
                        <button type="submit" name="saveProduct" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function fetchProductPrice(productName) {
        // AJAX call to fetch product price based on product name
        $.ajax({
            url: 'fetch_price.php',
            type: 'POST',
            data: { productName: productName },
            success: function(response) {
                document.getElementById('price').value = response;
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>

<?php include('includes/footer.php'); ?>
