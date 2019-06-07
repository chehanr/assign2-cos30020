<?php include_once "app.php";?>
<?php 
$db = new DB();
$auth = new Auth($db);

if (!$auth->isAuthenticated()){
    header("Location: index.php"); 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Friend System | Friend List</title>
    <meta charset="utf-8">
    <meta name="description" content="A simplified social network application.">
    <meta name="keywords" content="social, network">
    <meta name="author" content="Chehan Ratnasiri (102004363)">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="site">
        <?php include "masthead.php";?>
        <?php $navItem = "friendlist"; include "navbar.php";?>
        <?php
        $session = $auth->getAuthSession();
        $uAccount = new Account($db, $session["USER_ID"]);
        $friends = new Friends($db);

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {              
            if (isset($_POST["unfriend"]) && $_POST["unfriend"] != NULL) {
                $fId = filter_var($_POST["unfriend"], FILTER_SANITIZE_STRING);
                $fAccount = new Account($db, $fId);
                $friends->removeFriend($uAccount, $fAccount);
                header("Location: friendlist.php"); 
            }
        }
        
        $friendList = $friends->getFriendList($uAccount->getId());
        $friendList = sortAccountsByName($db, $friendList);
        ?>
        <div class="side-content">
            <div class="page-header">
                <?php echo "<h1>Hi {$uAccount->getProfileName()}!</h1>" ?>
                <?php echo "<p>Here's your friend list. ({$uAccount->getNumOfFriends()} friends)</p>" ?>
            </div>
            <div class="side-bar">
            </div>
        </div>
        <div class="page-content">
        <?php
        if(!empty($friendList)){
            echo "<div id=\"friend-table\" class=\"table\">";
            foreach ($friendList as $f) {
                $fAccount = new Account($db, $f);

                echo "<div class=\"table-row\">";
                echo "<div class=\"table-item\">{$fAccount->getProfileName()}</div>";
                echo "
                    <div class=\"table-item\">
                    <form action=\"\" method=\"POST\">
                    <input type=\"hidden\" name=\"unfriend\" value=\"{$fAccount->getId()}\" />
                    <button class=\"outline small btn-danger\" type=\"submit\">Unfriend</button>
                    </form>
                    </div>
                ";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>You have no friends :(</p>";
        }
        ?>
        </div>
        <?php include "footer.php";?>
    </div>
</body>

</html>