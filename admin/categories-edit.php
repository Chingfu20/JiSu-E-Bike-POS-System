<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
          <div class="card-hear">
               <h4 class="mb-0">Edit Category
                    <a href="categories.php" class="btn btn-danger float-end">Back</a>
               </h4>
          </div>
          <div class="card-body">
            
               <?php alertMessage(); ?>

               <form action="code.php" method="POST">
                    
                   <?php
                   $parmValue = checkParamId('id');
                   if(!is_numeric($parmValue)){
                      echo '<h5>'.$parmValue.'</h5>';
                      return false;
                   }

                   $catergory = getById('categories',$parmValue);
                   if($catergory['status'] == 200)
                   {
                   ?>

                   <input type="hidden" name="categoryId" value="<?= $catergory['data']['id']; ?>">

                   <div class="row">
                    <div class="col-md-12 mb-3">
                         <label for="">Name *</label>
                         <input type="text" name="name" value="<?= $catergory['data']['name']; ?>" required class="form-control" />
                    </div>
                    <div class="col-md-12 mb-3">
                         <label for="">Description</label>
                         <textarea name="description" class="form-control" rows="3"><?= $catergory['data']['description']; ?></textarea>
                    </div>
                    <div class="col-md-6">
                         <label>Status (UnChecked=Visible, Checked=Hidden)</label>
                         <br/>
                         <input type="checkbox" name="status" <?= $catergory['data']['status'] == true ? 'checked':''; ?> style="width:30px;height:30px;";>
                    </div>
                    <div class="col-md-6 mb-3 text-end">
                        <br/>
                         <button type="submit" name="updateCategory" class="btn btn-primary">Update</button>
                    </div>
                   </div>
                   <?php
                   }
                   else
                   {
                       echo '<h5>'.$catergory['message'].'</h5>';
                   }
                   ?>
               </form>
          </div>
        </div>
     </div>

<?php include('includes/footer.php'); ?>
