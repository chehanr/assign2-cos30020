<?php include_once "app.php";?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Friend System | About</title>
    <meta charset="utf-8">
    <meta name="description" content="A simplified social network application.">
    <meta name="keywords" content="social, network">
    <meta name="author" content="Chehan Ratnasiri (102004363)">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="site">
        <?php include "masthead.php";?>
        <?php $navItem = "about"; include "navbar.php";?>
        <div class="side-content">
            <div class="page-header">
                <h1>About</h1>
            </div>
            <div class="side-bar">
                <p>
                    <?php echo "PHP version: " . phpversion(); ?>
                </p>
            </div>
        </div>
        <div class="page-content">
            <p><strong>"What tasks you have not attempted or not completed?"</strong></p>
            <p>Attempted all tasks.</p>
            <p><strong>"What special features have you done, or attempted, in creating the site that we should know about?"</strong></p>
            <ul>
                <li>Uses a custom CSS Grid framework. <a href="https://github.com/chehanr/tutreq/tree/master/core/static/css" target="_blank">(https://github.com/chehanr/tutreq/tree/master/core/static/css)</a> </li>
                <li>Responsive views.</li>
            </ul>
            <p><strong>"Which parts did you have trouble with?"</strong></p>
            <ul>
                <li>Implementing a true Object Oriented design.</li>
            </ul>
            <p><strong>"What would you like to do better next time?"</strong></p>
            <ul><li>Handle db operations better.</li></ul>
            <p><strong>"What additional features did you add to the assignment?"</strong></p>
            <p>None</p>
            <p><strong>"A screen shot of a discussion response that answered someone’s thread in the unit’s discussion board for Assignment 2?"</strong></p>
            <p>Non attempted as there weren't any worthwhile discussions to contribute to.</p>

            <h1>Links</h1>
            <ul>
                <li><a href="friendlist.php" target="_self">friendlist.php (Requires log in)</a></li>
                <li><a href="friendadd.php" target="_self">friendadd.php (Requires log in)</a></li>
                <li><a href="index.php" target="_self">index.php</a></li>
            </ul>
        </div>
        <?php include "footer.php";?>
    </div>
</body>

</html>