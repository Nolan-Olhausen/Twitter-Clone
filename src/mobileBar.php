            <!--MOBILEBAR-->
            <div class="mobilebar">
                <a href="index.php">
                    <div class="mobilebarOption">
                        <span class="material-symbols-outlined">home</span>
                    </div>
                </a>
                <a href="explore.php">
                    <div class="mobilebarOption">
                        <span class="material-symbols-outlined">search</span>
                    </div>
                </a>
                <a href="messages.php">
                    <div class="mobilebarOption">
                        <span class="material-symbols-outlined">mail</span>
                    </div>
                </a>
                <a href="<?php echo "profile.php?username=" . $user->username; ?>">
                    <div class="mobilebarOption">
                        <span class="material-symbols-outlined">account_circle</span>
                    </div>
                </a>
                <a href="editAccount.php">
                    <div class="mobilebarOption">
                        <span class="material-symbols-outlined">more_vert</span>
                    </div>
                </a>
            </div>
            <!--END MOBILEBAR-->