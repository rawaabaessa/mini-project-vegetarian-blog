<?php
    require_once('database.php');
    $sql = 'select * from reviews order by created_at desc limit 3';
    $result = mysqli_query($conn,$sql);
    require_once('layout/header.php')
?>

  <section id="hero" class="d-flex align-items-center">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 pt-2 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h1>Discover the Best Vegetarian Products</h1>
          <ul>
            <li class="ps-0">Embark on a tantalizing journey through the world of vegan food as we uncover the finest plant-based products from around the globe.  our blog offers insightful reviews and recommendations that will elevate your vegan dining experience. </li>
          </ul>
          <div class="mt-3">
            <a href="/vegan/allreview2.php" class="btn-get-started scrollto">Discover Now</a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img">
          <img src="assets/img/Digital_Art__40+_Inspiring_Illustrations_on_Diverse_Themes__1_-removebg-preview.png" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </section>
  <main id="main">
    <section class="py-3 py-md-5">
      <div class="container">
        <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
          <div class="col-12 col-lg-6 col-xl-5">
            <img class="img-fluid rounded" loading="lazy" src="assets/img/Questions-pana.svg" alt="About 1">
          </div>
          <div class="col-12 col-lg-6 col-xl-7">
            <div class="row justify-content-xl-center">
              <div class="col-12 col-xl-11">
                <div class="container">
                  <h2 class="mb-3">Who I am ?</h2>
                  <p class=" mb-3 about">My name is Kylie Perrotti, author of Tried & True Recipes and self-proclaimed meat and potatoes girl, until I wrote my first plant-based cookbook.
  
                    At the time, it was a challenge for me to develop vegan recipes because meat and dairy had become such an integral part of my approach to cooking. By the end of the book, I was so in love with all of the plant-based recipes that I decided to layoutorporate meat-free meals into my weekly rotation permanently.
                    
                    My cookbook, The Weekly Vegan Meal Plan Cookbook opened my eyes to the exciting possibilities of not just plant-based proteins but creative ways to use grains, vegetables, and fruits to create filling and flavorful meals.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <section class="best-product">
    <div class="container px-4 px-lg-5 mt-5">
      <div class="section-title text-start d-flex justify-content-between"> 
        <h2 class="border-btm">Latest Reviews</h2>
        <a class="all-reviews align-self-md-baseline align-self-lg-baseline align-self-baseline" href="allreview2.php">View All</a>
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
                        <a><img class="card-img-top scal" height="400" src="upload/<?= $row_img['name'] ?>" alt="..." /></a>
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
  require_once('layout/footer.php')
  ?>