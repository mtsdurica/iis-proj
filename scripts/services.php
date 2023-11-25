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
        $stmt = $this->pdo->query('SELECT user_nickname, user_full_name, user_id FROM users');
        return $stmt;
    }

    function listAllGroups()
    {
        $stmt = $this->pdo->query('SELECT group_id, group_handle, group_name, group_banned FROM groups');
        return $stmt;
    }
    // end

    function addGroup($groupHandle, $groupName, $groupBio, $groupPublic,  $groupAdmin)
    {
        $query = $this->pdo->prepare("INSERT INTO groups (group_handle, group_name, group_bio, group_public_flag) VALUES (?, ?, ?, ?)");
        $query->execute([$groupHandle, $groupName, $groupBio, $groupPublic]);
        $newGroupId = $this->pdo->lastInsertId();
        $query = $this->pdo->prepare("INSERT INTO group_members (group_id, user_id, group_admin) VALUES (?, ?, ?)");
        $query->execute([$newGroupId, $groupAdmin, 1]);
    }

    function addThread(string $threadTitle, string $threadContent, int $threadPoster, int $threadGroup)
    {
        $query = $this->pdo->prepare('INSERT INTO threads (thread_title, thread_text, poster_id, group_id) VALUES (?, ?, ?, ?)');
        $query->execute([$threadTitle, $threadContent, $threadPoster, $threadGroup]);
        return $this->pdo->lastInsertId();
    }

    function updateThread($threadTitle, $threadContent, $threadId)
    {
        $query = $this->pdo->prepare("UPDATE threads SET threads.thread_title = ?,
            threads.thread_text = ?
            WHERE threads.thread_id = ?
            ");
        $query->execute([$threadTitle, $threadContent, $threadId]);
    }

    function deleteThread($threadId)
    {
        $query = $this->pdo->prepare("DELETE FROM threads WHERE threads.thread_id = ?");
        $query->execute([$threadId]);
    }

    function addReply(string $threadContent, int $threadPoster, int $threadGroup, $threadReply): bool
    {
        $query = $this->pdo->prepare('INSERT INTO threads (thread_text, poster_id, group_id, reply_id) VALUES (?, ?, ?, ?)');
        if ($query->execute([$threadContent, $threadPoster, $threadGroup, $threadReply]))
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
        if (!empty($data))
            return $data["group_id"];
        else return false;
    }

    function getGroupsByUsername($username): array
    {
        $query = $this->pdo->prepare(
            'SELECT groups.group_name, groups.group_handle, groups.group_profile_pic FROM group_members
                LEFT JOIN groups ON groups.group_id = group_members.group_id
                LEFT JOIN users ON users.user_id = group_members.user_id
                WHERE group_members.group_member_accepted_flag = 1 
                AND users.user_nickname = ?'
        );

        $query->execute([$username]);

        $groups = [];

        while ($group = $query->fetch(PDO::FETCH_ASSOC))
            array_push($groups, $group);

        return $groups;
    }

    function getAllGroups(): array
    {
        $query = $this->pdo->prepare('SELECT group_name, group_handle, group_profile_pic FROM groups');
        $query->execute();

        $groups = [];

        while ($group = $query->fetch(PDO::FETCH_ASSOC))
            array_push($groups, $group);

        return $groups;
    }

    function getGroupData($groupHandle)
    {
        $query = $this->pdo->prepare("SELECT groups.group_id, groups.group_handle, groups.group_name, groups.group_profile_pic, groups.group_banner, groups.group_bio, groups.group_public_flag, groups.group_date_of_creation, groups.group_banned FROM groups WHERE groups.group_handle = ?");
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
                    WHERE group_members.group_member_accepted_flag = 1 
                    AND users.user_nickname = ?)
            AND threads.reply_id IS NULL"

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
            WHERE groups.group_public_flag = 1
            AND threads.reply_id IS NULL"
        );
        $query->execute();

        $threads = [];

        while ($thread = $query->fetch(PDO::FETCH_ASSOC))
            array_push($threads, $thread);

        return $threads;
    }

    function getReplies($threadId)
    {
        $query = $this->pdo->prepare(
            "SELECT threads.thread_id, threads.thread_title, threads.thread_text, threads.group_id, threads.thread_positive_rating, threads.thread_negative_rating, users.user_nickname AS 'thread_poster', groups.group_handle FROM threads
            LEFT JOIN users ON threads.poster_id = users.user_id
            LEFT JOIN groups ON threads.group_id = groups.group_id
            WHERE threads.reply_id = ?"
        );
        $query->execute([$threadId]);

        $threads = [];

        while ($thread = $query->fetch(PDO::FETCH_ASSOC))
            array_push($threads, $thread);

        return $threads;
    }

    function getAllUsers(): array
    {
        $query = $this->pdo->prepare('SELECT user_nickname, user_profile_pic FROM users');
        $query->execute();

        $users = [];

        while ($user = $query->fetch(PDO::FETCH_ASSOC))
            array_push($users, $user);

        return $users;
    }

    function getUserData($username): array
    {
        $query = $this->pdo->prepare("SELECT users.user_id, users.user_nickname, users.user_full_name, users.user_email, users.user_gender, users.user_birthdate, user_profile_pic, user_banner, user_public_for_unregistered_flag, user_public_for_registered_flag, user_public_for_members_of_group_flag FROM users WHERE users.user_nickname = ?");
        $query->execute([$username]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function getThreadData($threadId)
    {
        $query = $this->pdo->prepare("SELECT threads.thread_id, threads.thread_title, threads.thread_text, threads.group_id, threads.thread_positive_rating, threads.thread_negative_rating, users.user_nickname AS 'thread_poster', groups.group_handle FROM threads
            LEFT JOIN users ON threads.poster_id = users.user_id
            LEFT JOIN groups ON threads.group_id = groups.group_id
            WHERE threads.thread_id = ?
            AND threads.reply_id IS NULL");

        $query->execute([$threadId]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function getReplyData($replyId)
    {
        $query = $this->pdo->prepare("SELECT threads.thread_id, threads.thread_text, threads.group_id, threads.thread_positive_rating, threads.thread_negative_rating, threads.reply_id, users.user_nickname AS 'thread_poster' FROM threads
            LEFT JOIN users ON threads.poster_id = users.user_id
            WHERE threads.thread_id = ?
            ");

        $query->execute([$replyId]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function getUserThreads($username)
    {
        $query = $this->pdo->prepare("SELECT threads.thread_id, threads.thread_title, threads.thread_text, threads.group_id, threads.thread_positive_rating, threads.thread_negative_rating, users.user_nickname AS 'thread_poster', groups.group_handle FROM threads
            LEFT JOIN users ON threads.poster_id = users.user_id
            LEFT JOIN groups ON threads.group_id = groups.group_id
            WHERE users.user_nickname = ?
            AND threads.reply_id IS NULL");

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
            WHERE threads.group_id = ?
            AND threads.reply_id IS NULL
            ");

        $query->execute([$groupId]);

        $threads = [];

        while ($thread = $query->fetch(PDO::FETCH_ASSOC))
            array_push($threads, $thread);

        return $threads;
    }

    function getNumberOfGroupUsers($groupId)
    {
        $query = $this->pdo->prepare("SELECT COUNT(*) FROM group_members
            WHERE group_members.group_id = ?
            AND group_members.group_member_accepted_flag = 1");

        $query->execute([$groupId]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function getNumberOfGroupThreads($groupId)
    {
        $query = $this->pdo->prepare("SELECT COUNT(*) FROM threads
            WHERE threads.group_id = ?
            AND threads.reply_id IS NULL");

        $query->execute([$groupId]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function getGroupMembers($groupId)
    {
        $query = $this->pdo->prepare('SELECT users.user_nickname, users.user_id, users.user_profile_pic FROM group_members
            LEFT JOIN users ON users.user_id = group_members.user_id
            WHERE group_members.group_member_accepted_flag = 1
            AND group_members.group_admin = 0
            AND group_members.group_id = ?');

        $query->execute([$groupId]);

        $members = [];

        while ($member = $query->fetch(PDO::FETCH_ASSOC))
            array_push($members, $member);

        return $members;
    }

    function getGroupModeratorsUsernames($groupId)
    {
        $query = $this->pdo->prepare('SELECT users.user_nickname FROM group_moderators
            LEFT JOIN group_members ON group_moderators.member_id = group_members.group_member_id
            LEFT JOIN users ON users.user_id = group_members.user_id
            WHERE group_moderators.group_moderator_accepted_flag = 1
            AND group_moderators.group_id = ?');

        $query->execute([$groupId]);

        $members = [];

        while ($member = $query->fetch(PDO::FETCH_ASSOC))
            array_push($members, $member["user_nickname"]);

        return $members;
    }

    function getGroupModerators($groupId)
    {
        $query = $this->pdo->prepare('SELECT users.user_nickname, users.user_profile_pic FROM group_moderators
            LEFT JOIN group_members ON group_moderators.member_id = group_members.group_member_id
            LEFT JOIN users ON users.user_id = group_members.user_id
            WHERE group_moderators.group_moderator_accepted_flag = 1
            AND group_moderators.group_id = ?');

        $query->execute([$groupId]);

        $members = [];

        while ($member = $query->fetch(PDO::FETCH_ASSOC))
            array_push($members, $member);

        return $members;
    }

    function getPendingModerators($groupId)
    {
        $query = $this->pdo->prepare('SELECT users.user_nickname, users.user_id FROM group_moderators
            LEFT JOIN group_members ON group_moderators.member_id = group_members.group_member_id
            LEFT JOIN users ON users.user_id = group_members.user_id
            WHERE group_moderators.group_moderator_accepted_flag = 0
            AND group_moderators.group_id = ?');

        $query->execute([$groupId]);

        $members = [];

        while ($member = $query->fetch(PDO::FETCH_ASSOC))
            array_push($members, $member);

        return $members;
    }

    function getPendingJoinRequests($groupId)
    {
        $query = $this->pdo->prepare('SELECT users.user_id, users.user_nickname FROM group_members
            LEFT JOIN users ON users.user_id = group_members.user_id
            WHERE group_members.group_member_accepted_flag = 0 
            AND group_members.group_id = ?');

        $query->execute([$groupId]);

        $members = [];

        while ($member = $query->fetch(PDO::FETCH_ASSOC))
            array_push($members, $member);

        return $members;
    }

    function handleJoinRequest($groupId, $userId, $updateTo)
    {
        if ($updateTo === true) {
            $query = $this->pdo->prepare("UPDATE group_members SET group_member_accepted_flag = 1 
            WHERE group_members.group_id = ? 
            AND group_members.user_id = ?");
            $query->execute([$groupId, $userId]);
        } else {
            $query = $this->pdo->prepare("DELETE FROM group_members 
                WHERE group_members.group_id = ? 
                AND group_members.user_id = ?");
            $query->execute([$groupId, $userId]);
        }
    }

    function handleModeratorRequest($groupId, $userId, $updateTo)
    {
        $memberId = $this->getGroupMemberId($groupId, $userId);
        if ($updateTo === true) {
            $query = $this->pdo->prepare('UPDATE group_moderators SET group_moderator_accepted_flag = 1 
            WHERE group_moderators.group_id = ? 
            AND group_moderators.member_id = ?');
            $query->execute([$groupId, $memberId["group_member_id"]]);
        } else {
            $query = $this->pdo->prepare('DELETE FROM group_moderators
                WHERE group_moderators.group_id = ? 
                AND group_moderators.member_id = ?');
            $query->execute([$groupId, $memberId["group_member_id"]]);
        }
    }

    function getGroupAdmin($groupId)
    {
        $query = $this->pdo->prepare('SELECT users.user_id, users.user_nickname, users.user_profile_pic FROM group_members
            LEFT JOIN users ON users.user_id = group_members.user_id
            WHERE group_members.group_admin = 1
            AND group_members.group_id = ?');

        $query->execute([$groupId]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function getUserGroupsById($userId)
    {
        $query = $this->pdo->prepare("SELECT groups.group_name, groups.group_handle, groups.group_profile_pic FROM group_members 
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

    function getGroupMemberId($groupId, $userId)
    {
        $query = $this->pdo->prepare('SELECT group_members.group_member_id FROM group_members
            WHERE group_members.group_member_accepted_flag = 1
            AND group_members.group_admin = 0
            AND group_members.group_id = ?
            AND group_members.user_id = ?');

        $query->execute([$groupId, $userId]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function requestModerator($groupId, $userId)
    {
        $member = $this->getGroupMemberId($groupId, $userId);
        $query = $this->pdo->prepare("INSERT INTO group_moderators (group_id, member_id) values (?, ?)");
        $query->execute([$groupId, $member["group_member_id"]]);
    }

    function checkMembership($groupId, $userId)
    {
        $query = $this->pdo->prepare("SELECT user_id, group_member_accepted_flag FROM group_members 
            WHERE group_id = ? 
            AND user_id = ?");

        $query->execute([$groupId, $userId]);

        $response = $query->fetch(PDO::FETCH_ASSOC);
        if (isset($response["user_id"])) {
            if ($response["group_member_accepted_flag"] == 1)
                return true;
            else return "notAccepted";
        }
        return false;
    }

    function leaveGroup($groupId, $userId)
    {
        $query = $this->pdo->prepare("DELETE FROM group_members WHERE group_members.group_id = ?
            AND group_members.user_id = ?");
        $query->execute([$groupId, $userId]);
    }

    function removeModerator($groupId, $username)
    {
        $data = $this->getLoginData($username);
        $userId = $data["user_id"];
        $memberId = $this->getGroupMemberId($groupId, $userId);
        var_dump($memberId);
        $query = $this->pdo->prepare('DELETE FROM group_moderators
                WHERE group_moderators.group_id = ? 
                AND group_moderators.member_id = ?');
        $query->execute([$groupId, $memberId["group_member_id"]]);
    }

    function getLoginData($username)
    {
        $query = $this->pdo->prepare("SELECT user_id, user_nickname, user_password, user_full_name 
            FROM users 
            WHERE users.user_nickname = ?");
        $query->execute([$username]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Function to update User profile picture column in database, when user uploads their custom photo.
    function updateProfilePicColumn(int $userId, string $fileName)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET user_profile_pic = ? WHERE user_id = ?");

        if ($stmt->execute([$fileName, $userId])) {
            return true;
        } else {
            return false;
        }
    }

    // Function to update Group profile picture column in database, when user uploads their custom photo.
    function updateGroupProfilePicColumn(int $groupId, string $fileName)
    {
        $stmt = $this->pdo->prepare("UPDATE groups SET group_profile_pic = ? WHERE group_id = ?");

        if ($stmt->execute([$fileName, $groupId])) {
            return true;
        } else {
            return false;
        }
    }

    // Function to update User profile banner column in database, when user uploads their custom photo.
    function updateBannerColumn(int $userId, string $fileName)
    {

        $stmt = $this->pdo->prepare("UPDATE users SET user_banner = ? WHERE user_id = ?");

        if ($stmt->execute([$fileName, $userId])) {
            return true;
        } else {
            return false;
        }
    }

    // Function to update Group profile banner column in database, when user uploads their custom photo.
    function updateGroupBannerColumn(int $groupId, string $fileName)
    {

        $stmt = $this->pdo->prepare("UPDATE groups SET group_banner = ? WHERE group_id = ?");

        if ($stmt->execute([$fileName, $groupId])) {
            return true;
        } else {
            return false;
        }
    }


    // Function to update User data
    function updateUser($data)
    {
        $stmt = $this->pdo->prepare('UPDATE users SET user_nickname = ?, user_full_name = ?, user_birthdate = ?, user_public_for_unregistered_flag = ?, user_public_for_registered_flag = ?, user_public_for_members_of_group_flag = ? WHERE user_id = ?');

        $user_id = $data['user_id'];
        $user_nickname = $data['user_nickname'];
        $user_full_name = $data['user_full_name'];
        $user_birthdate = $data['user_birthdate'];
        $user_public_for_unregistered_flag = $data['everyone'];
        $user_public_for_registered_flag = $data['registered'];
        $user_public_for_members_of_group_flag = $data['groupMembers'];

        if ($stmt->execute([$user_nickname, $user_full_name, $user_birthdate, $user_public_for_unregistered_flag, $user_public_for_registered_flag, $user_public_for_members_of_group_flag, $user_id])) {
            return true;
        } else {
            $this->lastError = $stmt->errorInfo();
            return false;
        }
    }

    // Function to update Group data
    function updateGroup($data)
    {
        $stmt = $this->pdo->prepare('UPDATE groups SET group_handle = ?, group_name = ?, group_bio = ?, group_public_flag = ? WHERE group_id = ?');

        $group_id = $data['group_id'];
        $group_handle = $data['group_handle'];
        $group_name = $data['group_name'];
        $group_bio = $data['group_bio'];
        $group_public_flag = $data['public_flag'];


        if ($stmt->execute([$group_handle, $group_name, $group_bio, $group_public_flag, $group_id])) {
            return true;
        } else {
            $this->lastError = $stmt->errorInfo();
            return false;
        }
    }

    // Function to get password from database
    function getPassword($userId)
    {
        $stmt = $this->pdo->prepare('SELECT user_password FROM users WHERE user_id = ?');
        $stmt->execute([$userId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['user_password'];
    }

    // Function to update user password
    function updatePassword(int $userId, string $newPassword)
    {
        $password = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare('UPDATE users SET user_password = ? WHERE user_id = ?');

        if ($stmt->execute([$password, $userId])) {
            return true;
        } else {
            $this->lastError = $stmt->errorInfo();
            return false;
        }
    }

    function rateThread($threadId, $userId, $rating)
    {
        $ratingAlreadySet = $this->getThreadRating($threadId, $userId);
        if (!empty($ratingAlreadySet)) {
            if ((int)$ratingAlreadySet["thread_rating"] === $rating) {
                $query = $this->pdo->prepare("DELETE FROM thread_ratings 
                WHERE thread_id = ? 
                AND user_id = ?");
                $query->execute([$threadId, $userId]);
            } else {
                $query = $this->pdo->prepare("UPDATE thread_ratings 
                SET thread_rating = ?
                WHERE thread_id = ? 
                AND user_id = ?");
                $query->execute([$rating, $threadId, $userId]);
            }
        } else {
            $query = $this->pdo->prepare("INSERT INTO thread_ratings (thread_id, user_id, thread_rating)
                VALUES (?, ?, ?)");
            $query->execute([$threadId, $userId, $rating]);
        }
    }

    function getThreadRating($threadId, $userId)
    {
        $query = $this->pdo->prepare("SELECT thread_rating FROM thread_ratings
            WHERE thread_id = ?
            AND user_id = ?");

        $query->execute([$threadId, $userId]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function getPositiveRatingsForThread($threadId)
    {
        $query = $this->pdo->prepare("SELECT COUNT(*) FROM thread_ratings
            WHERE thread_id = ?
            AND thread_rating = 1");

        $query->execute([$threadId]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function getNegativeRatingsForThread($threadId)
    {
        $query = $this->pdo->prepare("SELECT COUNT(*) FROM thread_ratings
            WHERE thread_id = ?
            AND thread_rating = 0");

        $query->execute([$threadId]);

        return $query->fetch(PDO::FETCH_ASSOC);
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
        if ($stmt->execute($data)) {
            return TRUE;
        } else {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }

    function changeGroupBannedStatus($data)
    {
        $stmt = $this->pdo->prepare('UPDATE groups SET group_banned = :banStatus WHERE group_id = :id');
        if ($stmt->execute($data)) {
            return TRUE;
        } else {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }

    function deleteUser($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE user_id = ?');
        if ($stmt->execute([$id])) {
            return TRUE;
        } else {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }

    function deleteGroup($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM groups WHERE group_id = ?');
        if ($stmt->execute([$id])) {
            return TRUE;
        } else {
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
        if ($stmt->execute($data)) {
            return TRUE;
        } else {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }

    function getNicknames()
    {
        $stmt = $this->pdo->query('SELECT user_nickname FROM users');
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function isUsernameAvailable($newUsername)
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE user_nickname = ?');
        $stmt->execute([$newUsername]);

        // Fetch the result
        $count = $stmt->fetchColumn();

        return $count;
    }
}
