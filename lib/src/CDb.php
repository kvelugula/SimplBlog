<?php

/**
 *
 * @author Krishna
 *        
 */
class CDb {
    private $_connection;
    private static $_instance;
    
    /**
     * Fetches the instance of the CDb Singleton 
     * @return CDb
     */
    public static function getInstance() {
        if (!self::$_instance) { 
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * Private constructor used for one time creation 
     * of a new MySQLi connection
     */
    private function __construct() {
        global $config;
        $db_conf = $config['db'];
        $this->_connection = new mysqli(
                $db_conf['hostname'], $db_conf['username'],
                $db_conf['password'], $db_conf['database']);
    
        // Error handling
        if (mysqli_connect_error()) {
            trigger_error("Failed to conencto to MySQL: " .
                    mysql_connect_error(), E_USER_ERROR);
        }
    }
    
    /**
     * Disable cloning my marking the clone operation as private
     */
    private function __clone() {
    
    }
    
    /**
     * Fetches the active commection
     * @return mysqli
     */
    public function getConnection() {
        return $this->_connection;
    }    
}
