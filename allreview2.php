<?php
    
    require_once('database.php');
    require_once('layout/header.php');
    $sql = 'select * from reviews order by created_at desc';
    $result = mysqli_query($conn,$sql);
?>

<main id="main">
    <section class="best-product mt-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="section-title text-start d-flex justify-content-between"> 
                <h2 class="border-btm">Reviews</h2>
                <!-- <a class="all-reviews align-self-md-baseline" href="#about">View All</a> -->
            </div>  
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-3">
                <?php
                    if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){ 
                        $img= 'select name from images where post_id = '.$row['id'].' limit 1';
                        $result_img = mysqli_query($conn,$img);
                        $row_img = mysqli_fetch_array($result_img);
                        ?>
                <div class="col mb-5">
                    <div class="card h-100 border-0">
                        <!-- Product image-->
                        <a><img class="card-img-top" height="400" src="upload/<?= $row_img['name'] ?>" alt="..." /></a>
                        <!-- Product details-->
                        <div class="card-body p-4 ps-0">
                            <div class="">
                                <!-- Product name-->
                                <h5 class="fw-bolder"><?= $row['name'] ?></h5>
                                <p class="text-secondary text-overflow"><?= $row['description'] ?></p>
                                  <div class="d-flex small text-warning mb-2">
                                    <?php
                                        $overall = ($row['rat_taste'] + $row['rat_texture'] + $row['rat_value'])/3;
                                        $round = round($overall);
                                        $withoutstar = 5 - $round;
                                        for ($i=0; $i < $round ; $i++) { ?>
                                            <div class="fa-solid fa-star"></div>
                                    <?php  }
                                        for ($i=0; $i < $withoutstar ; $i++) { ?>
                                            <div class="fa-regular fa-star"></div>
                                    <?php  }
                                    ?>
                                  </div>
                                  <div class=""><a class="a-underline mt-auto" href="reviewdetail.php/?id=<?= $row['id'] ?>">Read More <span class="fs-12"> <i class="fa-solid fa-arrow-right"></i></span></a></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <?php } }
                ?>
                
            </div>
      </div>
      </section>
  </main>
<?php
require_once('layout/footer.php');

?>