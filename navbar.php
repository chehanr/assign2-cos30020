<nav class="nav-bar">
    <?php
    $db = new DB();
    $auth = new Auth($db);
    $isAuth = $auth->isAuthenticated();

    if($isAuth){
        $session = $auth->getAuthSession();
        $uAccount = new Account($db, $session["USER_ID"]);
    }

    ?>
    <ul class="float-left">
        <?php 
        if ($isAuth){ 
            if ($navItem == "friendlist") {
                echo "<li class=\"item-active\">";
            } else {
                echo "<li class=\"\">";
            }

            echo "<a href=\"friendlist.php\" target=\"_self\">Friend List</a>";
            echo "</li>";

            if ($navItem == "friendadd") {
                echo "<li class=\"item-active\">";
            } else {
                echo "<li class=\"\">";
            }

            echo "<a href=\"friendadd.php\" target=\"_self\">Add Friends</a>";
            echo "</li>";
        } else {
            if ($navItem == "signup") {
                echo "<li class=\"item-active\">";
            } else {
                echo "<li class=\"\">";
            }

            echo "<a href=\"signup.php\" target=\"_self\">Signup</a>";
            echo "</li>";
        }
        ?>
        <li class="<?php if($navItem == "login") echo "item-active"; ?>">
            <?php 
            if ($isAuth){ 
                echo "<a href=\"logout.php\" target=\"_self\">Logout ({$uAccount->getProfileName()})</a>";
            } else {
                echo "<a href=\"login.php\" target=\"_self\">Login</a>";
            }
            ?>
        </li>
    </ul>
    <ul class="float-right">
        <li class="<?php if($navItem == "about") echo "item-active"; ?>">
            <a href="about.php" target="_self">About</a>
        </li>
    </ul>
</nav>