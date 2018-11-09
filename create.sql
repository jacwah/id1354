-- TODO: NOT NULL?
CREATE TABLE SiteUser (
    user_id INT AUTO_INCREMENT,
    username VARCHAR(30) UNIQUE,
    password VARCHAR(30),
    PRIMARY KEY (user_id)
);

CREATE TABLE RecipeComment (
    comment_id INT AUTO_INCREMENT,
    poster_id INT,
    recipe_name VARCHAR(30),
    content VARCHAR(200),
    PRIMARY KEY (comment_id),
    FOREIGN KEY fk_user(poster_id)
    REFERENCES SiteUser(user_id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE UserSession (
    user_id INT,
    session_id CHAR(32) UNIQUE,
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY fk_session_user(user_id)
    REFERENCES SiteUser(user_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);
