<!--
/****************************************************************************************************
 *
 * @file:    sendMessage.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This is the front end for the send message page. It allows the user to send a message to another user.
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
    $who_users = $dao->whoToFollow($user_id);
    $user2 = $_GET['toUser'];
    $user = $dao->getDataUser($user_id);
    $user_2 = $dao->getDataUser($user2);
    $messages = $dao->getMessages($user_id, $user2);
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
        <title>Messages (@<?php echo $user_2->username; ?>) / Echolog</title>
    </head>
    <body>
        <?php require_once 'sidebar.php'; ?>
        <!--FEED-->
        <div class="feed">
            <div class="sendMessagePage">
                <div class="feedInner">
                    <div class="feedHeader">
                        <h2>Message</h2>
                    </div>
                </div>
                <div class="messageDisplay"> 
                    <form method="post" action="sendMessageHandler.php">
                        <div class="textField">
                            <span class="material-symbols-outlined">send</span>
                            <input type="text" name="message" placeholder="Type Message">
                            <input type="hidden" name="toUser" value="<?php echo htmlspecialchars($user2); ?>" />
                        </div>
                        <input type="submit" name="sendMessageSubmit" hidden />
                    </form>
                    <?php
                    foreach($messages as $message) { 

                        if($message->messageTo == $user_id) { ?>
                            <div class="toMessage">
                                <a style="position: relative; z-index:1000" href="<?php echo "profile.php?username=" . $user_2->username;  ?>">
                                    <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $user_2->profile_image; ?>" alt="" class="img-user-post"/>
                                </a >
                                <p><?php echo $message->messageText; ?></p>
                                <div></div>
                            </div>
                        <?php } else { ?>
                            <div class="fromMessage">
                                <div></div>
                                <p><?php echo $message->messageText; ?></p>
                                <a style="position: relative; z-index:1000" href="<?php echo "profile.php?username=" . $user->username;  ?>">
                                    <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $user->profile_image; ?>" alt="" class="img-user-post"/>
                                </a >
                            </div>
                        <?php }

                    } ?>
                </div>
                <?php require_once 'mobileBar.php'; ?>
            </div>
        </div>
        <!--END FEED-->
        <!--RECOMMEND-->
        <?php require_once 'recommend.php'; ?>
        <!--END RECOMMEND-->
    </body>
 </html>