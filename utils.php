<?php
/**
 * Get account email from an ID.
 *
 * @param DB $db *Database object*
 * @param int $id *Account ID*
 * @return string
 */
function getEmailFromId($db, $id)
{
    $dbConn = $db->getNewConnection();

    $email = null;

    $query = "SELECT `friend_email` FROM friends WHERE `friend_id` = '$id';";
    $result = mysqli_query($dbConn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $email = $row["friend_email"];
        }
    }

    $db->closeConnection();

    return $email;
}

/**
 * Get account ID from an email.
 *
 * @param DB $db *Database object*
 * @param string $email *Account email*
 * @return int
 */
function getIdFromEmail($db, $email)
{
    $dbConn = $db->getNewConnection();

    $id = null;

    $query = "SELECT `friend_id` FROM friends WHERE `friend_email` = '$email';";
    $result = mysqli_query($dbConn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row["friend_id"];
        }
    }

    $db->closeConnection();

    return $id;
}

/**
 * Sort list of ids by profile name.
 *
 * @param DB $db *Database object*
 * @param array $accountIdList *Account ID list*
 * @return array *Sorted account ID list*
 */
function sortAccountsByName($db, $accountIdList)
{
    $dbConn = $db->getNewConnection();

    $list = array();

    $query = "SELECT `friend_id` FROM friends ORDER BY `profile_name` ASC;";
    $result = mysqli_query($dbConn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row["friend_id"];
            if (in_array($id, $accountIdList)) {
                array_push($list, $id);
            }
        }
    }

    $db->closeConnection();

    return $list;
}
?>