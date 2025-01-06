<!--
/****************************************************************************************************
 *
 * @file:    comments.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the comments section for a post. It displays all the comments for a post.
 *
 ****************************************************************************************************/
-->

<?php

    global $comments;

    //display each comment
    foreach($comments as $comment) { 
        $cUser_id = $comment->user_id;
        $cUser = $dao->getDataUser($cUser_id);
        $timeAgo = $dao->getTimeAgo($comment->comment_time); ?>
        <div class="feed-post-box" style="position: relative;" >
            <div class="grid-post">
                <a style="position: relative; z-index:1000" href="<?php echo "profile.php?username=" . $cUser->username;  ?>">
                    <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $cUser->profile_image; ?>" alt="" class="img-user-post"/>
                </a >
                <div>
                    <p> 
                        <a style="position: relative; z-index:1000; color:#ffffff" class="bangers-regular" href="<?php echo "profile.php?username=" . $cUser->username; ?>">
                            <?php echo $cUser->name ?>
                        </a>
                        <span class="username-echolog">@<?php echo $cUser->username ?> </span>
                        <span class="username-echolog"><?php echo $timeAgo ?></span>
                    </p>
                    <p class="post-links"><?php
                            echo  $comment->comment_text;
                        ?>       
                    </p>
                </div>
            </div>
        </div>
    <?php } ?>