<!--
/****************************************************************************************************
 *
 * @file:    profile.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the profile page. It displays the user's profile information and posts.
 *
 ****************************************************************************************************/
-->

<?php  
    session_start();
    if (isset($_GET['username']) === true && empty($_GET['username']) === false ) {
        require_once 'Dao.php'; 
        $dao = new Dao();

        $user_id = $_SESSION['user_id'];
        $user = $dao->getDataUser($user_id);
        $username = $dao->checkInput($_GET['username']);
        $profileId = $dao->getId($username);
        $profileData = $dao->getDataUser($profileId);
        $who_users = $dao->whoToFollow($user_id);
        $posts = $dao->postsUser($profileData->id);
      
        if (!$profileData) {
            header("Location: login.php");
        }

        if ($dao->checkLogin() === false) {
            header("Location: login.php");    
        }
        

    }
 
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8mb4"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!--<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />-->
        <link rel="preload" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" as="style" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" media="all" crossorigin="anonymous" rel="stylesheet" type="text/css" as="style" data-font-display="block">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Nanum+Gothic&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles.css" />
        <link rel='shortcut icon' type='image/png' href='favicon-32x32.png'/>
        <title> <?php echo $profileData->name; ?> (@<?php echo $profileData->username; ?>) | Echolog</title>
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="bootstrap.js"></script>
        <script type="text/javascript" src="like.js"></script>
        <?php require_once 'sidebar.php'; ?>
        <!--PROFILE-->
        <div class="profile">
            <div class="profileHeader">
                <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $profileData->profile_image; ?>" alt="" class="profile_pfp"/>
                <div class="profileRight">
                    <div class="profileBio"><?php 
                        echo $profileData->bio; 
                    ?></div>
                    <div class="profileStats">
                        <div class="postsStat">
                            <div class="postsCounter">
                                <?php echo $dao->countPosts($profileData->id); ?>
                            </div>
                            <div class="postsWord">
                                Posts
                            </div>
                        </div>
                        <div class="followersStat">
                            <a href="<?php echo "followers.php?profileId=" . $profileId; ?>" class="profileStatLinks">
                                <div class="followersCounter">
                                    <?php echo $dao->countFollowers($profileData->id); ?>
                                </div>
                                <div class="followersWord">
                                    Followers
                                </div>
                            </a>
                        </div>
                        <div class="followingStat">
                            <a href="<?php echo "following.php?profileId=" . $profileId; ?>" class="profileStatLinks">
                                <div class="followingCounter">
                                    <?php echo $dao->countFollowing($profileData->id); ?>
                                </div>
                                <div class="followingWord">
                                    Following
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="profileNameTag">
                    <?php echo $profileData->name; ?><br>
                    <span class="username-echolog">@<?php echo $profileData->username ?> </span>
                </div>
                <?php if($profileId != $user_id) { ?>
                <div class="messageButton">
                    <a href="<?php echo "sendMessage.php?toUser=" . $profileId; ?>" class="message-btn" style="font-weight: 700;">
                        Message
                    </a>
                    <a href="<?php echo "followUnfollowHandler.php?prevLink=profile.php?username=" . $profileData->username . "&follow_id=" . $profileId; ?>" class="message-btn" style="font-weight: 700;">
                        <?= $dao->FollowsYou($user_id, $profileId) ? "Unfollow" : "Follow" ?>
                    </a>
                </div>
                <?php } else { ?>
                    <div class="messageButton">
                        <a href="<?php echo "logout.php"?>" class="message-btn" style="font-weight: 700;">
                            Logout
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="profilePosts">
                <?php include 'posts.php'; ?>
            </div>
            <?php require_once 'mobileBar.php'; ?>
        </div>
        <!--END PROFILE-->
        <!--RECOMMEND-->
        <?php require_once 'recommend.php'; ?>
        <!--END RECOMMEND-->
    </body>
 </html>