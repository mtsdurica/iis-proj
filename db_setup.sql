DROP TABLE user;
DROP TABLE thread;
DROP TABLE reply;

/*user_gender*/
/*user_date_of_reg*/
CREATE TABLE user
(
    user_id int NOT NULL AUTO_INCREMENT,
    user_nick varchar(20) NOT NULL,
    user_password varchar(255) NOT NULL,
    user_first_name varchar(255),
    user_surname varchar(255),
    user_age int NOT NULL,
    PRIMARY KEY (user_id)
);

/*Add foreign keys for group and OP*/
CREATE TABLE thread
(
    thread_id int NOT NULL AUTO_INCREMENT,
    thread_title varchar(255) NOT NULL,
    thread_text varchar(500) NOT NULL,
    thread_date date NOT NULL,
    thread_positive_rating int DEFAULT 0,
    thread_negative_rating int DEFAULT 0,
    poster_id int NOT NULL,
    PRIMARY KEY (thread_id),
    FOREIGN KEY (poster_id) REFERENCES user(user_id)
);

CREATE TABLE reply
(
    reply_id int NOT NULL AUTO_INCREMENT,
    reply_text varchar(500),
    reply_date date NOT NULL,
    reply_positive_rating int DEFAULT 0,
    reply_negative_rating int DEFAULT 0,
    thread_id int NOT NULL,
    poster_id int NOT NULL,
    PRIMARY KEY (reply_id),
    FOREIGN KEY (thread_id) REFERENCES thread(thread_id),
    FOREIGN KEY (poster_id) REFERENCES user(user_id)
);

INSERT INTO user(
user_nick,
user_password,
user_age
) VALUES(
    'asdf',
    'testpw',
    23
);

INSERT INTO user(
user_nick,
user_password,
user_age
) VALUES(
    'asdf2nd',
    'testpw',
    25
);

INSERT INTO thread(
thread_title,
thread_text,
thread_date,
poster_id
) VALUES(
    'Test title',
    'Test thread body',
    CURRENT_DATE(),
    1
);

INSERT INTO thread(
thread_title,
thread_text,
thread_date,
poster_id
) VALUES(
    'Second thread',
    'Hi im second thread',
    CURRENT_DATE(),
    2
);

INSERT INTO reply(
reply_text,
reply_date,
reply_positive_rating,
thread_id,
poster_id
) VALUES(
    'Replying to thread',
    CURRENT_DATE(),
    1,
    1,
    2
);

INSERT INTO reply(
reply_text,
reply_date,
thread_id,
poster_id
) VALUES(
    'Replying to thread again',
    CURRENT_DATE(),
    1,
    2
);
