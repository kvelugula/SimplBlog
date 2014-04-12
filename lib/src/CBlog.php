<?php

/** 
 * @author Krishna
 * 
 */
class CBlog {
    /**
     * Fetches all posts from the Blog DB
     * @return mysqli_result (or) boolean FALSE
     */
    public static function getAllPosts() {
        $db = CDb::getInstance();
        $dbconn = $db->getConnection();
        $result = $dbconn->query("SELECT  `id`, `postTitle`, `postText`, "
                . "`authorName`, `authorEmail`, `ts` FROM `tab_posts` "
                . "ORDER BY ts DESC");
        return $result;
    }
    
    /**
     * Fetches the CPost object for the given Post ID
     * @param integer $postId
     * @return CPost
     */
    public static function getPostById($postId) {
        $db = CDb::getInstance();
        $dbconn = $db->getConnection();
        if (!($stmt = $dbconn->prepare(
                "SELECT  `id`, `postTitle`, `postText`, `authorName`, "
                . "`authorEmail`, `ts` FROM `tab_posts` WHERE `id` = ? "))) {
            echo "Prepare failed: (" . $dbconn->errno . ") " . $dbconn->error;
        }
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $obj = $stmt->get_result()->fetch_object("CPost");
        return $obj;
    }    
}

