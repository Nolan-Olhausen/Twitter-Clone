<!--
/****************************************************************************************************
 *
 * @file:    following.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This is the front end for the following page. It displays the users that the user is following.
 *
 ****************************************************************************************************/
-->

<?php 
    session_start(); 
    require_once 'Dao.php'; 
    $dao = new Dao();
    if ($dao->checkLogIn() === false) {
        header("Location: login.php");
    }
    $user_id = $_SESSION['user_id'];
    $user = $dao->getDataUser($user_id);
    $profileId = $_GET['profileId'];
    $profileData = $dao->getDataUser($profileId);
    $who_users = $dao->whoToFollow($user_id);
    $uResults = $dao->usersFollowing($profileId);
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8mb4">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!--<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />-->
        <link rel="preload" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" media="all" onload="this.media='all'" rel="stylesheet" type="text/css" as="style" crossorigin="anonymous" data-font-display="block">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Nanum+Gothic&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles.css" />
        <link rel='shortcut icon' type='image/png' href='favicon-32x32.png'/>
        <title>Search / Echolog</title>
    </head>
    <body>
        <?php require_once 'sidebar.php'; ?>
        <!--FEED-->
        <div class="feed">
            <?php require_once 'searchBar.php'; ?>
            <div class="followingposts">
                <div class="feedInner">
                    <div class="feedHeader">
                        <h2><?php echo $profileData->username; ?>'s Following</h2>
                    </div>
                </div>
                <?php
                foreach($uResults as $rId) { 
                    $rUser = $dao->getDataUser($rId->user_id);?>
                    <div class="user-result-box" style="position: relative;">
                        <a href="profile.php?username=<?php echo $rUser->username; ?>">
                            <span style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 1;"></span>
                        </a>
                        <div class="profileResult">
                            <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $rUser->profile_image; ?>" alt="" class="resultPFP"/>
                            <div class="resultTag">
                                <strong> <?php echo $rUser->name ?> </strong>
                                <span class="username-echolog">@<?php echo $rUser->username ?> </span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php require_once 'mobileBar.php'; ?>
            </div>
        </div>
        <!--END FEED-->
        <!--RECOMMEND-->
        <?php require_once 'recommend.php'; ?>
        <!--END RECOMMEND-->
    </body>
 </html>