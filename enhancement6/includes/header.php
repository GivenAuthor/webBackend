<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'./accounts/index.php';
require_once($_SERVER['DOCUMENT_ROOT'] .'./library/connections.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'./model/mainModel.php');
?>

<header>
    <div class="top-banner">
        <img src="../images/site/logo.png" alt="Technically this shouldn't need an alt since it's purely decorative">
        <!-- <a href="./view/login.php" title="My Account">My Account</a> -->
        <?php
        if(isset($_SESSION['clientData']['clientFirstname'])){ echo "<p>Welcome <a href='../accounts/index.php?action=admin'>"; echo $_SESSION['clientData']['clientFirstname']; echo "</a></p>"; } 
        if ($_SESSION['loggedin'] == false) {echo '<a href="../accounts/index.php?action=login" title=" My Account">My Account</a>';}
        else {echo '<a href="../accounts/index.php?action=logout">Logout</a>';}
        ?>
    </div>
    <nav>
        <?php echo $navList; ?>
    </nav>
</header>