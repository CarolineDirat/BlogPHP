
CREATE TABLE status (
                status VARCHAR(50) DEFAULT 'waiting' NOT NULL,
                PRIMARY KEY (status)
);


CREATE TABLE user (
                id INT AUTO_INCREMENT NOT NULL,
                pseudo VARCHAR(100) NOT NULL,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(254) NOT NULL,
                date_creation DATETIME DEFAULT NOW() NOT NULL,
                activation_key CHAR(40) NOT NULL,
                enabled BOOLEAN DEFAULT false NOT NULL,
                PRIMARY KEY (id)
);


CREATE TABLE post (
                id INT AUTO_INCREMENT NOT NULL,
                title VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                resume VARCHAR(255) NOT NULL,
                date_creation DATETIME DEFAULT NOW() NOT NULL,
                date_update DATETIME DEFAULT NOW() NOT NULL,
                id_author INT NOT NULL,
                PRIMARY KEY (id)
);


CREATE TABLE comment (
                id INT AUTO_INCREMENT NOT NULL,
                content TEXT NOT NULL,
                date_creation DATETIME DEFAULT NOW() NOT NULL,
                status VARCHAR(50) DEFAULT 'waiting' NOT NULL,
                id_post INT NOT NULL,
                id_user INT NOT NULL,
                PRIMARY KEY (id)
);


CREATE TABLE role (
                role VARCHAR(50) NOT NULL,
                PRIMARY KEY (role)
);


CREATE TABLE role_user (
                id INT NOT NULL,
                role VARCHAR(50) NOT NULL,
                PRIMARY KEY (id, role)
);


ALTER TABLE comment ADD CONSTRAINT status_comment_fk
FOREIGN KEY (status)
REFERENCES status (status)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE role_user ADD CONSTRAINT user_role_user_fk
FOREIGN KEY (id)
REFERENCES user (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE post ADD CONSTRAINT user_post_fk
FOREIGN KEY (id_author)
REFERENCES user (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE comment ADD CONSTRAINT user_comment_fk
FOREIGN KEY (id_user)
REFERENCES user (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE comment ADD CONSTRAINT post_comment_fk
FOREIGN KEY (id_post)
REFERENCES post (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE role_user ADD CONSTRAINT role_role_user_fk
FOREIGN KEY (role)
REFERENCES role (role)
ON DELETE NO ACTION
ON UPDATE NO ACTION;
