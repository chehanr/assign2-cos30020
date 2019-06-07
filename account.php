<?php
/**
 * Handle Account.
 *
 */
class Account
{
    private $db;
    private $id;
    private $email;
    private $profileName;
    private $dateStarted;
    private $numOfFriends;

    /**
     * Constructor.
     *
     * @param Database $db *DB object*
     * @param int $userId *Account ID*
     */
    public function __construct($db, $userId)
    {
        $this->db = $db;
        $this->id = $userId;
        $this->email = null;
        $this->profileName = null;
        $this->dateStarted = null;
        $this->numOfFriends = null;
    }

    /**
     * Get the account's email.
     *
     * @return string
     */
    public function getEmail()
    {
        $dbConn = $this->db->getNewConnection();
        $_id = $this->id;

        $query = "SELECT `friend_email` FROM friends WHERE `friend_id` = '$_id'";
        $result = mysqli_query($dbConn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->email = $row["friend_email"];
            }
        }

        $this->db->closeConnection();

        return $this->email;
    }

    /**
     * Get the account's id.
     *
     * @return int
     */
    public function getId()
    {
        $dbConn = $this->db->getNewConnection();
        $_id = $this->id;

        $query = "SELECT `friend_id` FROM friends WHERE `friend_id` = '$_id'";
        $result = mysqli_query($dbConn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->id = (int)$row["friend_id"];
            }
        }

        $this->db->closeConnection();

        return $this->id;
    }

    /**
     * Get the account's profile name.
     *
     * @return string
     */
    public function getProfileName()
    {
        $dbConn = $this->db->getNewConnection();
        $_id = $this->id;

        $query = "SELECT `profile_name` FROM friends WHERE `friend_id` = '$_id'";
        $result = mysqli_query($dbConn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->profileName = $row["profile_name"];
            }
        }

        $this->db->closeConnection();

        return $this->profileName;
    }

    /**
     * Get the account's started date.
     *
     * @return string
     */
    public function getDateStarted()
    {
        $dbConn = $this->db->getNewConnection();
        $_id = $this->id;

        $query = "SELECT `date_started` FROM friends WHERE `friend_id` = '$_id'";
        $result = mysqli_query($dbConn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->dateStarted = $row["date_started"];
            }
        }

        $this->db->closeConnection();

        return $this->dateStarted;
    }

    /**
     * Get the account's number of friends.
     *
     * @return int
     */
    public function getNumOfFriends()
    {
        $dbConn = $this->db->getNewConnection();
        $_id = $this->id;

        $query = "SELECT `num_of_friends` FROM friends WHERE `friend_id` = '$_id'";
        $result = mysqli_query($dbConn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->numOfFriends = (int)$row["num_of_friends"];
            }
        }

        $this->db->closeConnection();

        return $this->numOfFriends;
    }

    /**
    * Get the account's number of friends.
    * @param int $number *New number of friends*
    * @return bool
    */
    public function setNumOfFriends($number)
    {
        $dbConn = $this->db->getNewConnection();
        $_id = $this->id;

        $query = "UPDATE friends SET `num_of_friends` = '$number' WHERE `friend_id` = '$_id'";

        if ($this->getNumOfFriends() >= 0) {
            $result = mysqli_query($dbConn, $query);
            if ($result) {
                return TRUE;

                $this->db->closeConnection();
            }

        }

        $this->db->closeConnection();

        return FALSE;
    }
}
?>