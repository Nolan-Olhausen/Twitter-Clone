<!--
/****************************************************************************************************
 *
 * @file:    posts.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This is the front end for the posts. It displays the posts on the feed or explore page.
 *
 ****************************************************************************************************/
-->

<?php
    $user_id = $_SESSION['user_id'];

    global $posts;

    foreach($posts as $post) { 

        $echo_sign = false;
        $echo_comment =false;
        $qoq = false;

        if ($dao->isPostContent($post->id)) {

            $post_user = $dao->getDataUser($post->user_id);
            $post_real = $dao->getPostContent($post->id);
            $timeAgo = $dao->getTimeAgo($post->posted_time) ; 
            $likes_count = $dao->countLikes($post->id);
            $user_like = $dao->userLike($user_id ,$post->id);
            $echoes_count = $dao->countEchoes($post->id);
            $user_echoed = $dao->userEchoed($user_id ,$post->id);

        } else if ($dao->isEcho($post->id)) {

            $echo = $dao->getEcho($post->id);
            if ($echo->echo_msg == null) {
                if ($echo->echo_id == null) {
        
                    $echoed_post = $dao->getPostContent($echo->postContent_id);
                    $post_user = $dao->getDataUser($echoed_post->user_id);
                    $post_real = $dao->getPostContent($echo->postContent_id);
                    $timeAgo = $dao->getTimeAgo($post_real->posted_time); 
                    $likes_count = $dao->countLikes($echo->postContent_id);
                    $user_like = $dao->userLike($user_id ,$echo->postContent_id);
                    $echoes_count = $dao->countEchoes($echo->postContent_id);
                    $user_echoed = $dao->userEchoed($user_id ,$echo->postContent_id); 
                    $echoed_user = $dao->getDataUser($echo->user_id);
                    $echo_sign = true;
                } else {

                    $echoed_post = $dao->getEcho($echo->echo_id);

                    if($echoed_post->postContent_id != null) {

                        $post_user = $dao->getDataUser($echoed_post->user_id);
                        $timeAgo = $dao->getTimeAgo($echoed_post->posted_time); 
                        $likes_count = $dao->countLikes($echoed_post->post_id);
                        $user_like = $dao->userLike($user_id ,$echoed_post->post_id);
                        $echoes_count = $dao->countEchoes($echoed_post->post_id);
                        $user_echoed = $dao->userEchoed($user_id ,$echoed_post->post_id);
                        $post_inner = $dao->getPostContent($echoed_post->postContent_id);
                        $user_inner_post = $dao->getDataUser($post_inner->user_id);
                        $timeAgo_inner = $dao->getTimeAgo($post_inner->posted_time); 
                        $echoed_user = $dao->getDataUser($post->user_id);
                        $echo_sign = true;
                        $quote = $echoed_post->echo_msg;
                        $echo_comment = true;
                    } else {

                        $echo_sign = true;
                        $post_user = $dao->getDataUser($echoed_post->user_id);
                        $timeAgo = $dao->getTimeAgo($echoed_post->posted_time); 
                        $likes_count = $dao->countLikes($echoed_post->post_id);
                        $user_like = $dao->userLike($user_id ,$echoed_post->post_id);
                        $echoes_count = $dao->countEchoes($echoed_post->post_id);
                        $user_echoed = $dao->userEchoed($user_id ,$echoed_post->post_id);
                        $qoq = true;
                        $quote = $echoed_post->echo_msg;
                        $post_inner = $dao->getEcho($echoed_post->echo_id);
                        $user_inner_post = $dao->getDataUser($post_inner->user_id);
                        $timeAgo_inner = $dao->getTimeAgo($post_inner->posted_time);
                        $inner_quote  = $post_inner->echo_msg;
                        $echoed_user = $dao->getDataUser($post->user_id);
                    }
            }

            } else {
                if ($echo->echo_id == null) {
                    $post_user = $dao->getDataUser($post->user_id);
                    $timeAgo = $dao->getTimeAgo($post->posted_time); 
                    $likes_count = $dao->countLikes($post->id);
                    $user_like = $dao->userLike($user_id ,$post->id);
                    $echoes_count = $dao->countEchoes($post->id);
                    $user_echoed = $dao->userEchoed($user_id ,$post->id);
                    $quote = $echo->echo_msg;
                    $echo_comment = true;
                    $post_inner = $dao->getPostContent($echo->postContent_id);
                    $user_inner_post = $dao->getDataUser($post_inner->user_id);
                    $timeAgo_inner = $dao->getTimeAgo($post_inner->posted_time); 
                } else {
                    $post_user = $dao->getDataUser($post->user_id);
                    $timeAgo = $dao->getTimeAgo($post->posted_time); 
                    $likes_count = $dao->countLikes($post->id);
                    $user_like = $dao->userLike($user_id ,$post->id);
                    $echoes_count = $dao->countEchoes($post->id);
                    $user_echoed = $dao->userEchoed($user_id ,$post->id);
                    $quote = $echo->echo_msg;
                    $qoq = true;
                    $post_inner = $dao->getEcho($echo->echo_id);
                    $user_inner_post = $dao->getDataUser($post_inner->user_id);
                    $timeAgo_inner = $dao->getTimeAgo($post_inner->posted_time);
                    $inner_quote = $post_inner->echo_msg;

                    if($inner_quote == null) {
                    
                        $post_inner2 = $dao->getEcho($post_inner->echo_id);
                        $inner_quote = $post_inner2->echo_msg;
                    }

                }

            }

        } 
        $post_link = $post->id;

        if($echo_sign) {
            $comment_count = $dao->countComments($echoed_post->id);
        } else  {
            $comment_count = $dao->countComments($post->id); 
        }
    ?>

    <div class="feed-post-box" style="position: relative;" >
        <a href="status.php?post_id=<?php echo $post_link; ?>">
            <span style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 1;"></span>
        </a>
        <?php if ($echo_sign) { ?>
            <span class="echoed-name"> <i class="echoed-name-inner" area-hidden="true"></i> 
            <a style="position: relative; z-index:100; color:rgb(102, 117, 130);" href="<?php echo "profile.php?username=" . $echoed_user->username; ?> "> <?php  if($echoed_user->id == $user_id) echo "You"; else echo $echoed_user->name; ?> </a>  echoed</span> <?php } ?>
            <div class="grid-post">
                <a style="position: relative; z-index:1000" href="<?php echo "profile.php?username=" . $post_user->username;  ?>">
                    <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $post_user->profile_image; ?>" alt="" class="img-user-post"/>
                </a >
                <div>
                    <p> 
                        <a style="position: relative; z-index:1000; color:#ffffff" class="bangers-regular" href="<?php echo "profile.php?username=" . $post_user->username; ?>">
                            <?php echo $post_user->name ?> 
                        </a>
                        <span class="username-echolog">@<?php echo $post_user->username ?> </span>
                        <span class="username-echolog"><?php echo $timeAgo ?></span>
                    </p>
                    <p class="post-links"><?php
                            if ($echo_comment || $qoq)
                            echo  $dao->getPostLinks($quote);
                            else echo  $dao->getPostLinks($post_real->text); ?></p>
                    <?php if ($echo_comment == false && $qoq == false) { ?>
                    <?php if ($post_real->img != null) { ?>
                    <p class="marTop-post">
                        <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $post_real->img; ?>" alt="" class="img-post-width"/>
                        
                    </p>
                    <?php } } else { ?>
                        <div  class="marTop-post comment-post" style="position: relative;">
                            <a href="status.php?post_id=<?php echo $post_inner->id; ?>">
                                <span class="" style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 2;"></span>
                            </a>
                            <div class="grid-post py-3"> 
                                <a style="position: relative; z-index:1000" href="<?php echo "profile.php?username=" . $user_inner_post->username;  ?>">
                                    <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $user_inner_post->profile_image; ?>" alt="" class="img-user-post"/>
                                </a >
                            <div>
                            <p> 
                                <a style="position: relative; z-index:1000; color:#ffffff" class="bangers-regular" href="<?php echo "profile.php?username=" . $user_inner_post->username;  ?>">
                                    <?php echo $user_inner_post->name ?>
                                </a>
                                <span class="username-echolog">@<?php echo $user_inner_post->username ?> </span>
                                <span class="username-echolog"><?php echo $timeAgo_inner ?></span>
                            </p>
                            <p class="post-links"><?php
                                    if ($qoq) {
                                        echo $dao->getPostLinks($inner_quote);
                                    } else  {
                                        echo  $dao->getPostLinks($post_inner->text);
                                    } 
                                ?></p>
                            <?php
                                if ($qoq == false) { 
                                    if ($post_inner->img != null) { 
                            ?>
                            <p class="marTop-post">
                                <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $post_inner->img; ?>" alt="" class="img-post-width"/>
                            </p>
                            <?php } } ?>
                        </div> 
                </div>
            </div>
            <?php } ?>

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
                <?php 
                if($user_id == $post->user_id) { ?>
                    <div class="grid-box-stat">
                        <a href="<?php echo "deletePostHandler.php?post_id=" . $post->id; ?>">
                            <span class="material-symbols-outlined hover-stat hover-stat-comment">delete</span>
                        </a>
                    </div><?php
                } else {

                }?>
            </div>
        </div>
        </div>
    </div>
<?php } ?>