<!--
/****************************************************************************************************
 *
 * @file:    messages.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This is the front end for the messages page. It displays all the messages that the user has received.
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
    $messages = $dao->getAllChats($user_id);
    $who_users = $dao->whoToFollow($user_id);
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
        <title>Messages | Echolog</title>
    </head>
    <body>
        <?php require_once 'sidebar.php'; ?>
        <!--INBOX-->
        <div class="feed">
            <?php require_once 'searchMessageBar.php'; ?>
            <div class="feedInner">
                <div class="feedHeader">
                    <h2>Inbox</h2>
                </div>
            </div>
            <div class="followingPosts">
                <?php
                    foreach($messages as $message) {
                        
                        if($message->recipient_user == $user_id) { 
                            $user2_id = $message->sender_user;
                            $user2 = $dao->getDataUser($user2_id);?>
                            <a style="position: relative; z-index:1000; text-decoration:none;" href="<?php echo "sendMessage.php?toUser=" . $message->sender_user;  ?>">
                                <div class="chatResult">
                                    <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $user2->profile_image; ?>" alt="" class="img-user-message"/>
                                    <div class="chatTag">
                                        <p class="chatTagName"><?php echo $user2->name ?>  <span class="username-echolog">@<?php echo $user2->username ?> </span></p>
                                        <p><?php echo $message->messageText; ?></p>
                                    </div>
                                </div>
                            </a>
                        <?php } else { 
                            $user2_id = $message->recipient_user;
                            $user2 = $dao->getDataUser($user2_id);?>
                            <a style="position: relative; z-index:1000; text-decoration:none;" href="<?php echo "sendMessage.php?toUser=" . $message->recipient_user;  ?>">
                                <div class="chatResult">
                                    <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $user2->profile_image; ?>" alt="" class="img-user-message"/>
                                    <div class="chatTag">
                                        <p class="chatTagName"><?php echo $user2->name ?>  <span class="username-echolog">@<?php echo $user2->username ?> </span></p>
                                        <p><?php echo $message->messageText; ?></p>
                                    </div>
                                    
                                </div>
                            </a>
                        <?php } ?>

                    <?php } ?>
            </div>
            <?php require_once 'mobileBar.php'; ?>
        </div>
        <!--END INBOX-->
        <!--RECOMMEND-->
        <?php require_once 'recommend.php'; ?>
        <!--END RECOMMEND-->
    </body>
 </html>