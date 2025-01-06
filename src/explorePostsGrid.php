<!--
/****************************************************************************************************
 *
 * @file:    explorePostsGrid.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the grid for the explore page. It displays all the posts in a grid format.
 *
 ****************************************************************************************************/
-->

<?php

    global $posts;
    
?>
    <div class="grid-explore-outer" style="position: relative;">

        <?php foreach($posts as $post) { 

            if ($dao->isPostContent($post->id)) {

                $post_user = $dao->getDataUser($post->user_id);
                $post_id = $dao->getPostContent($post->id);
                $timeAgo = $dao->getTimeAgo($post->posted_time) ; 
                $likes_count = $dao->countLikes($post->id);
                $user_like = $dao->userLike($user_id ,$post->id);
                $echoes_count = $dao->countEchoes($post->id);
                $user_echoed = $dao->userEchoed($user_id ,$post->id);

            } else {
                continue;
            } 
            $post_link = $post->id;
            $comment_count = $dao->countComments($post->id); 
        ?>
            <div class="explore-post-box" style="position: relative;" >
                <a href="status.php?post_id=<?php echo $post_link; ?>">
                    <span style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 1;"></span>
                </a>
                <div class="grid-explore">
                    <div class="grid-explore-top">
                        <a style="position: relative; z-index:1000" href="<?php echo "profile.php?username=" . $post_user->username;  ?>">
                            <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $post_user->profile_image; ?>" alt="" class="img-user-post"/>
                        </a>
                        <p> 
                            <a style="position: relative; z-index:1000; color:#ffffff" class="bangers-regular" href="<?php echo "profile.php?username=" . $post_user->username; ?>">
                                <?php echo $post_user->name ?>
                            </a>
                            <br>
                            <span class="username-echolog">@<?php echo $post_user->username ?> </span>
                            <span class="username-echolog"><?php echo $timeAgo ?></span>
                        </p>
                    </div>
                    <div>  
                        <p class="post-links"><?php
                            echo  $dao->getPostLinks($post_id->text);
                            ?></p>
                        <?php 
                        if ($post_id->img != null) { 
                        ?>
                            <p class="marTop-post">
                                <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $post_id->img; ?>" alt="" class="img-post-width"/>   
                            </p>
                        <?php }?>
                        <div class="grid-stats">
                <div class="grid-box-stat">
                    <a href="status.php?post_id=<?php if($echo_sign)echo $echoed_post->id;else  echo $post->id; ?>">
                        <span class="material-symbols-outlined hover-stat hover-stat-comment">mode_comment</span>
                        <p class="mar-counter"> <?php if($comment_count > 0) echo $comment_count; ?> </p>
                    </a>
                </div>
                <div class="grid-box-stat">
                    <a href="echo.php?postContent_id=<?php echo $post->id ;?>&user_id=<?php echo $user_id; ?>&user_echoed=<?php echo $dao->checkInput($user_echoed); ?>&echo_sign=<?php echo $dao->checkInput($echo_sign); ?>&echo_comment=<?php echo $dao->checkInput($echo_comment); ?>&qoq=<?php echo $dao->checkInput($qoq); ?>" class="<?= $user_echoed ? 'echoed' : 'echo' ?>">
                        <span class="material-symbols-outlined hover-stat hover-stat-echo <?= $user_echoed ? 'echoed' : 'echo' ?>">record_voice_over</span>
                        <p class="mar-counter"> <?php if($echoes_count > 0)  echo $echoes_count ; ?> </p>
                    </a>
                </div>
                <div  class="grid-box-stat">
                    <a class="<?= $user_like ? 'unlike-btn' : 'like-btn' ?>" 
                        data-post="<?php 
                        if($echo_sign) {
                            if($echo->postContent_id != null) {
                                echo $echo->postContent_id;
                            } echo $echo->echo_id;
                        }  else echo $post->id;
                        ?>" 
                        data-user="<?php echo $user_id; ?>">
                        <span class="material-symbols-outlined hover-stat hover-stat-like <?= $user_like ? 'unlike-symbol' : 'like-symbol' ?>">favorite</span>
                        <p class="mar-counter"> <?php if($likes_count > 0)  echo $likes_count ; ?> </p>
                    </a>
                </div>
            </div>
                    </div> 
                </div>
            </div>
        <?php } ?>
    </div>