<?php

/** 
 * @author Krishna
 * 
 */
class CUtils {
    /**
     * Truncates the given string to the specified number of characters
     * @param string $string
     * @param number $length
     * @return string
     */
    public static function truncateText ($string, $length = 100) {
        if ($length < strlen($string)) {
            $string = substr($string, 0, $length);
            $string .= "...";
        }
        return $string;
    }
    
    /**
     * Provides a formatted date text for the given MySQL Timestamp
     * @param MySQLTimeStamp $timestamp
     * @return string
     */
    public static function formatTS ($timestamp) {
        $dt = new DateTime($timestamp);
        return $dt->format('M j Y g:i A');
    }
    
    /**
     * Redirects the user to the homepage or any specific post 
     * @param string $page
     * @param string $postId
     */
    public static function redirectUser ($page = 'home', $postId =  NULL) {
        if (($page === "post") && !empty($postId)) {
            header("location: post.php?id=$postId");
        } else {
            header("location: index.php");
        }
    }
    
    
    /**
     * Generates a new CSRF token if the old one is not valid 
     * and returns it in a array
     * @return multitype:unknown string 
     */
    public static function generateCsrfToken() {
        if(!isset($_SESSION)){
            session_start();
        }
        if(!isset($_SESSION['csrf_token_name'])) {
            $_SESSION['csrf_token_name'] = uniqid();
            $_SESSION['csrf_token_value'] = hash('sha256', uniqid());
        }
        return array(
                'csrfKey' => $_SESSION['csrf_token_name'],
                'csrfValue' => $_SESSION['csrf_token_value']);
    
    }
    
    /**
     * Check if the CSRF token provided in POST data is valid
     * @return boolean
     */
    public static function checkCsrfTokenPost() {
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_POST[$_SESSION['csrf_token_name']]) &&
        ($_POST[$_SESSION['csrf_token_name']] === $_SESSION['csrf_token_value'])) {
            unset($_SESSION['csrf_token_name']);
            unset($_SESSION['csrf_token_value']);
            return true;
        } else {
            return false;
        }
    
    }
}
