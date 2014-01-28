<?php

class CUser {
 
   /**
   * Members
   */
    private $usr   = null;               // The PDO object
    
   public function __construct($db) {
   $this->db=$db;}
    
   /**
   * Log in user if password and username are correct
   *
   * @param string $user input username
   * @param string $password input password
   */
    public function login($user, $password){
    $sql = "SELECT acronym, name FROM oophp_User WHERE acronym = '" . $user . "' AND password = md5(concat('" . $password . "', salt));";
    $res = $this->db->ExecuteSelectQueryAndFetchAll($sql);
    if(isset($res[0])) {
    $_SESSION['user'] = $res[0];
  }
    }
    
    /**
    * Log out user
    */
    public function logout(){
    	    unset($_SESSION['user']);
    }
    
    /** 
    * Check if user is logged in
    */
    public function authenticated(){
    	    return isset($_SESSION['user']) ? $_SESSION['user']->acronym : null; 
    }
    
    /** 
    * Return username of the user
    */
    public function getacronym(){
    	   return $_SESSION['user']->acronym; 
    }
    
    /** 
    * Return name of the user
    */
    public function getname(){
    	    return $_SESSION['user']->name; 
    }
    
    
    
    
}
