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
    <title>My Friend System | Friend Add</title>
    <meta charset="utf-8">
    <meta name="description" content="A simplified social network application.">
    <meta name="keywords" content="social, network">
    <meta name="author" content="Chehan Ratnasiri (102004363)">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="site">
        <?php include "masthead.php";?>
        <?php $navItem = "friendadd"; include "navbar.php";?>
        <?php
        $session = $auth->getAuthSession();
        $uAccount = new Account($db, $session["USER_ID"]);
        $friends = new Friends($db);

        $pageNumber = 0;

        if(isset($_GET["page"])){
            $pageNumber = $_GET["page"];
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {              
            if (isset($_POST["addFriend"]) && $_POST["addFriend"] != NULL) {
                $fId = filter_var($_POST["addFriend"], FILTER_SANITIZE_STRING);
                $fAccount = new Account($db, $fId);
                $friends->addFriend($uAccount, $fAccount);
                header("Location: friendadd.php?page=$pageNumber"); 
            }
        }

        $allAccountList = $friends->getAccountList($uAccount->getId());
        $friendList = $friends->getFriendList($uAccount->getId());
        $accountList = array_diff($allAccountList, $friendList);

        $pagedArray = array_chunk($accountList, 5, TRUE);
        $nthPageList = array();

        if(array_key_exists(($pageNumber), $pagedArray)){
            $nthPageList = $pagedArray[$pageNumber];
        }

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
        $accountCount = count($accountList);
        if ($accountCount > 1){
            if ($accountCount == 1){
                echo "<p>Found $accountCount account</p>";
            } else {
                echo "<p>Found $accountCount accounts</p>";
            }
        }

        if(!empty($nthPageList)){
            echo "<div id=\"account-table\" class=\"table\">";
            foreach ($nthPageList as $a) {
                $acc = new Account($db, $a);

                $mutFCount = $friends->getMutualFriendCount($uAccount->getId(), $acc->getId());
                $mutFCountStr = $mutFCount == 1 ? "$mutFCount mutual friend" : "$mutFCount mutual friends";

                echo "<div class=\"table-row\">";
                echo "<div class=\"table-item\">{$acc->getProfileName()}</div>";
                echo "<div class=\"table-item\">$mutFCountStr</div>";
                echo "
                    <div class=\"table-item\">
                    <form action=\"\" method=\"POST\">
                    <input type=\"hidden\" name=\"addFriend\" value=\"{$acc->getId()}\" />
                    <button class=\"outline small\" type=\"submit\">Add as friend</button>
                    </form>
                    </div>
                ";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No accounts found!</p>";
        }
        ?>
        <?php $pagedArray; $pageNumber; include "pagination.php";?>
        </div>
        <?php include "footer.php";?>
    </div>
</body>

</html>