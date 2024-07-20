<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Categories
                <a href="categories-create.php" class="btn btn-primary float-end">Add Category</a>
            </h4>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <?php
            $categories = getAll('categories');
            if (!$categories) {
                echo '<h4>Something Went Wrong!</h4>';
                return false;
            }
            $sequentialId = 1; // Initialize sequential ID counter
            if (mysqli_num_rows($categories) > 0) {
                ?>  
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($item = mysqli_fetch_assoc($categories)) : ?>
                            <tr>
                                <td><?= $sequentialId ?></td>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td>
                                    <?php
                                    if ($item['status'] == 1) {
                                        echo '<span class="badge bg-danger">Hidden</span>';
                                    } else {
                                        echo '<span class="badge bg-primary">Visible</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="categories-edit.php?id=<?= htmlspecialchars($item['id']); ?>" class="btn btn-success btn-sm">Edit</a>
                                    <a href="categories-delete.php?id=<?= htmlspecialchars($item['id']); ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <?php
                            $sequentialId++; // Increment sequential ID counter
                            endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                ?>
                <h4 class="mb-0">No Record Found</h4>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
