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
    <title>My Friend System | Signup</title>
    <meta charset="utf-8">
    <meta name="description" content="A simplified social network application.">
    <meta name="keywords" content="social, network">
    <meta name="author" content="Chehan Ratnasiri (102004363)">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="site">
        <?php include "masthead.php";?>
        <?php $navItem = "signup"; include "navbar.php";?>
        <div class="side-content">
            <div class="page-header">
                <h1>Signup</h1>
                <p>Register for MFF.</p>
            </div>
            <div class="side-bar">
            </div>
        </div>
        <div class="page-content">
            <form method="POST" action="" novalidate="novalidate">
                <?php
                    $formEmail = NULL;
                    $formProfileName = NULL;
                    $formPassword = NULL;
                    $formConfPassword = NULL;
                    
                    $formErrors = array();
                    $procErrors = array();
               
                    if (isset($_SESSION["formEmail"])){
                        $formEmail = $_SESSION["formEmail"];
                    }
    
                    if (isset($_SESSION["formProfileName"])){
                        $formProfileName = $_SESSION["formProfileName"];
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
                            $formErrors["email"] = "Please enter an email";
                        }
        
                        if (isset($_POST["profile_name"]) && $_POST["profile_name"] != NULL) {
                            $formProfileName = filter_var($_POST["profile_name"], FILTER_SANITIZE_STRING);
                            $formProfileName = trim($formProfileName);
                            if (!preg_match("/^[a-zA-Z]{0,50}$/", $formProfileName)) {
                                $formErrors["profile_name"] = "Enter a valid profile name (Can only contain letters)";
                            }
                        } else {
                            $formErrors["profile_name"] = "Please enter a profile name";
                        }
        
                        if (isset($_POST["password"]) && $_POST["password"] != NULL) {
                            $formPassword = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
                            $formPassword = trim($formPassword);
                            if (!preg_match("/^[a-zA-Z\d]{0,20}$/", $formPassword)) {
                                $formErrors["password"] = "Enter a valid password (Can only contain alphanumeric charaters)";
                            }
                        } else {
                            $formErrors["password"] = "Please enter a password";
                        }
        
                        if (isset($_POST["c_password"]) && $_POST["c_password"] != NULL) {
                            $formConfPassword = filter_var($_POST["c_password"], FILTER_SANITIZE_STRING);
                            if ($formPassword != $formConfPassword) {
                                $formErrors["c_password"] = "Passwords do not match";
                            }
                        } else {
                            $formErrors["c_password"] = "Please confirm password";
                        }
            
                        if(empty($formErrors)) {
                            if($auth->checkUnique($formEmail)) {
                                $isRegisteredSuccess = $auth->register($formEmail, $formProfileName, $formPassword);
                                if ($isRegisteredSuccess) {
                                    $auth->login($formEmail, $formPassword);
                                    if ($auth->isAuthenticated()) {
                                        echo "<div class=\"box success\" role=\"alert\">";
                                        echo "<h1>Account registered!</h1>";
                                        echo "<p>You will be shortly redirected.</p>";
                                        echo "</div>";
                                        // redir.
                                        header("Refresh: 2; URL=friendadd.php");
                                    }
                                } else {
                                    $procErrors["Registration error"] = "Registration failed! (SQL error)";
                                }
                            } else {
                                $procErrors["Registration error"] = "Email already registered!";
                            }
                        }

                        $_SESSION["formEmail"] = $formEmail;
                        $_SESSION["formProfileName"] = $formProfileName;
        
                        $_SESSION["errors"]["formErrors"] = $formErrors;
                        $_SESSION["errors"]["procErrors"] = $procErrors;
                    } 
                    unset($_SESSION["formEmail"]);
                    unset($_SESSION["formProfileName"]);
                    unset($_SESSION["errors"]);
                ?>
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
                <div class="form-element">
                    <label for="email">Email</label>
                    <input id="email" class="form-control" type="text" name="email" placeholder="" required="required" value="<?php echo $formEmail; ?>" />
                    <?php if(array_key_exists("email", $formErrors)) echo "<div class=\"form-invalid-feedback\">" . $formErrors["email"] . "</div>";?>
                </div>
                <div class="form-element">
                    <label for="profile_name">Profile Name</label>
                    <input id="profile_name" class="form-control" type="text" name="profile_name" placeholder="" required="required"  value="<?php echo $formProfileName; ?>"  />
                    <?php if(array_key_exists("profile_name", $formErrors)) echo "<div class=\"form-invalid-feedback\">" . $formErrors["profile_name"] . "</div>";?>
                </div>
                <div class="form-element">
                    <label for="password">Password</label>
                    <input id="password" class="form-control" type="password" name="password" placeholder="" required="required" />
                    <?php if(array_key_exists("password", $formErrors)) echo "<div class=\"form-invalid-feedback\">" . $formErrors["password"] . "</div>";?>
                </div>
                <div class="form-element">
                    <label for="c_password">Confirm Password</label>
                    <input id="c_password" class="form-control" type="password" name="c_password" placeholder="" required="required" />
                    <?php if(array_key_exists("c_password", $formErrors)) echo "<div class=\"form-invalid-feedback\">" . $formErrors["c_password"] . "</div>";?>
                </div>
                <button type="clear" class="outline float-right">Clear</button>
                <button type="submit" class="outline">Register</button>
            </form>
        </div>
        <?php include "footer.php";?>
    </div>
</body>

</html>