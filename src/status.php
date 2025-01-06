<!--
/****************************************************************************************************
 *
 * @file:    status.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This is the front end for the status page. It allows the user to view a status and comment on it.
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
    $post_id = $_GET['post_id'];
    $posts = $dao->status($post_id);
    $comments = $dao->comments($post_id);
    $who_users = $dao->whoToFollow($user_id);
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!--<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />-->
        <link rel="preload" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" as="style" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" media="all" crossorigin="anonymous" rel="stylesheet" type="text/css" as="style" data-font-display="block">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Nanum+Gothic&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles.css" />
        <link rel='shortcut icon' type='image/png' href='favicon-32x32.png'/>
        <title>Status | Echolog</title>
        <script type="text/javascript" src="characterCounter.js"></script>
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="bootstrap.js"></script>
        <script type="text/javascript" src="like.js"></script>
        <?php require_once 'sidebar.php'; ?>
        <!--FEED-->
        <div class="feed">
            <?php require_once 'searchBar.php'; ?>
            <div class="feedInner">
                <div class="feedHeader">
                    <h2 class="monoton-regular">Status</h2>
                </div>
            </div>
            <div class="followingPosts">
                <?php include 'posts.php'; ?>
                <form method="post" action="commentHandler.php">
                    <div class="textField">
                        <span class="material-symbols-outlined">add_comment</span>
                        <input onkeyup="textCounter(this,'cCounter',140);" type="text" name="comment" placeholder="Add a Comment" value="<?php echo isset($_SESSION['inputs']['comment']) ? $_SESSION['inputs']['comment'] : ""; ?>">
                        <input type="hidden" name="postId" value="<?php echo htmlspecialchars($_GET['post_id']); ?>" />
                    </div>
                    <input disabled  maxlength="3" size="3" value="140" id="cCounter">
                    <input type="submit" name="commentSubmit" hidden />
                </form>
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
                <div class="feedInner">
                    <div class="feedHeader">
                        <h2>Comments</h2>
                    </div>
                </div>
                <?php include 'comments.php'; ?>
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