<!--
/****************************************************************************************************
 *
 * @file:    searchHandler.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the handler for searches. It takes the search from the user.
 *
 ****************************************************************************************************/
-->

<?php 
     session_start(); 
     require_once 'Dao.php'; 
     $dao = new Dao();

    if (isset($_POST['searchSubmit'])) {
        $search =  $dao->checkInput($_POST['searchText']);
        header("Location: searchResults.php?search=".$search);
    }
?>