<?php

/** 
 * @author Krishna
 * 
 */
class CPost {
    
    /**
     * All variables are declared as public because of two reasons 
     *     1. I am not performing any setter validations
     *     2. I will be able to used this class directly with mysqli_result::fetch_object 
     */
    
    public $id;
    public $postTitle;
    public $postText;
    public $authorName;
    public $authorEmail;
    public $ts;
    
    /**
     * Sets Blog Post data for a new blog post 
     * @param string $postTitle
     * @param string $postText
     * @param string $authorName
     * @param string $authorEmail
     */
    public function setData($postTitle, $postText,
            $authorName, $authorEmail) {
        $this->postTitle = $postTitle;
        $this->postText = $postText;
        $this->authorName = $authorName;
        $this->authorEmail = $authorEmail;
    }
    
    /**
     * Create a DB entry for a new blogpost
     */
    public function create() {
        $db = CDb::getInstance();
        $dbconn = $db->getConnection();
    
        if (!($stmt = $dbconn->prepare(
                "INSERT INTO `tab_posts` (`postTitle`, `postText`, "
                . "`authorName`, `authorEmail`) VALUES (?, ?, ?, ?)"))) {
            echo "Prepare failed: (" . $dbconn->errno . ") " . $dbconn->error;
        }
    
        $stmt->bind_param("ssss", $this->postTitle, $this->postText,
                $this->authorName, $this->authorEmail);
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $this->id = $stmt->insert_id;
        $stmt->close();
    }
    
    /**
     * Fetches all comments related to the blogpost
     */
    public function getComments() {
        $db = CDb::getInstance();
        $dbconn = $db->getConnection();
    
        // Get comments for the post andsort them in ascending order
        if (!($stmt = $dbconn->prepare(
                "SELECT  `id`, `postId`, `commentText`, `authorName`, "
                . "`authorEmail`, `ts` FROM `tab_comments` WHERE `postId` = ? "
                . "ORDER BY ts ASC"))) {
            echo "Prepare failed: (" . $dbconn->errno . ") " . $dbconn->error;
        }
    
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
