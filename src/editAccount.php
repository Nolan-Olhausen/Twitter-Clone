<!--
/****************************************************************************************************
 *
 * @file:    editAccount.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the edit account page. It allows the user to edit their account information.
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
        <title>Edit Account / Echolog</title>
        <script type="text/javascript" src="characterCounter.js"></script>
    </head>
    <body>
        <?php require_once 'sidebar.php'; ?>
        <!--FEED-->
        <div class="edit-Account">
            <form method="post" action="editAccountHandler.php" enctype="multipart/form-data">
                <div class="feedInner">
                    <div class="feedHeader">
                        <h2>Edit Account/Profile</h2>
                    </div>
                </div>
                <label for="editName">Name:</label>
                <div class="textField">
                    <span class="material-symbols-outlined">person</span>
                    <input onkeyup="textCounter(this,'cCounter2',20);" type="text" name="name" id="editName" placeholder="Name" value="<?php echo isset($_SESSION['inputs']['name']) ? $_SESSION['inputs']['name'] : ""; ?>">
                </div>
                <input disabled  maxlength="3" size="3" value="20" id="cCounter2">
                <label for="editBio">Bio:</label>
                <div class="textField">
                    <span class="material-symbols-outlined">description</span>
                    <textarea onkeyup="textCounter(this,'cCounter3',140);" name="bioProf" id="editBio" rows="6" cols="80" placeholder="Bio"><?php echo isset($_SESSION['inputs']['bioProf']) ? $_SESSION['inputs']['bioProf'] : ""; ?></textarea>
                </div>
                <input disabled  maxlength="3" size="3" value="140" id="cCounter3">
                <label for="editImage">Profile Picture (use square image for best results):</label>
                <div id="editImage" class="imageUploadButton">
                    <label class="customButton" for="editImageButton">Upload</label>
                    <input id="editImageButton" type="file" name="profile_img"> 
                </div>
                <div class="finPost">
                    <button type="submit" name="update" class="sidebarPost">Update</button>
                </div>
            </form>
            <div class="con">
                <?php 
                foreach ($_SESSION['errors'] as $error) {
                    echo ' <div class="errorList">
                    <div class="error">' . $error . '</div>
                    </div>';
                }
                unset($_SESSION['inputs']);
                unset($_SESSION['errors']);      
                ?>
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