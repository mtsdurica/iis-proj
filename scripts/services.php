<?php

class AccountService
{
    private $pdo;
    private $lastError;

    function __construct()
    {
        $this->pdo = $this->connect_db();
        $this->lastError = NULL;
    }

    function connect_db()
    {
        $dsn = 'mysql:host=localhost;dbname=xduric06';
        $username = 'xduric06';
        $password = 'j4sipera';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); // processing communication in Czech/Slovak language
        $pdo = new PDO($dsn, $username, $password, $options);
        return $pdo;
    }

    function getErrorMessage()
    {
        if ($this->lastError === NULL) {
            return '';
        } else {
            return $this->lastError[2]; // 2 is the error message
        }
    }

    function addUser($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (user_nickname, user_password, user_email, user_full_name, user_gender, user_birthdate) VALUES (?, ?, ?, ?, ?, ?)');

        $user_nickname = $data['user_nickname'];
        $user_password = password_hash($data['user_password'], PASSWORD_DEFAULT);
        $user_email = $data['user_email'];
        $user_full_name = $data['user_full_name'];
        $user_gender = $data['user_gender'];
        $user_birthdate = $data['user_birthdate'];

        if ($stmt->execute([$user_nickname, $user_password, $user_email, $user_full_name, $user_gender, $user_birthdate])) {
            // update $data array with new user_id
            $newid = $this->pdo->lastInsertId();
            $data['user_id'] = $newid;
            return $data;
        } else {
            $this->lastError = $stmt->errorInfo();
            return false;
        }
    }

    // Methods meant for admin
    function listAllUsers() {
        $stmt = $this->pdo->query('SELECT user_nickname, user_full_name FROM users');
        return $stmt;
    }

    function listAllGroups() {
        $stmt = $this->pdo->query('SELECT group_id, group_name FROM groups');
        return $stmt;
    }
}
