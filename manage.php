<?php
    
    require_once('database.php');
    require_once('layout/header.php');
    // display query
    $sql_get = 'select * from reviews order by created_at desc';
    $getresult = mysqli_query($conn,$sql_get);
    // delete query
  if(isset($_POST['delete'])){
    $delete_id = $_POST['reviewid'];
    $sql_delete = 'delete from reviews where id ='. $delete_id .' ';

    $sql_select_img = 'select name from images where post_id ='. $delete_id .' ';
    $result_select = mysqli_query($conn,$sql_select_img);
    if (mysqli_num_rows($result_select) > 0){
      while($row_select_img = mysqli_fetch_array($result_select)){
        if(file_exists('upload/'.$row_select_img['name'].'')){
          unlink('upload/'.$row_select_img['name'].'');
        }
      }
    }

    $sql_delete_img = 'delete from images where post_id ='. $delete_id .' ';
    $result_delete = mysqli_query($conn,$sql_delete);
    $result_delete_img = mysqli_query($conn,$sql_delete_img);
    if($result_delete && $result_delete){
      $_SESSION['submit'] = "The Review Is Deleted successfully";
      header('Location:manage.php');
      exit;
    }
  }
  // add query
if(isset($_POST['submit'])){
    $productname = $_POST['name'];
    $productreview = $_POST['review'];
    $productTaste = $_POST['taste'];
    $producttexture = $_POST['texture'];
    $productvalue = $_POST['value'];
    if(empty($productname) || trim($productname) == "" || empty($productreview) || trim($productreview) == ""){
        $_SESSION['submiterror'] = 'All Feilds Are Required';
        header('Location:manage.php');
        exit;
    }
    $imagecount = count($_FILES['image']['name']);
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    for ($j=0; $j < $imagecount; $j++) { 
      $mimetype = mime_content_type($_FILES['image']['tmp_name'][$j]);
      if (in_array($mimetype,$allowed_types)){
        continue;
      }
      else{
        $_SESSION['error'] = 'The Files Must Be Of Type Image';
        header('Location:manage.php');
        exit;
      }
    }
    $sql_insert_rev = 'insert into reviews (name,description,rat_taste,rat_texture,rat_value) values("'.$productname.'","'.$productreview.'",'.$productTaste.','.$producttexture.','.$productvalue.')';
    $insertresult = mysqli_query($conn,$sql_insert_rev);
    $post_id = $conn->insert_id;
    
    for ($i=0; $i < $imagecount ; $i++) {
        $imagename = $_FILES['image']['name'][$i];
        $imagetempname = $_FILES['image']['tmp_name'][$i];
        $replacename = $post_id .$imagename;
        $targetpath = 'upload/'. $replacename;
        if(move_uploaded_file($imagetempname,$targetpath)){
          $sql = 'insert into images (post_id,name) values('.$post_id.',"'.$replacename.'")';
          $result = mysqli_query($conn,$sql);
      }
    }
    if($insertresult){
        $_SESSION['submit'] = "The Review Is Inserted successfully";
        header('Location: manage.php');
        exit;
    }
}
?>
<?php
  if(isset($_SESSION['isSignedIn'])){ ?>

<main id="main">
  <section class="best-product mt-5">
      <div class="container ">
          <div class="section-title pb-0 d-flex justify-content-between">
              <h2 class="text-start border-btm">Manage Reviews</h2>
              <a data-bs-toggle="modal" data-bs-target="#exampleModal1" class="all-reviews align-self-md-baseline align-self-lg-baseline align-self-baseline" href=""><i class="fa-solid fa-plus me-1"></i> Add</a>
          </div>
          <?php
            if(isset($_SESSION['error'])){ ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?= $_SESSION['error'] ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
          <?php 
            unset($_SESSION['error']);
        }
          ?>
          <?php
            if(isset($_SESSION['submit'])){ ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['submit'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
         <?php
          unset($_SESSION['submit']); 
        }
          ?>
          
      </div>
      <div class="container px-4 px-lg-5 mt-5">
      <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Review</th>
              <th scope="col">Created at</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php 
              if (mysqli_num_rows($getresult) > 0){
                $i=0;
                while($row_get = mysqli_fetch_array($getresult)){ $i++ ?>
                  <tr>
                    <th scope="row"><?= $i ?></th>
                    <td><?= $row_get['name'] ?></td>
                    <td><?= date('Y-m-d', strtotime($row_get['created_at'])) ?></td>
                    <td>
                      <a href="reviewdetail.php/?id= <?= $row_get['id'] ?>" class="me-2"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                      
                      <a data-bs-toggle="modal" data-bs-target="#exampleModal" data-revireid="<?= $row_get['id'] ?>" href="#" class="deletebtn"><i class="fa-solid fa-trash"></i></a>
                      
                    </td>
                  </tr>
              <?php  }
              }
            ?>
            
          </tbody>
        </table>
    </div>
    </section>
</main>
<!-- popup delete -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Review</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are You Sure ?
      </div>
      <div class="modal-footer">
        <form method="post">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="hidden" class="heddininput" value="" name="reviewid" />
          <button type="submit" name="delete" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- popup add -->
<div class="modal fade" id="exampleModal1" tabindex="1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Review</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="model-body p-3" style="overflow-y:auto;">
              <form method="post" enctype="multipart/form-data">
                  <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Review Name</label>
                      <input type="text" name="name" class="form-control review-title" id="exampleFormControlInput1" required>
                    </div>
                    <div class="mb-3">
                      <label for="exampleFormControlTextarea1" class="form-label">Review</label>
                      <textarea class="form-control review-desc" name="review" id="exampleFormControlTextarea1" rows="3" required></textarea>
                    </div>
                  <div class="row mb-3 align-items-center">
                      <div class="col-2">
                          <label class="form-label">Taste</label>
                      </div>
                      <div class="col">
                      <input type="number" class="form-control w-30" min="1" max="5" name="taste" placeholder="Rate (1-5)" required>
                      </div>
                  </div>
                  <div class="row mb-3 align-items-center">
                      <div class="col-2">
                          <label class="form-label">Texture</label>
                      </div>
                      <div class="col">
                      <input type="number" class="form-control w-30" min="1" max="5" name="texture" placeholder="Rate (1-5)" required>
                      </div>
                  </div>
                  <div class="row mb-3 align-items-center">
                      <div class="col-2">
                          <label class="form-label">Value</label>
                      </div>
                      <div class="col">
                          <input type="number" class="form-control w-30" min="1" max="5" name="value" placeholder="Rate (1-5)" required>
                      </div>
                  </div>
                  <div class="mb-3">
                      <label for="formFileMultiple" class="form-label">Upload images</label>
                      <input class="form-control" type="file" accept="image/*" name="image[]" id="formFileMultiple" multiple required>
                    </div>
                  </div>
                  <div class="modal-footer border-0">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <input type="submit" class="btn bg-green" name="submit" value="Add" />
                  </div>
              </form>
    </div>
  </div>
</div>

<?php 
require_once('layout/footer.php');
?>
<?php  }
else{ ?>
  <div class="container">
    <h1 class="mt-100">404 Page Not Found</h1>
  </div>
<?php }
?>
