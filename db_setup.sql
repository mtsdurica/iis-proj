/*user_gender*/
/*user_date_of_reg*/
CREATE TABLE users
(
    user_id int NOT NULL AUTO_INCREMENT,
    user_nickname varchar(20) NOT NULL,
    user_password varchar(255) NOT NULL,
    user_email varchar(50) NOT NULL,
    user_profile_pic varchar(4000) DEFAULT NULL,
    user_banner varchar(4000) DEFAULT NULL,
    user_full_name varchar(255) DEFAULT NULL,
    user_gender ENUM('Male', 'Female', 'Other') DEFAULT 'Other',
    user_birthdate date,
    user_date_of_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_public_for_unregistered_flag boolean DEFAULT 1,
    user_public_for_registered_flag boolean DEFAULT 1,
    user_public_for_members_of_group_flag boolean DEFAULT 1,
    user_banned boolean DEFAULT 0,
    PRIMARY KEY (user_id)    
);

CREATE TABLE groups
(

    group_id int NOT NULL AUTO_INCREMENT,
    group_handle varchar(20) NOT NULL,
    group_name varchar(50) NOT NULL,
    group_profile_pic varchar(4000) DEFAULT NULL,
    group_banner varchar(4000) DEFAULT NULL,
    group_bio varchar(255),
    group_date_of_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    group_public_flag boolean DEFAULT 1,
    group_banned boolean DEFAULT 0,
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
    poster_id int NOT NULL,
    group_id int NOT NULL,
    PRIMARY KEY (thread_id),
    FOREIGN KEY (poster_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES groups(group_id) ON DELETE CASCADE,
    FOREIGN KEY (reply_id) REFERENCES threads(thread_id) ON DELETE CASCADE
);

CREATE TABLE thread_ratings
(
    thread_rating_id int NOT NULL AUTO_INCREMENT,
    thread_id int NOT NULL,
    user_id int NOT NULL,
    thread_rating int DEFAULT 0,
    PRIMARY KEY (thread_rating_id),
    FOREIGN KEY (thread_id) REFERENCES threads(thread_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE group_members
(
    group_member_id int NOT NULL AUTO_INCREMENT,
    group_id int NOT NULL,
    user_id int NOT NULL,
    group_admin boolean NOT NULL DEFAULT 0,
    PRIMARY KEY (group_member_id),
    FOREIGN KEY (group_id) REFERENCES groups(group_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE group_moderators
(
    group_moderator_id int NOT NULL AUTO_INCREMENT,
    group_id int NOT NULL,
    member_id int NOT NULL,
    PRIMARY KEY (group_moderator_id),
    FOREIGN KEY (group_id) REFERENCES groups(group_id) ON DELETE CASCADE,
    FOREIGN KEY (member_id) REFERENCES group_members(group_member_id) ON DELETE CASCADE
);

-- USERS
INSERT INTO users (user_nickname, user_password, user_gender)
VALUES ('fitking', '$2y$10$5B4Zn48s1bIQDcA5MJyM5O6qMzM3LQUcSH3kHtG3ChKuXGgJMhgrq', 'Other');

INSERT INTO users (user_nickname, user_password, user_gender)
VALUES ('nick56', '$2y$10$pUakoh/N33FSBfiih23YmOujbEOhTuXl53fZTDcT3P5rwJf2P7v/O', 'Other');

INSERT INTO users (user_nickname, user_password, user_gender)
VALUES ('andrew35', '$2y$10$DO9K.p.7wd62rvTOT/xZ0eRrZLW8k4nfW7psYngeQJXI15fbaa1ta', 'Other');

INSERT INTO users (user_nickname, user_password, user_gender)
VALUES ('anonymous123', '$2y$10$h8oTzguFEJq5z9eKH6KLzu94v8YhC3cYrLzNQbZaMXEV/UbOnBxnu', 'Other');

INSERT INTO users (user_nickname, user_password, user_gender)
VALUES ('kate_collins', '$2y$10$6ZXEuEpKTlYkNfpICq6kUerIfgn4YPsLAc7GRQ8lZvZY1Kdv0cPOm', 'Female');

INSERT INTO users (user_nickname, user_password, user_gender)
VALUES ('jane79', '$2y$10$g7NFZrjR.tw79iAn0T5pee5iBtsXZbQ.n8QH2OOwXk0LNkSymn8nC', 'Female');

INSERT INTO users (user_nickname, user_password, user_gender)
VALUES ('fitqueen', '$2y$10$.nOeTWohM4egBQdaq46sAOLaszXRsUkkW5T6/N74.CZSGT99ICpF.', 'Female');

INSERT INTO users (user_nickname, user_password, user_gender)
VALUES ('admin', '$2y$10$3lltgAQHtuxvrKYK7SS2t.UcAx2nuBvKLblYZ3wtp9wABakoFEShC', 'Other');

-- GROUPS
INSERT INTO groups (group_handle, group_name, group_bio)
VALUES ('fit_students', 'FIT Students', 'Group for students.');

INSERT INTO groups (group_handle, group_name, group_bio)
VALUES ('brno_apartments', 'Brno Apartments', 'Find your flat in this group.');

INSERT INTO groups (group_handle, group_name, group_bio)
VALUES ('brno_market', 'Brno Market', 'Buy, sell, rent anything you want.');

-- THREADS
INSERT INTO threads (thread_title, thread_text, poster_id, group_id)
VALUES ('Test title', 
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam et erat finibus, fringilla nisi sit amet, 
euismod ante. Suspendisse vitae purus ultricies, dignissim tortor at, lacinia sapien. Nam cursus elementum 
maximus. Suspendisse sem lectus, mattis ac mi sed, venenatis rhoncus nisl. Phasellus a dignissim turpis. ', 
7, 1);

INSERT INTO threads (thread_title, thread_text, poster_id, group_id)
VALUES ('Second thread', 
'In hac habitasse platea dictumst. Aenean tincidunt tristique consequat. Duis mauris mi, accumsan a eleifend 
id, mollis a lacus. Pellentesque malesuada imperdiet sollicitudin.' , 
1, 3);

-- GROUP MEMBERS
INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (1, 1, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (1, 7, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (2, 2, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (3, 1, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (3, 7, 1);