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
        // TOD: change to xduric06
        $dsn = 'mysql:host=localhost;dbname=xdurac01';
        $username = 'xdurac01';
        $password = 'bu5gumhu';
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
        $stmt = $this->pdo->prepare('INSERT INTO users (user_id, user_password, user_email, user_first_name, user_surname, user_gender, user_birthdate) VALUES (?, ?, ?, ?, ?, ?, ?)');

        $user_id = $data['user_id'];
        $user_password = password_hash($data['user_password'], PASSWORD_DEFAULT);
        $user_email = $data['user_email'];
        $user_first_name = $data['user_first_name'];
        $user_surname = $data['user_surname'];
        $user_gender = $data['user_gender'];
        $user_birthdate = $data['user_birthdate'];

        if ($stmt->execute([$user_id, $user_password, $user_email, $user_first_name, $user_surname, $user_gender, $user_birthdate]))
        {
            // update $data array with new user_id
            $newid = $this->pdo->lastInsertId();
            // TODO: check whether this is correct
            $data['user_id'] = $newid;
            return $data;
        } else {
            $this->lastError = $stmt->errorInfo();
            return false;
        }
    }

}