<!--
/****************************************************************************************************
 *
 * @file:    createPost.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This is the front end for creating a post. It allows the user to create a post and upload an image.
 *
 ****************************************************************************************************/
-->

<?php 
    session_start(); 
    require_once 'Dao.php'; 
    require_once 'Validator.php';
    $dao = new Dao();
    if ($dao->checkLogIn() === false) {
        header("Location: login.php");
    }
    $user_id = $_SESSION['user_id'];
    $user = $dao->getDataUser($user_id);
    $who_users = $dao->whoToFollow($user_id);
?>
<html>
    <head>
        <meta charset="utf8mb4">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!--<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />-->
        <link rel="preload" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" media="all" onload="this.media='all'" rel="stylesheet" type="text/css" as="style" crossorigin="anonymous" data-font-display="block">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Nanum+Gothic&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles.css" />
        <link rel='shortcut icon' type='image/png' href='favicon-32x32.png'/>
        <title>Post | Echolog</title>
        <script type="text/javascript" src="characterCounter.js"></script>
    </head>
    <body>
        <?php require_once 'sidebar.php'; ?>
        <!--POST-->
        <div class="createPost">
            <div class="feedInner">
                <div class="feedHeader">
                    <h2>Create Post</h2>
                </div>
            </div>
                <form action="postHandler.php" method="post" enctype="multipart/form-data">
                    <div class="createPostInner">
                        <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $user->profile_image ?>" alt="user-pfp" class="img-user-post">
                        <div class="createPostRight">
                            <div class="textField">
                                <textarea onkeyup="textCounter(this,'cCounter',140);" class="text-whatshappening" name="status" rows="8" cols="80" placeholder="What's happening?"><?php echo isset($_SESSION['inputs']['status']) ? $_SESSION['inputs']['status'] : ""; ?></textarea>
                            </div>
                            <input disabled  maxlength="3" size="3" value="140" id="cCounter">
                            <div class="imageUploadButton">
                                <label class="customButton" for="editImageButton">Upload</label>
                                <input id="editImageButton" type="file" name="post_img"> 
                            </div>
                        </div>
                    </div>
                    <div class="finPost">
                        <button type="submit" name="post" class="sidebarPost">Post</button>
                    </div>
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
                </form>
            <?php require_once 'mobileBar.php'; ?>
        </div>
        <!--END POST-->
        <!--RECOMMEND-->
        <?php require_once 'recommend.php'; ?>
        <!--END RECOMMEND-->
    </body>
 </html>