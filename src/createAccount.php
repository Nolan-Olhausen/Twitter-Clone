<!--
/****************************************************************************************************
 *
 * @file:    createAccount.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the front end for creating an account. It takes the user's name, email, username, and password.
 *
 ****************************************************************************************************/
-->

<?php 
    session_start();
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
        <title>Create Account | Echolog</title>
    </head>
    <body>
        <form method="post" action="createAccountHandler.php">
            <div class="box">
                <h2>Create Account</h2>
                <div class="textField">
                    <span class="material-symbols-outlined">person</span>
                    <input type="text" name="name" placeholder="Name" value="<?php echo isset($_SESSION['inputs']['name']) ? $_SESSION['inputs']['name'] : ""; ?>">
                </div>
                <div class="textField">
                    <span class="material-symbols-outlined">mail</span>
                    <input type="text" name="email" placeholder="Email" value="<?php echo isset($_SESSION['inputs']['email']) ? $_SESSION['inputs']['email'] : ""; ?>">
                </div>
                <div class="textField">
                    <span class="material-symbols-outlined">person</span>
                    <input type="text" name="username" placeholder="Username" value="<?php echo isset($_SESSION['inputs']['username']) ? $_SESSION['inputs']['username'] : ""; ?>">
                </div>
                <div class="textField">
                    <span class="material-symbols-outlined">lock</span>
                    <input type="password" name="password" placeholder="Password">
                </div>
            </div>
            <div class="buttonContainer">
                <button type="submit" name="createAccount" class="button">Create</button>
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