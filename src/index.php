<!--
/****************************************************************************************************
 *
 * @file:    index.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the home page for the website. It displays the user's feed and allows them to create posts.
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
    $posts = $dao->posts($user_id);
    $who_users = $dao->whoToFollow($user_id);
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
        <title>Home / Echolog</title>
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
                    <h2 class="monoton-regular">Following</h2>
                </div>
            </div>
            <div class="followingPosts">
                <?php include 'posts.php'; ?>
                <div class="mobilePost">
                    <a href="createPost.php">
                        <button class="mobilePostButton"><span class="material-symbols-outlined">add_circle</span></button>
                    </a>
                </div>
            </div>
            <?php require_once 'mobileBar.php'; ?>
        </div>
        <!--END FEED-->
        <!--RECOMMEND-->
        <?php require_once 'recommend.php'; ?>
        <!--END RECOMMEND-->
    </body>
 </html>