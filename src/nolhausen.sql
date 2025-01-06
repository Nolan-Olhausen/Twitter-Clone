CREATE TABLE users (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(255) NOT NULL,
    `username` varchar(40) NOT NULL,
	`password` VARCHAR(32) NOT NULL,
	`name` VARCHAR(40) NOT NULL,
    `profile_image` varchar(255) NOT NULL DEFAULT 'defaultPFP.jpg',
    `bio` varchar(150) NOT NULL DEFAULT '',
	`access` INTEGER(1),
	PRIMARY KEY (`id`)
);

CREATE TABLE posts (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
    `posted_time` datetime NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE likes (
    `id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
    `post_id` int(11) NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE comments (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`comment_text` varchar(255) NOT NULL,
	`user_id` int(11) NOT NULL,
	`post_id` int(11) NOT NULL,
	`comment_time` datetime NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE follow (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`sender` int(11) NOT NULL,
	`receiver` int(11) NOT NULL,
	`follow_time` datetime NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`sender`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`receiver`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE messages (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`messageText` text NOT NULL,
	`messageTo` int(11) NOT NULL,
	`messageFrom` int(11) NOT NULL,
	`messageTime` datetime NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`messageTo`) REFERENCES `users` (`id`),
	FOREIGN KEY (`messageFrom`) REFERENCES `users` (`id`)
);

CREATE TABLE notifications (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  	`notify_for` int(11) NOT NULL,
  	`notify_from` int(11) NOT NULL,
  	`target` int(11) NOT NULL,
  	`type` enum('follow','like','retweet','qoute','comment','reply','mention') NOT NULL,
  	`time` datetime NOT NULL,
  	`count` int(11) NOT NULL,
  	`status` int(11) NOT NULL,
  	PRIMARY KEY (`id`),
  	FOREIGN KEY (`notify_for`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  	FOREIGN KEY (`notify_from`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE replies (
  	`id` int(11) NOT NULL AUTO_INCREMENT,
  	`comment_id` int(11) NOT NULL,
  	`user_id` int(11) NOT NULL,
  	`reply` varchar(140) NOT NULL,
  	`time` datetime NOT NULL,
  	PRIMARY KEY (`id`),
	FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE echoes (
  	`post_id` int(11) NOT NULL,
  	`echo_msg` varchar(140) DEFAULT NULL,
  	`postContent_id` int(11) DEFAULT NULL,
  	`echo_id` int(11) DEFAULT NULL,
  	PRIMARY KEY (`post_id`) USING BTREE,
	FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`postContent_id`) REFERENCES `postContent` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`echo_id`) REFERENCES `echoes` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE postContent (
  	`post_id` int(11) NOT NULL AUTO_INCREMENT,
  	`text` varchar(140) DEFAULT NULL,
  	`img` text DEFAULT NULL,
  	PRIMARY KEY (`post_id`),
	FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);