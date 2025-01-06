<!--
/****************************************************************************************************
 *
 * @file:    logout.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file logs the user out of the website.
 *
 ****************************************************************************************************/
-->

<?php 
    session_start();
    require_once ('Dao.php'); 

    $dao = new Dao();

    $dao->logout();
   
?>