<?php
/**
 * Handle database.
 *
 */
class DB
{
    private $dbHost;
    private $dbUsername;
    private $dbPassword;
    private $dbName;

    private $dbConnection;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        include "db_conf.php";

        $this->dbHost = $dbHost;
        $this->dbUsername = $dbUsername;
        $this->dbPassword = $dbPassword;
        $this->dbName = $dbName;
    }

    /**
     * Close the current db connection.
     *
     */
    public function closeConnection()
    {
        if ($this->dbConnection) {
            if (mysqli_ping($this->dbConnection)) {
                mysqli_close($this->dbConnection);
            }
        }
    }

    /**
     * Set a new db connection.
     *
     */
    public function setNewConnection()
    {
        $this->dbConnection = mysqli_connect($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
    }

    /**
     * Get a new db connection.
     *
     * @return mysqli
     */
    public function getNewConnection()
    {
        // $this->closeConnection();
        $this->setNewConnection();
        return $this->dbConnection;
    }

    /**
     * Get the current db connection.
     *
     * @return mysqli
     */
    public function getConnection()
    {
        return $this->dbConnection;
    }

    /**
     * Set up the database.
     *
     * @return bool
     */
    public function initDatabase()
    {
        $this->setNewConnection();

        $query = "CREATE TABLE IF NOT EXISTS friends (
                `friend_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `friend_email` VARCHAR(50) NOT NULL,
                `password` VARCHAR(20) NOT NULL,
                `profile_name` VARCHAR(30) NOT NULL,
                `date_started` DATE NOT NULL,
                `num_of_friends` INT UNSIGNED,
                UNIQUE (friend_email)
            );

            CREATE TABLE IF NOT EXISTS myfriends (
                `friend_id1` INT NOT NULL,
                `friend_id2` INT NOT NULL,
                CHECK (friend_id1 != friend_id2)
            );

            ALTER TABLE `myfriends`
                    ADD CONSTRAINT `FK_friend_id1`
                    FOREIGN KEY (`friend_id1`)
                    REFERENCES `friends` (`friend_id`)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE,
                    ADD CONSTRAINT `FK_friend_id2`
                    FOREIGN KEY (`friend_id2`)
                    REFERENCES `friends` (`friend_id`)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE;

            INSERT INTO `friends` (`friend_email`, `password`, `profile_name`, `date_started`, `num_of_friends`) VALUES
                ('abrashier0@mapy.cz', 'ZIezGr7Rh', 'Annora', '2019/05/07', 2),
                ('cjerrolt1@sciencedaily.com', 'crzhezxoDe', 'Cornell', '2019/01/31', 2),
                ('uworgen2@spotify.com', '1qzPYLAO3kP', 'Uta', '2018/08/21', 2),
                ('cguittet3@sphinn.com', 'MNmqrd', 'Cullie', '2019/01/10', 2),
                ('rhuntress4@hatena.ne.jp', 'xxkLsDv7FAC', 'Roseanna', '2018/12/28', 2),
                ('aspencer5@mtv.com', 'phSkHAgqXN', 'Ashli', '2018/12/07', 2),
                ('kfuggle6@addtoany.com', 'VDqifVfQgT3', 'Kristyn', '2018/08/26', 2),
                ('mtomes7@yahoo.co.jp', 'tS421PBa', 'Marni', '2018/10/08', 2),
                ('tposnett8@auda.org.au', 'ieeaIpld9Up', 'Tomas', '2018/06/13', 2),
                ('gchamley9@cmu.edu', 'tQlE2qHknM2a', 'Gianni', '2018/05/14', 2);

            INSERT INTO `myfriends` (`friend_id1`, `friend_id2`) VALUES
                (1, 2),
                (1, 3),
                (2, 3),
                (2, 4),
                (3, 4),
                (3, 5),
                (4, 5),
                (4, 6),
                (5, 6),
                (5, 7),
                (6, 7),
                (6, 8),
                (7, 8),
                (7, 9),
                (8, 9),
                (8, 10),
                (9, 10),
                (9, 1),
                (10, 1),
                (10, 2);
        ";

        $result = mysqli_multi_query($this->dbConnection, $query);

        if ($result) {
            return true;
        }

        return false;
    }
}
?>