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
    group_member_accepted_flag boolean NOT NULL DEFAULT 1,
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
VALUES ('admin',
        '$2y$10$3lltgAQHtuxvrKYK7SS2t.UcAx2nuBvKLblYZ3wtp9wABakoFEShC',
        'Other');

INSERT INTO users (user_nickname, user_password, user_email, user_profile_pic, user_banner, user_full_name, user_gender, user_birthdate)
VALUES ('fitking', 
        '$2y$10$5B4Zn48s1bIQDcA5MJyM5O6qMzM3LQUcSH3kHtG3ChKuXGgJMhgrq', 
        'john@example.com',
        '', 
        '', 
        'John Doe', 
        'Male', 
        '02-02-2003');

INSERT INTO users (user_nickname, user_password, user_email, user_profile_pic, user_banner, user_full_name, user_gender, user_birthdate)
VALUES ('nick56',
        '$2y$10$pUakoh/N33FSBfiih23YmOujbEOhTuXl53fZTDcT3P5rwJf2P7v/O',
        'david@example.com',
        '', 
        '', 
        'David Dull', 
        'Male', 
        '12-05-2001');

INSERT INTO users (user_nickname, user_password, user_email, user_profile_pic, user_banner, user_full_name, user_gender, user_birthdate)
VALUES ('big_bass',
        '$2y$10$pUakoh/N33FSBfiih23YmOujbEOhTuXl53fZTDcT3P5rwJf2P7v/O',
        'david@example.com',
        '', 
        '', 
        'Charles Bass', 
        'Male', 
        '11-09-1991');

INSERT INTO users (user_nickname, user_password, user_email, user_profile_pic, user_banner, user_full_name, user_gender, user_birthdate)
VALUES ('andrew35',
        '$2y$10$DO9K.p.7wd62rvTOT/xZ0eRrZLW8k4nfW7psYngeQJXI15fbaa1ta',
        'andrew@example.com',
        '', 
        '', 
        'Andrew Rhodes', 
        'Male', 
        '21-04-1999');

INSERT INTO users (user_nickname, user_password, user_email, user_profile_pic, user_banner, user_full_name, user_gender, user_birthdate)
VALUES ('olie',
        '$2y$10$h8oTzguFEJq5z9eKH6KLzu94v8YhC3cYrLzNQbZaMXEV/UbOnBxnu',
        'oliee@example.com',
        '', 
        '', 
        'Oliver Ouken', 
        'Male', 
        '30-03-1996');

INSERT INTO users (user_nickname, user_password, user_email, user_profile_pic, user_banner, user_full_name, user_gender, user_birthdate)
VALUES ('kate_collins',
        '$2y$10$6ZXEuEpKTlYkNfpICq6kUerIfgn4YPsLAc7GRQ8lZvZY1Kdv0cPOm',
        'kate.c@example.com',
        '', 
        '', 
        'Kate Collins', 
        'Female', 
        '23-07-1989');

INSERT INTO users (user_nickname, user_password, user_email, user_profile_pic, user_banner, user_full_name, user_gender, user_birthdate)
VALUES ('jane79',
        '$2y$10$g7NFZrjR.tw79iAn0T5pee5iBtsXZbQ.n8QH2OOwXk0LNkSymn8nC',
        'griffin@example.com',
        '', 
        '', 
        'Jane Griffin', 
        'Female', 
        '05-07-1977');

INSERT INTO users (user_nickname, user_password, user_email, user_profile_pic, user_banner, user_full_name, user_gender, user_birthdate)
VALUES ('fitqueen',
        '$2y$10$.nOeTWohM4egBQdaq46sAOLaszXRsUkkW5T6/N74.CZSGT99ICpF.',
        'queen@example.com',
        '', 
        '', 
        'Serena van der Woodsen', 
        'Female', 
        '02-09-1991');

INSERT INTO users (user_nickname, user_password, user_email, user_profile_pic, user_banner, user_full_name, user_gender, user_birthdate)
VALUES ('ues_princess',
        '$2y$10$.nOeTWohM4egBQdaq46sAOLaszXRsUkkW5T6/N74.CZSGT99ICpF.',
        'princess@example.com',
        '', 
        '', 
        'Blair Waldorf', 
        'Female', 
        '22-07-1991');

-- GROUPS
INSERT INTO groups (group_handle, group_name, group_profile_pic, group_banner, group_bio)
VALUES ('fit_students',
        'FIT Students',
        '',
        '',
        'Group for students of FIT VUT.');

INSERT INTO groups (group_handle, group_name, group_profile_pic, group_banner, group_bio)
VALUES ('brno_apartments',
        'Brno Apartments',
        '',
        '',
        'Find your flat in this group.');

INSERT INTO groups (group_handle, group_name, group_profile_pic, group_banner, group_bio)
VALUES ('brno_market',
        'Brno Market',
        '',
        '',
        'Buy, sell, rent anything you want.');

INSERT INTO groups (group_handle, group_name, group_profile_pic, group_banner, group_bio)
VALUES ('movie_talk',
        'Movie Talk',
        '',
        '',
        'Lets discuss movies here!');

INSERT INTO groups (group_handle, group_name, group_profile_pic, group_banner, group_bio)
VALUES ('music_talk',
        'Music Talk',
        '',
        '',
        'Lets discuss music here!');

