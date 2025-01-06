<!--
/****************************************************************************************************
 *
 * @file:    searchMessageHandler.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the handler for searching messages. It takes the search input from the user and validates it.
 *
 ****************************************************************************************************/
-->

<?php 
     session_start(); 
     require_once 'Dao.php'; 
     $dao = new Dao();

    if (isset($_POST['searchMessageSubmit'])) {
        $search =  $dao->checkInput($_POST['searchText']);
        header("Location: searchMessageResults.php?search=".$search);
    }
?>