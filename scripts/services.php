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

    function listAllGroups() {
        $stmt = $this->pdo->query('SELECT group_id, group_name FROM groups');
        return $stmt;
    }
      
    function addThread(string $threadTitle, string $threadContent, string $threadPoster, string $threadGroup): bool
    {
        $query = $this->pdo->prepare('INSERT INTO threads (thread_title, thread_text, poster_id, group_id) VALUES (?, ?, ?, ?)');
        if ($query->execute([$threadTitle, $threadContent, $threadPoster, $threadGroup]))
            return true;
        else
            return false;
    }

    function getUserGroups(string $userId): PDOStatement
    {
        $query = $this->pdo->prepare('SELECT group_id FROM group_members WHERE user_id = ?');
        $query->execute([$userId]);

        return $query;
    }

    // Methods meant for admin
    function listAllUsers() {
        $stmt = $this->pdo->query('SELECT user_nickname, user_full_name, user_id FROM users');
        return $stmt;
    }

    // Checks if user is banned or not.
    // @return boolean
    function isBannedUser(int $id) 
    {
        $stmt = $this->pdo->prepare('SELECT user_banned FROM users WHERE user_id = ?');
        $stmt->execute([strval($id)]);
       
        // Fetch the result from the query
        $result = $stmt->fetchColumn();
        return (bool) $result;
    }

    function isPublicUser(int $id) 
    {
        $stmt = $this->pdo->prepare('SELECT user_public_flag FROM users WHERE user_id = ?');
        $stmt->execute([strval($id)]);
       
        // Fetch the result from the query
        $result = $stmt->fetchColumn();
        return (bool) $result;
    }

    function isPublicGroup(int $id) 
    {
        $stmt = $this->pdo->prepare('SELECT group_public_flag FROM groups WHERE group_id = ?');
        $stmt->execute([strval($id)]);
       
        // Fetch the result from the query
        $result = $stmt->fetchColumn();
        return (bool) $result;
    }

    function changeBannedStatus($data)
    {
        $stmt = $this->pdo->prepare('UPDATE users SET user_banned = :banStatus WHERE user_id = :id');
        if ($stmt->execute($data))
        {
            return TRUE;
        }
        else
        {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }

    function deleteUser($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE user_id = ?');
        if ($stmt->execute([$id]))
        {
            return TRUE;
        }
        else
        {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }

    function getUser($id)
    {
        $stmt = $this->pdo->prepare('SELECT user_id, user_full_name, FROM users WHERE user_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function changePublicStatus($data)
    {
        $stmt = $this->pdo->prepare('UPDATE users SET user_public_flag = :publicStatus WHERE user_id = :id');
        if ($stmt->execute($data))
        {
            return TRUE;
        }
        else
        {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }
}


