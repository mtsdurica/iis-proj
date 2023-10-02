/*user_gender*/
/*user_date_of_reg*/
CREATE TABLE users
(
    user_id varchar(20) NOT NULL,
    user_password varchar(255) NOT NULL,
    user_first_name varchar(255),
    user_surname varchar(255),
    user_gender ENUM('Male', 'Female', 'Other') DEFAULT 'Female',
    user_birthdate date,
    user_date_of_reg date NOT NULL,
    user_public_flag boolean DEFAULT 1,
    PRIMARY KEY (user_id)    
);

CREATE TABLE groups
(
    group_id varchar(255) NOT NULL,
    group_bio varchar(255),
    group_public_flag boolean DEFAULT 1,
    group_date_of_creation date NOT NULL,
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
    reply_id int,
    poster_id varchar(20) NOT NULL,
    group_id varchar(255) NOT NULL,
    PRIMARY KEY (thread_id),
    FOREIGN KEY (poster_id) REFERENCES users(user_id),
    FOREIGN KEY (group_id) REFERENCES groups(group_id),
    FOREIGN KEY (reply_id) REFERENCES threads(thread_id)
);

CREATE TABLE group_members
(
    group_member_id int NOT NULL AUTO_INCREMENT,
    group_id varchar(255) NOT NULL,
    user_id varchar(20) NOT NULL,
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


INSERT INTO users (user_id, user_password, user_gender)
VALUES ('asdf', 'password123', 'Male');

INSERT INTO users (user_id, user_password, user_gender)
VALUES ('asdf2nd', 'password456', 'Female');

INSERT INTO groups (group_id, group_bio)
VALUES ('testgroup', 'This is a test group for threads!');

INSERT INTO threads (thread_title, thread_text, thread_date, poster_id, group_id)
VALUES ('Test title', 'Test thread body', CURRENT_DATE(), 'asdf', 'testgroup');

INSERT INTO threads (thread_title, thread_text, thread_date, poster_id, group_id)
VALUES ('Second thread', 'Hi im second thread', CURRENT_DATE(), 'asdf2nd', 'testgroup');