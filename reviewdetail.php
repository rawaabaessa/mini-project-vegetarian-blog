<?php
    // session_start();
    require_once('database.php');
    require_once('layout/header.php');
?>
  <main id="main">
   
    <section class="pt-0 pb-2 mt-100">
              <div class="container">
                <div class="section-title pb-0 d-flex justify-content-between">
                  <h2 class="text-start border-btm">Product Review</h2>
                </div>

              </div>
            </section>
            <section id="portfolio-details" class="portfolio-details">
              <div class="container">
                <?php  if(isset($_GET['id'])){
                        $id = $_GET['id'];
                        $sql = 'select * from reviews where id = '.$id.'';
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result) > 0){
                            $row = mysqli_fetch_array($result);
                            $sql_img = 'select name from images where post_id = '.$id.'';
                            $result_img = mysqli_query($conn,$sql_img);
                            if(mysqli_num_rows($result_img) > 0){ ?>
                                    <div class="row gy-4">
                                    <div class="col-lg-4">
                                        <div class="portfolio-details-slider swiper">
                                        <div class="swiper-wrapper align-items-center">

                            <?php while($row_img = mysqli_fetch_array($result_img)){ ?>
                                <?php
                                    // print_r($row_img); 
                                    ?>
                                            <div class="swiper-slide">
                                                <img src="/vegan/upload/<?= $row_img['name'] ?>" alt="">
                                            </div>
                                <?php }
                            } ?>
                                        </div>
                                        <div class="swiper-pagination mb-3"></div>
                                        </div>
                                    </div>
                            <div class="col-lg">
                              <div class="portfolio-info">
                                <h3><?= $row['name'] ?></h3>
                                <ul>
                                  <li class="align-items-center">
                                      <div class="row">
                                          <div class="col-2">
                                              <strong>Taste</strong>
                                          </div>
                                          <div class="col">
                                              <div class="d-flex small text-warning ms-2">
                                              <?php
                                                    for ($i=0; $i < $row['rat_taste'] ; $i++) { ?>
                                                            <div class="fa-solid fa-star"></div>
                                                      <?php  }
                                                    for ($i=0; $i < 5 - $row['rat_taste']; $i++) { ?>
                                                        <div class="fa-regular fa-star"></div>
                                                  <?php  }
                                            ?>
                                              </div>
                                          </div>
                                      </div>
                                  </li>
                                  <li class="align-items-center">
                                      <div class="row">
                                          <div class="col-2">
                                              <strong>Texture</strong>
                                          </div>
                                          <div class="col">
                                              <div class="d-flex small text-warning ms-2">
                                              <?php
                                                    for ($i=0; $i < $row['rat_texture'] ; $i++) { ?>
                                                            <div class="fa-solid fa-star"></div>
                                                      <?php  }
                                                    for ($i=0; $i < 5 - $row['rat_texture']; $i++) { ?>
                                                        <div class="fa-regular fa-star"></div>
                                                  <?php  }
                                            ?>
                                              </div>
                                          </div>
                                      </div>
                                  </li>
                                  <li class="align-items-center">
                                      <div class="row">
                                          <div class="col-2">
                                              <strong>Value</strong>
                                          </div>
                                          <div class="col">
                                              <div class="d-flex small text-warning ms-2">
                                              <?php
                                                    for ($i=0; $i < $row['rat_value'] ; $i++) { ?>
                                                            <div class="fa-solid fa-star"></div>
                                                      <?php  }
                                                    for ($i=0; $i < 5 - $row['rat_value']; $i++) { ?>
                                                        <div class="fa-regular fa-star"></div>
                                                  <?php  }
                                            ?>
                                              </div>
                                          </div>
                                      </div>
                                  </li>
                                  <li class="align-items-center">
                                      <div class="row">
                                          <div class="col-2">
                                              <strong>Overall</strong>
                                          </div>
                                          <div class="col">
                                              <div class="d-flex small text-warning ms-2">
                                              <?php
                                              $overall = ($row['rat_taste'] + $row['rat_texture'] + $row['rat_value'])/3;
                                              $round = round($overall);
                                              $withoutstar = 5 - $round;
                                                    for ($i=0; $i < $round ; $i++) { ?>
                                                            <div class="fa-solid fa-star"></div>
                                                      <?php  }
                                                    for ($i=0; $i < $withoutstar; $i++) { ?>
                                                        <div class="fa-regular fa-star"></div>
                                                  <?php  }
                                            ?>
                                              </div>
                                          </div>
                                      </div>
                                  </li>
                                </ul>
                                <div class="portfolio-description">
                                <h2>Review</h2>
                                <p>
                                  <?= $row['description']?>
                                </p>
                                <p class="text-secondary" style="font-size:12px">
                                  <?= date('Y-m-d', strtotime($row['created_at'])) ?>
                                </p>
                              </div>
                              </div>
                            </div>
                       <?php }
                        }?>
                </div>
              </div>
            </section>

  </main>


<?php
    require_once('layout/footer.php');
?>
