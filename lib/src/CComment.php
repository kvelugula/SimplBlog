<?php

/** 
 * @author Krishna
 * 
 */
class CComment {
    
    public $id;
    public $postId;
    public $commentText;
    public $authorName;
    public $authorEmail;
    public $ts;
    
    /**
     * Sets the comment data for a new comment
     * @param integer $postId
     * @param string $commentText
     * @param string $authorName
     * @param string $authorEmail
     */
    public function setData($postId, $commentText, $authorName, $authorEmail) {
        $this->postId = $postId;
        $this->commentText = $commentText;
        $this->authorName = $authorName;
        $this->authorEmail = $authorEmail;
    }
    
    /**
     * Create a DB entry for a new comment
     */
    public function create() {
        $db = CDb::getInstance ();
        $dbconn = $db->getConnection ();
        
        if (! ($stmt = $dbconn->prepare ( "INSERT INTO `tab_comments` (`postId`, `commentText`, " . "`authorName`, `authorEmail`) VALUES (?, ?, ?, ?)" ))) {
            echo "Prepare failed: (" . $dbconn->errno . ") " . $dbconn->error;
        }
        
        // Bind 4 strings
        $stmt->bind_param ( "isss", $this->postId, $this->commentText, $this->authorName, $this->authorEmail );
        if (! $stmt->execute ()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $this->id = $stmt->insert_id;
        $stmt->close ();
    }    
}

