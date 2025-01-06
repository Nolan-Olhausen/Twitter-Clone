        <!--SIDEBAR-->
        <div class="sidebar">
            <img src="echoLogo.png" alt="Echolog Logo" style="margin-left:13px;width:40px;height:40px;">
            <a href="index.php">
                <?php if(strpos($_SERVER['REQUEST_URI'],'/index.php') !== false){ ?><div class="sidebarOption active"><?php } else { ?><div class="sidebarOption"><?php } ?>
                    <span class="material-symbols-outlined">home</span>
                    <h2>Home</h2>
                </div>
            </a>
            <a href="explore.php">
            <?php if(strpos($_SERVER['REQUEST_URI'],'/explore.php') !== false){ ?><div class="sidebarOption active"><?php } else { ?><div class="sidebarOption"><?php } ?>
                    <span class="material-symbols-outlined">search</span>
                    <h2>Explore</h2>
                </div>
            </a>
            <a href="messages.php">
            <?php if(strpos($_SERVER['REQUEST_URI'],'/messages.php') !== false){ ?><div class="sidebarOption active"><?php } else { ?><div class="sidebarOption"><?php } ?>
                    <span class="material-symbols-outlined">mail</span>
                    <h2>Messages</h2>
                </div>
            </a>
            <a href="<?php echo "profile.php?username=" . $user->username; ?>">
            <?php if(strpos($_SERVER['REQUEST_URI'],'/profile.php') !== false){ ?><div class="sidebarOption active"><?php } else { ?><div class="sidebarOption"><?php } ?>
                    <span class="material-symbols-outlined">account_circle</span>
                    <h2>Profile</h2>
                </div>
            </a>
            <a href="editAccount.php">
                <?php if(strpos($_SERVER['REQUEST_URI'],'/editAccount.php') !== false){ ?><div class="sidebarOption active"><?php } else { ?><div class="sidebarOption"><?php } ?>
                    <span class="material-symbols-outlined">more_vert</span>
                    <h2>Edit Account</h2>
                </div>
            </a>
            <a href="createPost.php">
                <button class="sidebarPost">Post</button>
            </a>
        </div>
        <!--END SIDEBAR-->