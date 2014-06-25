# Create article database
CREATE TABLE ucsd_article(
  `id`          INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title`       VARCHAR(64) NOT NULL,
  `description` VARCHAR(128),
  `markdown`    TEXT NOT NULL,
  `content`     TEXT NOT NULL,
  `visibility`  INT NOT NULL
);

# Slug table
CREATE TABLE ucsd_slugs(
	`slug`       VARCHAR(64) NOT NULL PRIMARY KEY,
	`article_id` INT NOT NULL,
	CONSTRAINT   FOREIGN KEY(`article_id`) REFERENCES ucsd_articles(`id`) ON DELETE CASCADE
);

CREATE TABLE ucsd_tags(
	`id` INT
	`tag` VARCHAR(32)
)

CREATE TABLE ucsd_article_tags(
	`article_id`  
	`tag_id`
)

# Member table
CREATE TABLE ucsd_members(
  `id`       INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` CHAR(32),
  `email`    VARCHAR(64),
  `password` CHAR(128),
  `salt`     CHAR(128)
);

# Login attempts
CREATE TABLE ucsd_login_attempts(
	`user_id` INT NOT NULL,
	`time`    VARCHAR(30) NOT NULL
);

# Update history
CREATE TABLE ucsd_history(
  `id`         INT NOT NULL PRIMARY KEY AUTO_INCREMENT
  `article_id` INT NOT NULL REFERENCES ucsd_article(aid),
  `user_id`    INT NOT NULL REFERENCES ucsd_users(uid),
  `time`       TIME NOT NULL
  CONSTRAINT   FOREIGN KEY(`article_id`) REFERENCES ucsd_articles(`id`) ON DELETE NOTHING,
  CONSTRAINT   FOREIGN KEY(`user_id`) REFERENCES ucsd_members(`id`) ON DELETE NOTHING
);

CREATE TABLE ucsd_assets(
  `id`      INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name`    VARCHAR(64) NOT NULL,
  `title`   VARCHAR(64) NOT NULL,
  `type_id` INT NOT NULL,
  CONSTRAINT FOREIGN KEY(`type_id`) REFERENCES ucsd_assets_type(`id`) ON DELETE CASCADE 
)

CREATE TABLE ucsd_assets_type(
  `id`   INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `type` VARCHAR(10) NOT NULL 
)