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
    function listAllUsers()
    {
        $stmt = $this->pdo->query('SELECT user_nickname, user_full_name FROM users');
        return $stmt;
    }

    function listAllGroups()
    {
        $stmt = $this->pdo->query('SELECT group_id, group_name FROM groups');
        return $stmt;
    }

    function addThread(string $threadTitle, string $threadContent, int $threadPoster, int $threadGroup): bool
    {
        $query = $this->pdo->prepare('INSERT INTO threads (thread_title, thread_text, poster_id, group_id) VALUES (?, ?, ?, ?)');
        if ($query->execute([$threadTitle, $threadContent, $threadPoster, $threadGroup]))
            return true;
        else
            return false;
    }

    function getGroupId(string $groupHandle): int
    {
        $query = $this->pdo->prepare('SELECT groups.group_id FROM groups
        WHERE groups.group_handle = ?');
        $query->execute([$groupHandle]);

        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data["group_id"];
    }

    function getGroupsByUsername($username): array
    {
        $query = $this->pdo->prepare(
            'SELECT groups.group_name, groups.group_handle FROM group_members
                LEFT JOIN groups ON groups.group_id = group_members.group_id
                LEFT JOIN users ON users.user_id = group_members.user_id
                WHERE users.user_nickname = ?'
        );

        $query->execute([$username]);

        $groups = [];

        while ($group = $query->fetch(PDO::FETCH_ASSOC))
            array_push($groups, $group);

        return $groups;
    }

    function getAllGroupsNames(): array
    {
        $query = $this->pdo->prepare('SELECT group_name, group_handle FROM groups');
        $query->execute();

        $groups = [];

        while ($group = $query->fetch(PDO::FETCH_ASSOC))
            array_push($groups, $group);

        return $groups;
    }

    function getGroupData($groupHandle)
    {
        $query = $this->pdo->prepare("SELECT groups.group_id, groups.group_handle, groups.group_name, groups.group_bio, groups.group_public_flag, groups.group_date_of_creation FROM groups WHERE groups.group_handle = ?");
        $query->execute([$groupHandle]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function getUserGroupsThreads($username): array
    {
        $query = $this->pdo->prepare(
            "SELECT threads.thread_id, threads.thread_title, threads.thread_text, threads.group_id, threads.thread_positive_rating, threads.thread_negative_rating, users.user_nickname AS 'thread_poster', groups.group_handle FROM threads
            LEFT JOIN users ON threads.poster_id = users.user_id
            LEFT JOIN groups ON threads.group_id = groups.group_id
            WHERE threads.group_id 
            IN (
                SELECT group_id FROM group_members
                    LEFT JOIN users ON group_members.user_id = users.user_id 
                    WHERE users.user_nickname = ?)"
        );
        $query->execute([$username]);

        $threads = [];

        while ($thread = $query->fetch(PDO::FETCH_ASSOC))
            array_push($threads, $thread);

        return $threads;
    }

    function getPublicThreads(): array
    {
        $query = $this->pdo->prepare(
            "SELECT threads.thread_id, threads.thread_title, threads.thread_text, threads.group_id, threads.thread_positive_rating, threads.thread_negative_rating, users.user_nickname AS 'thread_poster', groups.group_handle FROM threads
            LEFT JOIN users ON threads.poster_id = users.user_id
            LEFT JOIN groups ON threads.group_id = groups.group_id
            WHERE groups.group_public_flag = 1"
        );
        $query->execute();

        $threads = [];

        while ($thread = $query->fetch(PDO::FETCH_ASSOC))
            array_push($threads, $thread);

        return $threads;
    }

    function getAllUserNames(): array
    {
        $query = $this->pdo->prepare('SELECT user_nickname FROM users');
        $query->execute();

        $users = [];

        while ($user = $query->fetch(PDO::FETCH_ASSOC))
            array_push($users, $user);

        return $users;
    }

    function getUserData($username): array
    {
        $query = $this->pdo->prepare("SELECT users.user_id, users.user_nickname, users.user_full_name, users.user_email, users.user_gender, users.user_birthdate FROM users WHERE users.user_nickname = ?");
        $query->execute([$username]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function getUserThreads($username)
    {
        $query = $this->pdo->prepare("SELECT threads.thread_id, threads.thread_title, threads.thread_text, threads.group_id, threads.thread_positive_rating, threads.thread_negative_rating, users.user_nickname AS 'thread_poster', groups.group_handle FROM threads
            LEFT JOIN users ON threads.poster_id = users.user_id
            LEFT JOIN groups ON threads.group_id = groups.group_id
            WHERE users.user_nickname = ?");

        $query->execute([$username]);

        $threads = [];

        while ($thread = $query->fetch(PDO::FETCH_ASSOC))
            array_push($threads, $thread);

        return $threads;
    }

    function getGroupThreads($groupId)
    {
        $query = $this->pdo->prepare("SELECT threads.thread_id, threads.thread_title, threads.thread_text, threads.group_id, threads.thread_positive_rating, threads.thread_negative_rating, users.user_nickname AS 'thread_poster' FROM threads
            LEFT JOIN users ON threads.poster_id = users.user_id
            WHERE threads.group_id = ?");

        $query->execute([$groupId]);

        $threads = [];

        while ($thread = $query->fetch(PDO::FETCH_ASSOC))
            array_push($threads, $thread);

        return $threads;
    }

    function getGroupMembers($groupId)
    {
        $query = $this->pdo->prepare('SELECT users.user_nickname FROM group_members
            LEFT JOIN users ON users.user_id = group_members.user_id
            WHERE group_members.group_id = ?');

        $query->execute([$groupId]);

        $members = [];

        while ($member = $query->fetch(PDO::FETCH_ASSOC))
            array_push($members, $member);

        return $members;
    }

    function getGroupAdmin($groupId)
    {
        $query = $this->pdo->prepare('SELECT users.user_nickname FROM group_members
            LEFT JOIN users ON users.user_id = group_members.user_id
            WHERE group_members.group_admin = 1
            AND group_members.group_id = ?');

        $query->execute([$groupId]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function getUserGroupsById($userId)
    {
        $query = $this->pdo->prepare("SELECT groups.group_name, groups.group_handle FROM group_members 
            LEFT JOIN groups ON group_members.group_id = groups.group_id
            WHERE user_id = ?");

        $query->execute([$userId]);

        $groups = [];

        while ($group = $query->fetch(PDO::FETCH_ASSOC))
            array_push($groups, $group);

        return $groups;
    }

    function joinGroupPublic($groupId, $userId)
    {
        $query = $this->pdo->prepare("INSERT INTO group_members (group_id, user_id) values (?, ?)");
        $query->execute([$groupId, $userId]);
    }

    function joinGroupPrivate($groupId, $userId)
    {
        $query = $this->pdo->prepare("INSERT INTO group_members (group_id, user_id, group_member_accepted_flag) values (?, ?, 0)");
        $query->execute([$groupId, $userId]);
    }

    function leaveGroup($groupId, $userId)
    {
        $query = $this->pdo->prepare("DELETE FROM group_members WHERE group_members.group_id = ? AND group_members.user_id = ? ");
        $query->execute([$groupId, $userId]);
    }

    function getLoginData($username)
    {
        $query = $this->pdo->prepare("SELECT user_id, user_nickname, user_password, user_full_name from users WHERE users.user_nickname = ?");
        $query->execute([$username]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
