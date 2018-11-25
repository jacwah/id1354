CREATE DATABASE tasty_recipes;
USE tasty_recipes;

CREATE TABLE SiteUser (
    user_id INT AUTO_INCREMENT NOT NULL,
    username VARCHAR(30) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    PRIMARY KEY (user_id)
);

CREATE TABLE RecipeComment (
    comment_id INT AUTO_INCREMENT NOT NULL,
    poster_id INT NOT NULL,
    recipe_name VARCHAR(30) NOT NULL,
    content TEXT NOT NULL,
    PRIMARY KEY (comment_id),
    FOREIGN KEY fk_comment_poster(poster_id)
    REFERENCES SiteUser(user_id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE UserSession (
    user_id INT NOT NULL,
    session_id CHAR(32) NOT NULL,
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (session_id),
    FOREIGN KEY fk_session_user(user_id)
    REFERENCES SiteUser(user_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE USER 'tasty_recipes_app'@'localhost' IDENTIFIED BY 'aa8df7aba53df507f84c85afc93c8d37';
GRANT SELECT, INSERT, UPDATE, DELETE ON tasty_recipes.* TO 'tasty_recipes_app'@'localhost';
