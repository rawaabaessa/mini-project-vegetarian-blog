<?php
    $pageName = $_SERVER['REQUEST_URI'];
    session_start();
    if(isset($_POST['logout'])){
      session_unset();
      session_destroy();
      header('Location:login.php');
      exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Vegetarian Life Blog</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="/vegan/assets/img/vegetarian-life-favicon-color (2).svg" rel="icon">
  
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  
  <link href="/vegan/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/vegan/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/vegan/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/vegan/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="/vegan/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/vegan/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/vegan/assets/vendor/fontawesome-free-6.4.2-web/css/all.css">
  <link href="/vegan/assets/css/style.css" rel="stylesheet">

</head>
<body>
<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.html"><img src="/vegan/assets/img/logo-no-background.svg" alt=""></a></h1>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto <?= str_ends_with($pageName,'index.php') ? 'active' : "" ?>" href="/vegan/index.php">Home</a></li>
          <li class="dropdown"><a href="/vegan/allreview2.php" class="nav-link scrollto <?= str_ends_with($pageName,'allreview2.php') || str_contains($pageName,'reviewdetail.php') ? 'active' : "" ?>"><span>Reviews</span></a></li>
          <!-- <li><a class="nav-link scrollto" href="#about">About</a></li> -->
          <?php
          if(isset($_SESSION['isSignedIn'])){ ?>
          <li><a class="nav-link scrollto <?= str_ends_with($pageName,'manage.php') ? 'active' : "" ?>" href="/vegan/manage.php">manage</a></li>
          <form method="post">
            <li><button typr="submit" name="logout" class="nav-link" href="">Signout</a></li>
          </form>
          <?php }
          else{ ?>
          <li><a class="getstarted scrollto" href="/vegan/login.php">Login</a></li>

        <?php }
          ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
    </div>
  </header>