INSERT INTO groups (group_handle, group_name, group_profile_pic, group_banner, group_bio)
VALUES ('formula_fans',
        'Formula1 Fans',
        '',
        '',
        'World of F1 fans.');

INSERT INTO groups (group_handle, group_name, group_profile_pic, group_banner, group_bio)
VALUES ('plants',
        'Plants',
        '',
        '',
        'Share your tips about plants. Sell, buy, swap, discuss, have fun!');

-- THREADS
INSERT INTO threads (thread_title, thread_text, thread_positive_rating, thread_negative_rating, poster_id, group_id)
VALUES ('First thread ever', 
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam et erat finibus, fringilla nisi sit amet, 
        euismod ante. Suspendisse vitae purus ultricies, dignissim tortor at, lacinia sapien. Nam cursus elementum 
        maximus. Suspendisse sem lectus, mattis ac mi sed, venenatis rhoncus nisl. Phasellus a dignissim turpis. ', 
        120,
        14,
        2, 
        1);

INSERT INTO threads (thread_title, thread_text, thread_positive_rating, thread_negative_rating, poster_id, group_id)
VALUES ('Second thread ever', 
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam et erat finibus, fringilla nisi sit amet, 
        euismod ante. Suspendisse vitae purus ultricies, dignissim tortor at, lacinia sapien. Nam cursus elementum 
        maximus. Suspendisse sem lectus, mattis ac mi sed, venenatis rhoncus nisl. Phasellus a dignissim turpis. ', 
        220,
        60,
        9, 
        1);

INSERT INTO threads (thread_title, thread_text, thread_positive_rating, thread_negative_rating, poster_id, group_id)
VALUES ('The best thread', 
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam et erat finibus, fringilla nisi sit amet, 
        euismod ante. Suspendisse vitae purus ultricies, dignissim tortor at, lacinia sapien. Nam cursus elementum 
        maximus. Suspendisse sem lectus, mattis ac mi sed, venenatis rhoncus nisl. Phasellus a dignissim turpis. ', 
        434,
        1,
        3, 
        1);

INSERT INTO threads (thread_title, thread_text, thread_positive_rating, thread_negative_rating, poster_id, group_id)
VALUES ('Apartment for rent in the city centre.', 
        'I am offering 2+1 apartment in the city centre. For more information contact me on my email address.', 
        132,
        1,
        6, 
        2);

INSERT INTO threads (thread_title, thread_text, thread_positive_rating, thread_negative_rating, poster_id, group_id)
VALUES ('Looking for 3+1 flat', 
        'I am looking for a flat for me and my family. If you have any tips, please, contact me.', 
        132,
        1,
        4, 
        2);

INSERT INTO threads (thread_title, thread_text, thread_positive_rating, thread_negative_rating, poster_id, group_id)
VALUES ('Old computer for sale', 
        'Hello, I am offering my old computer for sale. For more information, please, contact me on my email address.', 
        14,
        5,
        5, 
        3);

INSERT INTO threads (thread_title, thread_text, thread_positive_rating, thread_negative_rating, poster_id, group_id)
VALUES ('Coming to the cinemas', 
        'Do you know any good movies that are coming to the cinemas this month?', 
        98,
        65,
        7, 
        4);

INSERT INTO threads (thread_title, thread_text, thread_positive_rating, thread_negative_rating, poster_id, group_id)
VALUES ('Utopia from Travis Scott', 
        'What do you think about the new Utopia album from Travis Scott?', 
        135,
        263,
        8, 
        5);

INSERT INTO threads (thread_title, thread_text, thread_positive_rating, thread_negative_rating, poster_id, group_id)
VALUES ('Max Verstappen', 
        'What are your thoughts on Max Verstappen?', 
        231,
        556,
        3, 
        6);

INSERT INTO threads (thread_title, thread_text, thread_positive_rating, thread_negative_rating, poster_id, group_id)
VALUES ('Cactus swap', 
        'Hi, I have one spare cactus for a swap. Any succulents to offer?', 
        45,
        10,
        9, 
        7);

-- GROUP MEMBERS
-- admin as moderator in every group
INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (1, 1, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (2, 1, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (3, 1, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (4, 1, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (5, 1, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (6, 1, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (7, 1, 1);

-- fit_students group
INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (1, 2, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (1, 9, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (1, 3, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (1, 4, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (1, 8, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (1, 10, 0);

-- brno_apartments group
INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (2, 6, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (2, 2, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (2, 4, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (2, 5, 0);

-- brno_market group
INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (3, 5, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (3, 9, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (3, 2, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (3, 3, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (3, 4, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (3, 5, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (3, 6, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (3, 7, 0);

-- movie_talk group
INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (4, 7, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (4, 4, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (4, 9, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (4, 10, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (4, 5, 1);

-- music_talk group
INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (5, 8, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (5, 10, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (5, 5, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (5, 8, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (5, 4, 0);

-- formula_fans group
INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (6, 3, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (6, 6, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (6, 2, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (6, 4, 0);

-- plants group
INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (7, 10, 1);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (7, 9, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (7, 8, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (7, 7, 0);

INSERT INTO group_members (group_id, user_id, group_admin)
VALUES (7, 6, 0);