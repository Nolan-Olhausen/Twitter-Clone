        <div class="recommend">
            <div class="followRec">
            <h2>Recommended Follows</h2>
                <?php 
                foreach($who_users as $user) { 
                ?>
                    <div class="grid-follow">
                        <a style="position: relative; z-index:5; color:black" href="<?php echo "profile.php?username=" . $user->username; ?>">
                            <img src="https://echologbucket.s3.us-west-2.amazonaws.com/<?php echo $user->profile_image; ?>" alt="" class="img-follow"/>
                        </a>
                        <div>
                            <p>
                                <a style="position: relative; z-index:5; color:#ffffff" class="bangers-regular" href="<?php echo "profile.php?username=" . $user->username; ?>">  
                                    <?php echo $user->name; ?>
                                </a>
                            </p>
                            <p class="username">@<?php echo $user->username; ?>
                            <br>
                                <?php if ($dao->FollowsYou($user->id , $user_id)) { ?>
                                    <span class="follows-you">Follows You</span></p>
                                <?php } ?>
                            </p>
                        </div>
                        <div>
                            <a href="<?php echo "followUnfollowHandler.php?prevLink=index.php&follow_id=" . $user->id; ?>" class="follow-btn" style="font-weight: 700;">
                                Follow
                            </a>
                        </div>
                    </div>
                <?php }?>
            </div>
            <?php require_once 'footer.php'; ?>
        </div>