CREATE TABLE IF NOT EXISTS `ucsd_term_relations` (
  `term_id` INT UNSIGNED NOT NULL,
  `post_id` INT UNSIGNED NOT NULL,
  `type`    VARCHAR(10) NOT NULL,
  PRIMARY KEY (`term_id`, `post_id`),
  CONSTRAINT `term_id`
    FOREIGN KEY (`term_id`)
    REFERENCES `ucsd_terms` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `post_id`
    FOREIGN KEY (`post_id`)
    REFERENCES `ucsd_posts` (`id`)
    ON DELETE CASCADE
)


CREATE TABLE `ucsd_posts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`title` text NOT NULL,
	`parent` int(11) NOT NULL,
	`excerpt` text,
	`status` char(11) NOT NULL DEFAULT "private",
	`input_content` longtext,
	`output_content` longtext,
	`author_id` int(11) NOT NULL,
	`modified` DATETIME, 
	PRIMARY KEY (`id`),
	FOREIGN KEY (`author_id`) REFERENCES ucsd_users(`id`)
);

CREATE TABLE ucsd_article(
	`id` INT PRIMARY KEY AUTO_INCREMENT,
	`title` TEXT NOT NULL,
	`parent` INT REFERENCES ucsd_article(`id`) ON DELETE SET NULL,
	`excerpt` TEXT,
	`raw_content` LONGTEXT,
	`parsed_content` LONGTEXT
);

CREATE TABLE ucsd_users(
	`id`           INT PRIMARY KEY AUTO_INCREMENT,
	`username`     VARCHAR(32) NOT NULL,
	`password`     VARCHAR(64) NOT NULL,
	`salt`         VARCHAR(20) NOT NULL,
	`display_name` VARCHAR(50) NOT NULL,
	`email`        VARCHAR(100) NOT NULL,
	`permission`   INT
);

CREATE TABLE ucsd_slugs(
	`id`         INT PRIMARY KEY AUTO_INCREMENT,
	`slug`       VARCHAR(100) NOT NULL,
	`article_id` INT REFERENCES ucsd_article(`id`) ON DELETE CASCADE
);

CREATE TABLE ucsd_history(
	`id`            INT PRIMARY KEY AUTO_INCREMENT,
	`article_id`    INT REFERENCES ucsd_article(`id`) ON DELETE CASCADE,
	`user_id`       INT REFERENCES ucsd_users(`id`) ON DELETE NO ACTION,
	`date_modified` DATETIME
);

CREATE TABLE ucsd_article_meta(
	`id`         INT PRIMARY KEY AUTO_INCREMENT,
	`article_id` INT REFERENCES ucsd_article(`id`) ON DELETE CASCADE,
	`meta_key`   VARCHAR(255) NOT NULL,
	`meta_value` LONGTEXT NOT NULL
);

CREATE TABLE ucsd_options(
	`id`    INT PRIMARY KEY AUTO_INCREMENT,
	`option_name` 
	`option_value`
);