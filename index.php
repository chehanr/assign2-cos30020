<?php include_once "app.php";?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Friend System | Assignment Home Page</title>
    <meta charset="utf-8">
    <meta name="description" content="A simplified social network application.">
    <meta name="keywords" content="social, network">
    <meta name="author" content="Chehan Ratnasiri (102004363)">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="site">
        <?php include "masthead.php";?>
        <?php $navItem = NULL; include "navbar.php";?>
        <div class="side-content">
            <div class="page-header">
                <h1>My Friend System</h1>
                <p>Assignment Home Page</p>
            </div>
            <div class="side-bar">
                <p>
                    Name: Chehan Ratnasiri</br>
                    </br>

                    I declare that this assignment is my individual work. I have not worked collaboratively nor have I
                    copied from any other student’s work or from any other source.
                </p>
            </div>
        </div>
        <div class="page-content">
       <?php
            $db = new DB();

            if ($db->initDatabase()){
                echo "<p class=\"success-text\">Tables successfully created and populated!</p>"; 
            } else {
                echo "<p class=\"error-text\">Unable to setup tables.</p>"; 
            }
        ?>
        </div>
        <?php include "footer.php";?>
    </div>
</body>

</html>