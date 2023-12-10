<?php
    require_once('database.php');
    require_once("layout/header.php");
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(empty($username) || trim($username) == ""){
            $_SESSION['message'] = "Username is require";
            header('Location:login.php');
            exit;
        }
        // $_SESSION['username'] = $username;
        if(empty($password) || trim($password) == "" ){
            $_SESSION['message'] = "Password is require";
            header('Location:login.php');
            exit;
        }
        $sql = 'select username , password from users where username = "'.$username.'" and password = "'.$password.'"';
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0){
            $_SESSION['isSignedIn'] = true;
            header('Location:index.php');
        }
        else{
            $_SESSION['message'] = "Invalid Username or Password";
            header('Location:login.php');
            exit;
        }
    }
    
?>
      <main>
        <div class="container">
            <div class="row login-container">
                <div class="col">
                    <img src="/vegan/assets/img/Digital_Art__40+_Inspiring_Illustrations_on_Diverse_Themes__1_-removebg-preview.png">
                </div>
                <div class="col">
                    <div class="container p-5 mt-5">
                        <h2 class="mb-4">Login</h2>
                        <form action="login.php" method="post">
                            <div class="d-flex align-items-center login-border mb-4">
                                <i class="fa-solid fa-user me-2"></i>
                                <input type="text" name="username" placeholder="Username" class="login-input" />
                            </div>
                            
                            <div class="d-flex align-items-center login-border">
                                <i class="fa-solid fa-lock me-2"></i>
                                <input type="password" name="password" placeholder="Password" class="login-input" />
                            </div>
                                <?php
                                    if(isset($_SESSION['message'])){ ?>
                                        <p class="text-danger"><?= $_SESSION['message'] ?></p>
                                <?php }
                                    unset($_SESSION['message']);
                                ?>
                            <input type="submit" name="login" class="login-btn mt-4" value="Login" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </main>
      <?php
      require_once('layout/footer.php');
      ?>