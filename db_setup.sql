/*user_gender*/
/*user_date_of_reg*/
CREATE TABLE users
(
    user_id int NOT NULL AUTO_INCREMENT,
    user_nick varchar(20) NOT NULL,
    user_password varchar(255) NOT NULL,
    user_first_name varchar(255),
    user_surname varchar(255),
    user_gender int DEFAULT 2,
    user_date_of_reg date NOT NULL,
    user_age int NOT NULL,
    PRIMARY KEY (user_id)    
);

CREATE TABLE groups
(
    group_id varchar(255) NOT NULL,
    group_bio varchar(255),
    group_public_flag boolean DEFAULT 1,
    PRIMARY KEY (group_id)
);

CREATE TABLE threads
(
    thread_id int NOT NULL AUTO_INCREMENT,
    thread_title varchar(255) NOT NULL,
    thread_text varchar(500) NOT NULL,
    thread_date date NOT NULL,
    thread_positive_rating int DEFAULT 0,
    thread_negative_rating int DEFAULT 0,
    poster_id int NOT NULL,
    group_id varchar(255) NOT NULL,
    PRIMARY KEY (thread_id),
    FOREIGN KEY (poster_id) REFERENCES users(user_id),
    FOREIGN KEY (group_id) REFERENCES groups(group_id)
);

CREATE TABLE comments
(
    comment_id int NOT NULL AUTO_INCREMENT,
    comment_text varchar(500),
    comment_date date NOT NULL,
    comment_positive_rating int DEFAULT 0,
    comment_negative_rating int DEFAULT 0,
    thread_id int NOT NULL,
    poster_id int NOT NULL,
    PRIMARY KEY (comment_id),
    FOREIGN KEY (thread_id) REFERENCES threads(thread_id),
    FOREIGN KEY (poster_id) REFERENCES users(user_id)
);

CREATE TABLE comment_replies
(
    comment_reply_id int NOT NULL AUTO_INCREMENT,
    comment_reply_text varchar(500),
    comment_reply_date date NOT NULL,
    comment_reply_positive_rating int DEFAULT 0,
    comment_reply_negative_rating int DEFAULT 0,
    comment_id int NOT NULL,
    poster_id int NOT NULL,
    PRIMARY KEY (comment_reply_id),
    FOREIGN KEY (comment_id) REFERENCES comments(comment_id),
    FOREIGN KEY (poster_id) REFERENCES users(user_id)
);

CREATE TABLE group_members
(
    group_member_id int NOT NULL AUTO_INCREMENT,
    group_id varchar(255) NOT NULL,
    user_id int NOT NULL,
    group_admin boolean NOT NULL DEFAULT 0,
    PRIMARY KEY (group_member_id),
    FOREIGN KEY (group_id) REFERENCES groups(group_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE group_moderators
(
    group_moderator_id int NOT NULL AUTO_INCREMENT,
    group_id varchar(255) NOT NULL,
    member_id int NOT NULL,
    PRIMARY KEY (group_moderator_id),
    FOREIGN KEY (group_id) REFERENCES groups(group_id),
    FOREIGN KEY (member_id) REFERENCES group_members(group_member_id)
);

INSERT INTO users(
user_nick,
user_password,
user_age
) VALUES(
    'asdf',
    'testpw',
    23
);

INSERT INTO users(
user_nick,
user_password,
user_age
) VALUES(
    'asdf2nd',
    'testpw',
    25
);

INSERT INTO groups(
group_id,
group_bio
) VALUES(
    'testgroup',
    'This is a test group for threads!'
);

INSERT INTO threads(
thread_title,
thread_text,
thread_date,
poster_id,
group_id
) VALUES(
    'Test title',
    'Test thread body',
    CURRENT_DATE(),
    1,
    'testgroup'
);

INSERT INTO threads(
thread_title,
thread_text,
thread_date,
poster_id,
group_id
) VALUES(
    'Second thread',
    'Hi im second thread',
    CURRENT_DATE(),
    2,
    'testgroup'
);

INSERT INTO comments(
comment_text,
comment_date,
comment_positive_rating,
thread_id,
poster_id
) VALUES(
    'Replying to thread',
    CURRENT_DATE(),
    1,
    1,
    2
);

INSERT INTO comments(
comment_text,
comment_date,
thread_id,
poster_id
) VALUES(
    'Replying to thread again',
    CURRENT_DATE(),
    1,
    2
);
