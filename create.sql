CREATE TABLE SiteUser (
    user_id INT AUTO_INCREMENT,
    name VARCHAR(30) UNIQUE,
    password VARCHAR(30),
    PRIMARY KEY (user_id)
);

CREATE TABLE RecipeComment (
    comment_id INT AUTO_INCREMENT,
    poster_id INT,
    recipe_title VARCHAR(30),
    content VARCHAR(200),
    PRIMARY KEY (comment_id),
    FOREIGN KEY fk_user(poster_id)
    REFERENCES SiteUser(user_id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);
