<!--
/****************************************************************************************************
 *
 * @file:    echo.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This is the front end for echoing a post.
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
    $postContent_id = $_GET['postContent_id'];
    $posts = $dao->status($postContent_id);
    $post_user = $dao->getDataUser($posts[0]->user_id);
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
        <title>Echo | Echolog</title>
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="bootstrap.js"></script>
        <script type="text/javascript" src="like.js"></script>
        <?php require_once 'sidebar.php'; ?>
        <!--FEED-->
        <div class="feed">
            <?php require_once 'searchBar.php'; ?>
            <div class="followingPosts">
                <div class="feedInner">
                    <div class="feedHeader">
                        <h2>Echo Post</h2>
                    </div>
                </div>
                <form method="post" action="echoHandler.php">
                    <div class="textField">
                        <span class="material-symbols-outlined">add_comment</span>
                        <input type="text" name="comment" placeholder="(Optional) Add a Comment" value="<?php echo isset($_SESSION['inputs']['comment']) ? $_SESSION['inputs']['comment'] : ""; ?>">
                        <input type="hidden" name="postContent_id" value="<?php echo htmlspecialchars($_GET['postContent_id']); ?>" />
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_GET['user_id']); ?>" />
                        <input type="hidden" name="user_echoed" value="<?php echo htmlspecialchars($_GET['user_echoed']); ?>" />
                        <input type="hidden" name="echo_sign" value="<?php echo htmlspecialchars($_GET['echo_sign']); ?>" />
                        <input type="hidden" name="echo_comment" value="<?php echo htmlspecialchars($_GET['echo_comment']); ?>" />
                        <input type="hidden" name="qoq" value="<?php echo htmlspecialchars($_GET['qoq']); ?>" />
                    </div>
                    <div class="finPost">
                        <button type="submit" name="echoSubmit" class="sidebarPost">Echo</button>
                    </div>
                </form>
                <?php require_once 'posts.php'; ?>
                <div class="con">
                    <?php 
                    foreach ($_SESSION['errors'] as $error) {
                        echo ' <div class="errorList">
                        <div class="error">' . $error . '</div>
                        </div>';
                    }
                    unset($_SESSION['errors']);      
                    ?>
                </div>
            </div>
            <?php require_once 'mobileBar.php'; ?>
            <?php unset($_SESSION['inputs']); ?>
        </div>
        <!--END FEED-->
        <!--RECOMMEND-->
        <?php require_once 'recommend.php'; ?>
        <!--END RECOMMEND--> 
    </body>
</html>