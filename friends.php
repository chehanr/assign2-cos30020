<?php
/**
 * Handle relationships.
 *
 */
class Friends
{
    private $db;

    /**
     * Constructor.
     *
     * @param Database $db *DB object*
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Get a account id list of all the registered accounts excluding the authenticated user.
     *
     * @param int $accountId *Account ID*
     * @return array
     */
    public function getAccountList($accountId)
    {
        $dbConn = $this->db->getNewConnection();
        $accountList = array();

        $query = "SELECT `friend_id` FROM friends WHERE `friend_id` != '$accountId' ORDER BY `profile_name` ASC;";
        $result = mysqli_query($dbConn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($accountList, $row["friend_id"]);
            }
        }

        $this->db->closeConnection();

        return $accountList;
    }

    /**
     * Get a account id list of all the friends of the authenticated user.
     *
     * @param int $accountId *Account ID*
     * @return array
     */
    public function getFriendList($accountId)
    {
        $dbConn = $this->db->getNewConnection();
        $friendList = array();

        $query = "SELECT `friend_id2` FROM myfriends WHERE `friend_id1` = '$accountId';";
        $result = mysqli_query($dbConn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($friendList, $row["friend_id2"]);
            }

            $friendList = array_unique($friendList);
        }

        $this->db->closeConnection();

        return $friendList;
    }

    
    /**
     * Get a account id list of all the mutual friends of two users.
     *
     * @param int $userId1 *Account ID 1*
     * @param int $userId2 *Account ID 2*
     * @return array
     */
    public function getMutualFriendList($userId1, $userId2)
    {
        $mutualFriendList = array();

        $user1FriendList = $this->getFriendList($userId1);
        $user2FriendList = $this->getFriendList($userId2);

        $mutualFriendList = array_intersect($user1FriendList, $user2FriendList);

        return $mutualFriendList;
    }

    /**
     * Get the count of all the mutual friends of two users.
     *
     * @param int $userId1 *Account ID 1*
     * @param int $userId2 *Account ID 2*
     * @return int
     */
    public function getMutualFriendCount($userId1, $userId2)
    {
        $count = 0;

        $count = count($this->getMutualFriendList($userId1, $userId2));

        return $count;
    }

    /**
     * Add a friend connection record.
     *
     * @param Account $userAccount *Authenticated user object*
     * @param Account $friendAccount *Other user object*
     * @return bool
     */
    public function addFriend($userAccount, $friendAccount)
    {
        $dbConn = $this->db->getNewConnection();

        $userId = $userAccount->getId();
        $friendId = $friendAccount->getId();

        $friendList = $this->getFriendList($userId);

        if (!in_array($friendId, $friendList)) {
            $query = "INSERT INTO `myfriends` (`friend_id1`, `friend_id2`) VALUES ('$userId', '$friendId');";
            $result = mysqli_query($dbConn, $query);

            if ($result) {
                $friendCount = count($this->getFriendList($userId));
                if ($userAccount->setNumOfFriends($friendCount)) {
                    $this->db->closeConnection();

                    return TRUE;
                }
            }
        }

        $this->db->closeConnection();

        return FALSE;
    }

    /**
     * Remove a friend connection record.
     *
     * @param Account $userAccount *Authenticated user object*
     * @param Account $friendAccount *Other user object*
     * @return bool
     */
    public function removeFriend($userAccount, $friendAccount)
    {
        $dbConn = $this->db->getNewConnection();

        $userId = $userAccount->getId();
        $friendId = $friendAccount->getId();

        $friendList = $this->getFriendList($userId);

        if (in_array($friendId, $friendList)) {
            $query = "DELETE FROM `myfriends` WHERE `friend_id1` = '$userId' AND `friend_id2` = '$friendId';";
            $result = mysqli_query($dbConn, $query);

            if ($result) {
                $friendCount = count($this->getFriendList($userId));
                if ($userAccount->setNumOfFriends($friendCount)) {
                    $this->db->closeConnection();

                    return TRUE;
                }
            }
        }

        $this->db->closeConnection();

        return FALSE;
    }
}
?>