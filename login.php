<?php include_once "app.php";?>
<?php 
$db = new DB();
$auth = new Auth($db);

if ($auth->isAuthenticated()){
    header("Location: index.php"); 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Friend System | Login</title>
    <meta charset="utf-8">
    <meta name="description" content="A simplified social network application.">
    <meta name="keywords" content="social, network">
    <meta name="author" content="Chehan Ratnasiri (102004363)">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="site">
        <?php include "masthead.php";?>
        <?php $navItem = "login"; include "navbar.php";?>
        <div class="side-content">
            <div class="page-header">
                <h1>Login</h1>
                <p>Login to your MFF account.</p>
            </div>
            <div class="side-bar">
                <form method="POST" action="" novalidate="novalidate">
                <?php
                    $formEmail = NULL;
                    $formPassword = NULL;
                    
                    $formErrors = array();
                    $procErrors = array();
                
                    if (isset($_SESSION["formEmail"])){
                        $formEmail = $_SESSION["formEmail"];
                    }

                    if (isset($_SESSION["formErrors"])){
                        $formErrors = $_SESSION["formErrors"];
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {              
                        if (isset($_POST["email"]) && $_POST["email"] != NULL) {
                            $formEmail = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
                            if (!filter_var($formEmail, FILTER_VALIDATE_EMAIL)) {
                                $formErrors["email"] = "Enter a valid email";
                            }
                        } else {
                            $formErrors["email"] = "Please enter your email";
                        }
        
                        if (isset($_POST["password"]) && $_POST["password"] != NULL) {
                            $formPassword = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
                            if (!preg_match("/[\w\d]{0,20}/", $formPassword)) {
                                $formErrors["password"] = "Enter a valid password";
                            }
                        } else {
                            $formErrors["password"] = "Please enter your password";
                        }
            
                        if(empty($formErrors)) {
                            // $db = new DB();
                            // $auth = new Auth($db);

                            if(!$auth->checkUnique($formEmail)) {
                                $auth->login($formEmail, $formPassword);
                                if ($auth->isAuthenticated()) {
                                    // redir.
                                    header("Location: friendlist.php"); 
                                } else {
                                    $procErrors["Cannot login"] = "Make sure your email and password are correct."; 
                                }
                            } else {
                                $procErrors["Login error"] = "Account not found!";
                            }
                        }

                        $_SESSION["formEmail"] = $formEmail;
        
                        $_SESSION["errors"]["formErrors"] = $formErrors;
                        $_SESSION["errors"]["procErrors"] = $procErrors;
                    } 
                    unset($_SESSION["formEmail"]);
                    unset($_SESSION["errors"]);
                ?>
                <div class="form-element">
                        <label for="email">Email</label>
                        <input id="email" class="form-control" type="text" name="email" placeholder="" required="required" value="<?php echo $formEmail; ?>" />
                        <?php if(array_key_exists("email", $formErrors)) echo "<div class=\"form-invalid-feedback\">" . $formErrors["email"] . "</div>";?>
                </div>
                <div class="form-element">
                        <label for="password">Password</label>
                        <input id="password" class="form-control" type="password" name="password" placeholder="" required="required" />
                        <?php if(array_key_exists("password", $formErrors)) echo "<div class=\"form-invalid-feedback\">" . $formErrors["password"] . "</div>";?>
                </div>
                <button type="submit" class="outline">Login</button>
                </form>
            </div>
        </div>
        <div class="page-content">
        <?php 
        if($procErrors){
            echo "<div class=\"box error\" role=\"alert\">";
            foreach ($procErrors as $key => $value) {
                echo "<h1>$key</h1>";
                echo "<p>$value</p>";
            }
            echo "</div>";
        }
        ?>
        <img id="add-friend-img" src="img/add_friend.jpg" alt="add-friend"/>
        </div>
        <?php include "footer.php";?>
    </div>
</body>

</html>