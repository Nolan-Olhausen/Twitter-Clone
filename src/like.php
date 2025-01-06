<?php
	session_start(); 
    require_once 'Dao.php'; 
    $dao = new Dao();
	
    if(isset($_POST['like']) && !empty($_POST['like'])){
    	$user_id  = $_SESSION['user_id'];
		$post_id = $_POST['like'];

        if (!$dao->userLike($user_id, $post_id)) {
            $dao->create('likes', array('user_id' => $user_id, 'post_id' => $post_id));
        } else {
			$dao->unLike($user_id, $post_id);
		}	

		echo `<div class="tmp d-none">
             `+ $dao->countLikes($post_id) +`            
		</div>` ;
		unset($_POST['like']);
	}
?>