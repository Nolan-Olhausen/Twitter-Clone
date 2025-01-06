<?php
    define("BASE_URL" , "https://echologsocial-163db2a952ac.herokuapp.com/");
    class Dao {

//DATABASE RELATED
        private $hostname = 'odrj80.stackhero-network.com';
        private $port = '6037';
        private $user = 'root';
        private $password = '7ZuTJeOD48Xz1iymXmq2wG2YRYgndYK9';
        private $database = 'root';

        private $options = array(
            // See below if you have an error like "Uncaught PDOException: PDO::__construct(): SSL operation failed with code 1. OpenSSL Error messages: error:0A000086:SSL routines::certificate verify failed".
            PDO::MYSQL_ATTR_SSL_CAPATH => '/etc/ssl/certs/',
            // PDO::MYSQL_ATTR_SSL_CA => 'isrgrootx1.pem',
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
          );

        public function __construct () {
            
        }

        public function getConnection () {
            try {
                $connect = new PDO(
                    "mysql:host={$this->hostname};port={$this->port};dbname={$this->database}",
                    $this->user,
                    $this->password,
                    $this->options
                );
                error_log("Connected successfully.");
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            return $connect;
        }
//END DATABASE
        
//FOLLOW RELATED
        public function countFollowers($user_id) {

            $stmt = $this->getConnection()->prepare("SELECT COUNT(receiver) AS count FROM `follow` WHERE receiver = :user_id");
            $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_OBJ);
            return $count->count;
        }

        public function countFollowing($user_id) {

            $stmt = $this->getConnection()->prepare("SELECT COUNT(sender) AS count FROM `follow` WHERE sender = :user_id");
            $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_OBJ);
            return $count->count;
        }

        public function userFollow($user_id ,$user2_id){
                
            $stmt = $this->getConnection()->prepare("SELECT `sender` , `receiver` FROM `follow` WHERE `sender` = :user_id AND `receiver` = :user2_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":user2_id", $user2_id, PDO::PARAM_INT);
            $stmt->execute(); 

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }

        }
        
        public function usersFollowing($user_id){
                
            $stmt = $this->getConnection()->prepare("SELECT `receiver` AS user_id FROM `follow` WHERE sender = :user_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute(); 

            return $stmt->fetchAll(PDO::FETCH_OBJ);

        }

        public function usersFollowers($user_id){
                
            $stmt = $this->getConnection()->prepare("SELECT `sender` as user_id FROM `follow` WHERE receiver = :user_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute(); 

            return $stmt->fetchAll(PDO::FETCH_OBJ);

        }

        public function unFollow($user_id , $user2){
            $stmt = $this->getConnection()->prepare("DELETE FROM `follow` WHERE sender = :sender_id AND receiver = :receiver_id");
            $stmt->bindParam(":sender_id" , $user_id , PDO::PARAM_STR);
            $stmt->bindParam(":receiver_id" , $user2 , PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function whoToFollow($user_id){

            $stmt = $this->getConnection()->prepare("SELECT * FROM `users` WHERE `id` != :user_id AND `id` NOT IN (SELECT `receiver` FROM `follow` WHERE `sender` = :user_id) ORDER BY rand() LIMIT 3");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute(); 
            return $stmt->fetchAll(PDO::FETCH_OBJ);	
        }

        public function followsYou($profile_id , $user_id){
            $stmt = $this->getConnection()->prepare("SELECT * FROM `follow` WHERE `sender` = :profile_id AND `receiver` = :user_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":profile_id", $profile_id, PDO::PARAM_INT);
            $stmt->execute(); 
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
//END FOLLOW

//POST RELATED
        public function posts($user_id) {
                    
            $stmt = $this->getConnection()->prepare("SELECT * from `posts` WHERE user_id = :user_id OR user_id IN (SELECT receiver from `follow` WHERE sender = :user_id) ORDER BY posted_time DESC");
            $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function status($id) {
            $stmt = $this->getConnection()->prepare("SELECT * from `posts` WHERE `id` = :id");
            $stmt->bindParam(":id" , $id , PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }  

        public function searchPosts($search){
            $stmt = $this->getConnection()->prepare("SELECT A.* FROM posts A WHERE (A.id in (SELECT B.post_id FROM postContent B WHERE B.text LIKE ?)) OR ( A.user_id in (SELECT C.id FROM users C WHERE C.username LIKE ? OR C.name LIKE ?)) ORDER BY posted_time DESC");
            $stmt->bindValue(1, '%'.$search.'%', PDO::PARAM_STR);
            $stmt->bindValue(2, '%'.$search.'%', PDO::PARAM_STR);
            $stmt->bindValue(3, '%'.$search.'%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } 

        public function explorePosts($user_id) {
            
            $stmt = $this->getConnection()->prepare("SELECT * from `posts` WHERE user_id != :user_id ORDER BY RAND()");
            $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function postsUser($user_id) {

            $stmt = $this->getConnection()->prepare("SELECT * from `posts` WHERE user_id = :user_id ORDER BY posted_time DESC");
            $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function comments($postContent_id) {

            $stmt = $this->getConnection()->prepare("SELECT * from `comments` WHERE post_id = :postContent_id ORDER BY comment_time DESC");
            $stmt->bindParam(":postContent_id" , $postContent_id , PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function isPostContent($postContent_id){
                
            $stmt = $this->getConnection()->prepare("SELECT * FROM `postContent` WHERE `post_id` = :postContent_id");
            $stmt->bindParam(":postContent_id", $postContent_id, PDO::PARAM_INT);
            $stmt->execute(); 

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function isEcho($postContent_id){
                
            $stmt = $this->getConnection()->prepare("SELECT * FROM `echoes` WHERE `post_id` = :postContent_id");
            $stmt->bindParam(":postContent_id", $postContent_id, PDO::PARAM_INT);
            $stmt->execute(); 

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }

        }

        public static function getTimeAgo($timestamp){

            date_default_timezone_set("America/Denver");
                
            $time_ago = strtotime($timestamp);
            $current_time = strtotime(date("Y-m-d H:i:s")); 
            $time_difference = $current_time - $time_ago;
            $seconds = $time_difference;
                
            $minutes = round($seconds / 60);
            $hours = round($seconds / 3600);
            $days = round($seconds / 86400); 
            $weeks = round($seconds / 604800);
            $months = round($seconds / 2629440);
            $years = round($seconds / 31553280);
                    
            if ($seconds <= 60){
                return "just now";
            } else if ($minutes <= 60) {
                if ($minutes == 1){
                    return "one minute ago";
                } else {
                    return "$minutes minutes ago";
                }
            } else if ($hours <= 24){
                if ($hours == 1){
                    return "an hour ago";
                } else {
                    return "$hours hrs ago";
                }
            } else if ($days <= 7){
                if ($days == 1){
                    return "yesterday";
                } else {
                    return "$days days ago";
                }
            } else if ($weeks <= 4.5){
                if ($weeks == 1){
                    return "a week ago";
                } else {
                    return "$weeks weeks ago";
                }
            } else if ($months <= 12){
                if ($months == 1){
                    return "a month ago";
                } else {
                    return "$months months ago";
                }
            } else {
                if ($years == 1){
                    return "one year ago";
                } else {
                    return "$years years ago";
                }
            }
        }
            
        public function countLikes($post_id) {

            $stmt = $this->getConnection()->prepare("SELECT COUNT(post_id) AS count FROM `likes` WHERE post_id = :post_id");
            $stmt->bindParam(":post_id" , $post_id , PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_OBJ);
            return $count->count;
        }

        public function countPosts($user_id) {

            $stmt = $this->getConnection()->prepare("SELECT COUNT(user_id) AS count FROM `posts` WHERE user_id = :user_id");
            $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_OBJ);
            return $count->count;
        }

        public function countComments($post_id) {

            $stmt = $this->getConnection()->prepare("SELECT COUNT(post_id) AS count FROM `comments` WHERE post_id = :post_id");
            $stmt->bindParam(":post_id" , $post_id , PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_OBJ);
            return $count->count;
        }

        public function countEchoes($postContent_id) {

            $stmt = $this->getConnection()->prepare("SELECT COUNT(*) AS count FROM `echoes` WHERE (`postContent_id` = :postContent_id OR `echo_id` = :postContent_id) GROUP BY postContent_id , echo_id");
            $stmt->bindParam(":postContent_id" , $postContent_id , PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $count = $stmt->fetch(PDO::FETCH_OBJ);
                return $count->count;
            } else return false;
                
        }

        public function unLike($user_id, $postContent_id){
                
            $stmt = $this->getConnection()->prepare("DELETE FROM `likes` WHERE `user_id` = :user_id AND `post_id` = :postContent_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":postContent_id", $postContent_id, PDO::PARAM_INT);
            $stmt->execute(); 

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }

        }

        public function userLike($user_id, $postContent_id){
                
            $stmt = $this->getConnection()->prepare("SELECT `post_id` , `user_id` FROM `likes` WHERE `user_id` = :user_id AND `post_id` = :postContent_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":postContent_id", $postContent_id, PDO::PARAM_INT);
            $stmt->execute(); 

            if ($stmt->rowCount() > 0) {
                return true;
            } else return false;

        }

        public function usersLiked($postContent_id){
                
            $stmt = $this->getConnection()->prepare("SELECT `post_id` , `user_id` FROM `likes` WHERE  `post_id` = :postContent_id");
            $stmt->bindParam(":postContent_id", $postContent_id, PDO::PARAM_INT);
            $stmt->execute(); 

            return $stmt->fetchAll(PDO::FETCH_OBJ);

        }

        public function userEchoed($user_id ,$postContent_id){
                
            $stmt = $this->getConnection()->prepare("SELECT `id` , `user_id` FROM `posts` JOIN `echoes` ON id = post_id WHERE `user_id` = :user_id AND (`postContent_id` = :postContent_id OR `echo_id` = :postContent_id) AND echo_msg IS NULL");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":postContent_id", $postContent_id, PDO::PARAM_INT);
            $stmt->execute(); 

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }

        }

        public function usersEchoed($postContent_id){
                
            $stmt = $this->getConnection()->prepare("SELECT `id` , `user_id` FROM `posts` JOIN `echoes` ON id = post_id WHERE (`postContent_id` = :postContent_id OR `echo_id` = :postContent_id) AND echo_msg IS NULL");
            $stmt->bindParam(":postContent_id", $postContent_id, PDO::PARAM_INT);
            $stmt->execute(); 

            return $stmt->fetchAll(PDO::FETCH_OBJ);

        }
            
        public function checkEcho($user_id ,$postContent_id){
                
            $stmt = $this->getConnection()->prepare("SELECT `id` , `user_id` FROM `posts` JOIN `echoes` ON id = post_id WHERE `user_id` = :user_id AND `post_id` = :postContent_id  AND echo_msg IS NULL");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":postContent_id", $postContent_id, PDO::PARAM_INT);
            $stmt->execute(); 

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }

        }

        public function deletePost($post_id) {
            $stmt = $this->getConnection()->prepare("DELETE FROM `posts` WHERE `id` = :post_id");
            $stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
            $stmt->execute(); 

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function undoEcho($user_id , $postContent_id) {
                
            $stmt = $this->getConnection()->prepare("DELETE FROM `posts` WHERE `user_id` = :user_id and `id` = :postContent_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":postContent_id", $postContent_id, PDO::PARAM_INT);
            $stmt->execute(); 

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function echoPostID($postContent_id , $user_id) {

            $stmt = $this->getConnection()->prepare("SELECT post_id FROM echoes JOIN posts ON id = post_id WHERE (postContent_id = :postContent_id OR echo_id = :postContent_id) AND `user_id` = :user_id");
            $stmt->bindParam(":postContent_id" , $postContent_id , PDO::PARAM_STR);
            $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
            $stmt->execute();
            $id = $stmt->fetch(PDO::FETCH_OBJ);
            return $id->post_id;
        }

        public function likedPostID($postContent_id) {

            $stmt = $this->getConnection()->prepare("SELECT postContent_id FROM echoes WHERE post_id = :postContent_id");
            $stmt->bindParam(":postContent_id" , $postContent_id , PDO::PARAM_STR);
            $stmt->execute();
            $id = $stmt->fetch(PDO::FETCH_OBJ);
            return $id->postContent_id;
        }

        public function getPostContent($postContent_id){
            $stmt = $this->getConnection()->prepare("SELECT * FROM `postContent` JOIN `posts` ON posts.id = postContent.post_id WHERE `post_id` = :postContent_id");
            $stmt->bindParam(":postContent_id", $postContent_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function getComment($postContent_id){
            $stmt = $this->getConnection()->prepare("SELECT * FROM `comments` WHERE `id` = :postContent_id");
            $stmt->bindParam(":postContent_id", $postContent_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function getEcho($postContent_id){
            $stmt = $this->getConnection()->prepare("SELECT * FROM `echoes` JOIN `posts` ON id = post_id WHERE `post_id` = :postContent_id");
            $stmt->bindParam(":postContent_id", $postContent_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } 

        public function getDataPost($id) {
            $stmt = $this->getConnection()->prepare("SELECT * from `posts` WHERE `id` = :id");
            $stmt->bindParam(":id" , $id , PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }  

        public static function getPostLinks($post){
            
            return $post;		
        }
//END POST

//USER + GENERAL RELATED
        public function getAllChats($user_id) {
            $stmt = $this->getConnection()->prepare("SELECT  sender.id AS sender_user
            ,recipient.id AS recipient_user
            ,messageTime
            ,messageText
            FROM messages
            INNER JOIN users AS sender ON sender.id = messageFrom
            INNER JOIN users AS recipient ON recipient.id = messageTo
            INNER JOIN ( SELECT MAX(id) AS most_recent_message_id
                        FROM   messages
                        GROUP BY CASE WHEN messageFrom > messageTo
                                        THEN messageTo
                                        ELSE messageFrom
                                END -- low_id
                                ,CASE WHEN messageFrom < messageTo
                                    THEN messageTo
                                    ELSE messageFrom
                                END -- high_id
                        ) T ON T.most_recent_message_id = messages.id
            WHERE   messageFrom = :user_id
            OR messageTo = :user_id
            ORDER BY messageTime DESC");
            $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function getChats($user_id,$search) {
            $stmt = $this->getConnection()->prepare("SELECT  sender.id AS sender_user
            ,recipient.id AS recipient_user
            ,messageTime
            ,messageText
            FROM messages
            INNER JOIN users AS sender ON sender.id = messageFrom
            INNER JOIN users AS recipient ON recipient.id = messageTo
            INNER JOIN ( SELECT MAX(id) AS most_recent_message_id
                        FROM   messages
                        GROUP BY CASE WHEN messageFrom > messageTo
                                        THEN messageTo
                                        ELSE messageFrom
                                END -- low_id
                                ,CASE WHEN messageFrom < messageTo
                                    THEN messageTo
                                    ELSE messageFrom
                                END -- high_id
                        ) T ON T.most_recent_message_id = messages.id
            WHERE   messageFrom = ? AND (recipient.name LIKE ?)
            OR messageTo = ? AND (sender.name LIKE ?)
            OR messageFrom = ? AND (recipient.username LIKE ?)
            OR messageTo = ? AND (sender.username LIKE ?)");
            $stmt->bindValue(1, $user_id, PDO::PARAM_STR);
            $stmt->bindValue(2, '%'.$search.'%', PDO::PARAM_STR);
            $stmt->bindValue(3, $user_id, PDO::PARAM_STR);
            $stmt->bindValue(4, '%'.$search.'%', PDO::PARAM_STR);
            $stmt->bindValue(5, $user_id, PDO::PARAM_STR);
            $stmt->bindValue(6, '%'.$search.'%', PDO::PARAM_STR);
            $stmt->bindValue(7, $user_id, PDO::PARAM_STR);
            $stmt->bindValue(8, '%'.$search.'%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function getMessages($user_id,$user2_id) {
            $stmt = $this->getConnection()->prepare("SELECT * FROM messages WHERE (messageTo = :user_id AND messageFrom = :userId) OR (messageTo = :userId AND messageFrom = :user_id) ORDER BY messageTime DESC");
            $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
            $stmt->bindParam(":userId" , $user2_id , PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function checkInput ($input) {

            $input = htmlspecialchars($input, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $input = trim($input);
            $input = stripslashes($input);
            return $input;
        }  

        public function login ($username_email,$password) {
            $stmt = $this->getConnection()->prepare("SELECT `id` from `users` WHERE ((`email` = :username_email) OR (`username` = :username_email)) AND `password` = :password");
            $stmt->bindParam(":username_email" , $username_email , PDO::PARAM_STR);
            $salt = "asd5f7wf234n7";
            $password = md5(md5($password) . $salt);
            $stmt->bindParam(":password" , $password , PDO::PARAM_STR);    
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($stmt->rowCount() > 0) {
                $_SESSION['user_id'] = $user->id;
                header("Location: index.php");
            } else {
                return false; 
            }
        }

        public function create($table , $fields = array()) {
            $colms = implode(',' , array_keys($fields));
            $values = ':' . implode(', :' , array_keys($fields));
            $sql = "INSERT INTO {$table} ({$colms}) VALUES ({$values})";
            $pdo = $this->getConnection();
            $pdo->beginTransaction();

            if($stmt = $pdo->prepare($sql)) {
                foreach($fields as $key => $data) {
                    $stmt->bindValue(':'. $key , $data );
                }
                if ($stmt->execute() === FALSE) {
                    $pdo->rollback();
                } else {
                    $user_id = $pdo->lastInsertId();
                    $pdo->commit();
                }
                return $user_id;
            }
        }

        public function createAccount($email,$password,$name,$username) {

            $pdo = $this->getConnection();
            $pdo->beginTransaction();      
            $stmt = $pdo->prepare("INSERT INTO `users` (`email` , `password` , `name` , `username`) Values (:email , :password , :name , :username)");
            $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
            $salt = "asd5f7wf234n7";
            $password = md5(md5($password) . $salt);
            $stmt->bindParam(":password" , $password , PDO::PARAM_STR); 
            $stmt->bindParam(":name" , $name , PDO::PARAM_STR);
            $stmt->bindParam(":username" , $username , PDO::PARAM_STR);

            if ($stmt->execute() === FALSE) {
                $pdo->rollback();
                echo 'Unable to insert data';
            } else {
                $user_id = $pdo->lastInsertId();
                $pdo->commit();
            }

            $_SESSION['user_id'] = $user_id;
            date_default_timezone_set("America/Denver");
            $_SESSION['welcome'] = 'welcome';
            header("Location: index.php");
        }

        public function update($table , $user_id , $fields = array()){
            $colms = '';
            $loopCount = 1;
            // to know when i insert ',' 
            foreach ($fields as $name => $value) {
                $colms .= "`{$name}` = :{$name}";
                if($loopCount < count($fields)) {
                    $colms .= ', ' ; }

                $loopCount++;  
            }
            $sql = "UPDATE {$table} SET {$colms} WHERE id = {$user_id}";
            $pdo = $this->getConnection(); 
            if($stmt = $pdo->prepare($sql)) {
                foreach($fields as $key => $data) {
                    $stmt->bindValue(':'. $key , $data );
                }
                $stmt->execute();
                return true;
            }

        } 

        public function delete($table, $array){
            $sql = "DELETE FROM " . $table;
            $where = " WHERE ";

            foreach($array as $key => $value){
                $sql .= $where . $key . " = " . $value . "";
                $where = " AND ";
            }
            $sql .= ";";

            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute();
        }

        public function getDataUser($id) {
            $stmt = $this->getConnection()->prepare("SELECT * from `users` WHERE `id` = :id");
            $stmt->bindParam(":id" , $id , PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public static function logout () {
            $_SESSION = array();
            session_destroy();
            header("Location: login.php");
        }

        public function checkEmail($email) {
            $stmt = $this->getConnection()->prepare("SELECT `email` from `users` WHERE `email` = :email");
            $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else return false;
        } 
            
        public function checkUsername($username) {
            $stmt = $this->getConnection()->prepare("SELECT `username` from `users` WHERE `username` = :username");
            $stmt->bindParam(":username" , $username , PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else return false;
        } 

        public static function checkLogin() {
            if (isset($_SESSION['user_id'])) {
                return true;
            } else return false;      
        }

        public function getId($username) {
            $stmt = $this->getConnection()->prepare("SELECT `id` from `users` where `username` = :username");
            $stmt->bindParam(":username" , $username , PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            return $user->id;
        }

        public function getUsername($id) {
            $stmt = $this->getConnection()->prepare("SELECT `username` from `users` where `id` = :id");
            $stmt->bindParam(":id" , $id , PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            return $user->username;
        }

        public function searchUsers($search){
            $stmt = $this->getConnection()->prepare("SELECT `id`,`username`,`name`,`profile_image` FROM `users` WHERE `username` LIKE ? OR `name` LIKE ?");
            $stmt->bindValue(1, '%'.$search.'%', PDO::PARAM_STR);
            $stmt->bindValue(2, '%'.$search.'%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
//END USER
    }