<!--
/****************************************************************************************************
 *
 * @file:    login.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This is the front end for the login page. It takes the user's username/email and password 
 *      and sends it to the loginHandler.php file.
 *
 ****************************************************************************************************/
-->

<?php 
    session_start(); 
    require_once ('Dao.php'); 
    $dao = new Dao();
    if ($dao->checkLogIn() === true) {
        header("Location: index.php");
    }
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!--<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />-->
        <link rel="preload" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" media="all" onload="this.media='all'" rel="stylesheet" type="text/css" as="style" crossorigin="anonymous" data-font-display="block">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Nanum+Gothic&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles2.css" />
        <link rel='shortcut icon' type='image/png' href='favicon-32x32.png'/>
        <title>Login / Echolog</title>
    </head>
    <body>
        <form method="post" action="loginHandler.php">
            <div class="box">
                <div class="centerImage">
                    <img src="echoLogo.png" alt="Echolog Logo" style="width:80px;height:80px;">
                </div>
                <div class="textField">
                    <span class="material-symbols-outlined">person</span>
                    <input type="text" name="username/email" placeholder="Username/Email" value="<?php echo isset($_SESSION['inputs']['username/email']) ? $_SESSION['inputs']['username/email'] : ""; ?>">
                </div>
                <div class="textField">
                    <span class="material-symbols-outlined">lock</span>
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div class="links">
                    <div class="createLink">
                        <a href="createAccount.php">Create Account</a>
                    </div>
                </div>
            </div>
            <div class="buttonContainer">
                <input type="submit" name="login" value="Login" class="button">
            </div>
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
    </body>
 </html>