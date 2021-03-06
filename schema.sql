CREATE TABLE IF NOT EXISTS `users`
(
  `email` VARCHAR(255) UNIQUE PRIMARY KEY,
  `username` VARCHAR(100) UNIQUE,
  `password` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `posts`
(
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `content` TEXT NOT NULL,
  `user` VARCHAR(100),
  `likes` INT UNSIGNED DEFAULT 0,
  `create_date` DATETIME DEFAULT NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comments`
(
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `post_id` INT UNSIGNED NOT NULL,
  `content` TEXT NOT NULL,
  `user` VARCHAR(100),
  `likes` INT UNSIGNED DEFAULT 0,
  `create_date` DATETIME DEFAULT NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users_likes_posts`
(
  `username` VARCHAR(100),
  `post_id` INT UNSIGNED,
  PRIMARY KEY (`username`, `post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users_likes_comments`
(
  `username` VARCHAR(100),
  `comment_id` INT UNSIGNED,
  PRIMARY KEY (`username`, `comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
