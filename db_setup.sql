/*user_gender*/
/*user_date_of_reg*/
CREATE TABLE users
(
    user_id varchar(20) NOT NULL,
    user_password varchar(255) NOT NULL,
    user_email varchar(50) NOT NULL,
    user_profile_pic varchar(4000) DEFAULT NULL,
    user_banner varchar(4000) DEFAULT NULL,
    user_full_name varchar(255) DEFAULT NULL,
    user_gender ENUM('Male', 'Female', 'Other') DEFAULT 'Other',
    user_birthdate date,
    user_date_of_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_public_flag boolean DEFAULT 1,
    PRIMARY KEY (user_id)    
);

CREATE TABLE groups
(
    group_id varchar(255) NOT NULL,
    group_name varchar(255),
    group_profile_pic varchar(4000) DEFAULT NULL,
    group_banner varchar(4000) DEFAULT NULL,
    group_bio varchar(255),
    group_public_flag boolean DEFAULT 1,
    group_date_of_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (group_id)
);

CREATE TABLE threads
(
    thread_id int NOT NULL AUTO_INCREMENT,
    thread_title varchar(255) NOT NULL,
    thread_text varchar(500) NOT NULL,
    thread_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
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

-- USERS
INSERT INTO users (user_id, user_password, user_gender)
VALUES ('fitking', 'password123', 'Male');

INSERT INTO users (user_id, user_password, user_gender)
VALUES ('nick56', 'password123', 'Male');

INSERT INTO users (user_id, user_password, user_gender)
VALUES ('andrew35', 'password123', 'Male');

INSERT INTO users (user_id, user_password, user_gender)
VALUES ('anonymous123', 'password123', 'Male');

INSERT INTO users (user_id, user_password, user_gender)
VALUES ('kate_collins', 'password456', 'Female');

INSERT INTO users (user_id, user_password, user_gender)
VALUES ('jane79', 'password456', 'Female');

INSERT INTO users (user_id, user_password, user_gender)
VALUES ('fitqueen', 'password456', 'Female');

-- GROUPS
INSERT INTO groups (group_id, group_bio)
VALUES ('fit_students', 'Group for students.');

INSERT INTO groups (group_id, group_bio)
VALUES ('brno_apartments', 'Find your flat in this group.');

INSERT INTO groups (group_id, group_bio)
VALUES ('brno_market', 'Buy, sell, rent anything you want.');

-- THREADS
INSERT INTO threads (thread_title, thread_text, poster_id, group_id)
VALUES ('Test title', 
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam et erat finibus, fringilla nisi sit amet, 
euismod ante. Suspendisse vitae purus ultricies, dignissim tortor at, lacinia sapien. Nam cursus elementum 
maximus. Suspendisse sem lectus, mattis ac mi sed, venenatis rhoncus nisl. Phasellus a dignissim turpis. ', 
'fitqueen', 'fit_students');

INSERT INTO threads (thread_title, thread_text, poster_id, group_id)
VALUES ('Second thread', 
'In hac habitasse platea dictumst. Aenean tincidunt tristique consequat. Duis mauris mi, accumsan a eleifend 
id, mollis a lacus. Pellentesque malesuada imperdiet sollicitudin.' , 
'fitking', 'brno_market');