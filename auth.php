<?php
/**
 * Handle Authentication.
 *
 */
class Auth
{
    private $db;
    private $userId;
    private $authKey;

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
     * Updates the session vars.
     *
     * @param int $userId *Account ID*
     * @param string $authKey *Key*
     */
    private function updateSession($userId, $authKey)
    {
        $authSession = array();
        $authSession["USER_ID"] = $userId;
        $authSession["KEY"] = $authKey;

        $_SESSION["AUTH_SESSION"] = $authSession;
    }

    /**
     * Check if an email is already registered.
     *
     * @param string $email *Email*
     * @return bool
     */
    public function checkUnique($email)
    {
        $dbConn = $this->db->getNewConnection();
        $isUnique = true;

        $query = "SELECT `friend_email` FROM friends WHERE `friend_email` = '$email'";
        $result = mysqli_query($dbConn, $query);

        if (mysqli_num_rows($result) > 0) {
            $isUnique = false;
        }

        $this->db->closeConnection();

        return $isUnique;
    }

    /**
     * Register an account.
     *
     * @param string $email *Email*
     * @param string $profileName *Profile name*
     * @param string $password *Password*
     * @return bool
     */
    public function register($email, $profileName, $password)
    {
        $dbConn = $this->db->getNewConnection();

        $isUnique = $this->checkUnique($email);
        $result = null;

        if ($isUnique) {
            $currentDate = date("Y/m/d");
            $query = "INSERT INTO `friends` (`friend_email`, `password`, `profile_name`, `date_started`, `num_of_friends`)
                        VALUES ('$email', '$password', '$profileName', '$currentDate', 0);
            ";

            $result = mysqli_query($dbConn, $query);
        }

        if ($result) {
            return true;

            $this->db->closeConnection();

        }

        $this->db->closeConnection();

        return false;
    }

    /**
     * Login and update session vars.
     *
     * @param string $email *Email*
     * @param string $password *Password*
     */
    public function login($email, $password)
    {
        $dbConn = $this->db->getNewConnection();

        $query = "SELECT `friend_id` FROM friends WHERE `friend_email` = '$email' AND `password` = '$password'";
        $result = mysqli_query($dbConn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->userId = $row["friend_id"];
                $this->authKey = md5(uniqid($this->userId, true));
                $this->updateSession($this->userId, $this->authKey);
            }
        }

        $this->db->closeConnection();

    }

    /**
     * Logout and update session vars.
     *
     */
    public function logout()
    {
        $this->userId = null;
        $this->authKey = null;

        $this->updateSession($this->userId, $this->authKey);
    }

    /**
     * Check if user is authenticated.
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        if (isset($_SESSION["AUTH_SESSION"])) {
            if ($_SESSION["AUTH_SESSION"]["USER_ID"]) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the session vars.
     *
     * @return array
     */
    public function getAuthSession()
    {
        return $_SESSION["AUTH_SESSION"];
    }
}
?>