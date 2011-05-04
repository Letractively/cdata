<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|==========================================================
| Cdata User Authentication Class
|
| (Basic User-Role/User-Permissions autentication class)
| based on "sentry" library by Chris Schletter http://codeigniter.com/wiki/sentry/ 
 and Rapyd Auth Class
| 
|==========================================================
*/

/**
 *
 * @package    cdata
 * @author     Luigi Clemente
 * @version    0.1
 * @access     public
 */
class Cdata_user{
 
  var $field_username = "user_name";  //you can switch with email if login is email based (i.e. gmail login)
  var $password_encrypted = true;
  var $cookie_expiration = 31536000; //one year
  var $initialized = false;
  var $db = null;
  var $auth_namespace = "cdata";
    
  function Cdata_user()
  {
    $this->ci =& get_instance();
    $this->session =& $this->ci->session;
  }
 
  function init()
  {
    if (!$this->initialized)
    {
      //load needed libraries     
      $this->ci->load->database();
      $this->ci->load->library('encrypt');
      $this->ci->load->helper('cookie');
      $this->ci->load->library("layout");
      $this->ci->load->library('relation');
      $this->initialized = true;
    }
    $this->db =& $this->ci->db;
    $this->relation =& $this->ci->relation; 
  }
 
 
 
  /**
   * Try to validate a login, set user session data, and optionally store a persistence cookie (to autologin)
   *
   * @param  string  $username  Username to login
   * @param  string  $password  Password to match user
   * @param  bool  $session (true)  Set session data here. False to set your own
   * @param  int   $max_role  is the max role_id needed to save cookie (1: save for all users, 3: only for web,
   */
  function trylogin($username, $password, $cookie = false, $max_role=1)
  {
    $this->init();

    // Check details in DB
    $password_hash =  md5($password);
    $q = "SELECT * FROM users WHERE user_name = '$username' AND password = '$password_hash' AND active = 'y'";
    $query = $this->db->query($q);
  
    // If user/pass is OK then should return 1 row containing username,fullname
    $return = $query->num_rows();
    $row = $query->row();
    
    if($return)
    {
      // update last login datetime
      $this->db->set("lastlogin", date("Y-m-d H:i:s"));
      $this->db->where($this->field_username, $username);
      $this->db->update("users");
        
      // Set session data array
      $this->session->set_userdata("user_name", $row->user_name);
      $this->session->set_userdata("email",     $row->email);
      $this->session->set_userdata("name",      $row->name);
      $this->session->set_userdata("role_id",   $row->role_id);
      $this->session->set_userdata("user_id",   $row->user_id);
      $this->session->set_userdata("ip_address", $this->ci->input->ip_address());
      
      if( $cookie == true && $max_role <= $row->role_id){
         $this->_set_cookie($username,$password);
      }
      return true;
      
    } else {
      return false;
    }
  }
 
  /**
   * Try to login by cookie
   *
   * @return  void
   */
  function trylogin_bycookie()
  {
    $this->init();
    
    $cookie = get_cookie($this->auth_namespace);
    if (!$this->is_logged() && $cookie){
      $auth_fields = unserialize(stripslashes($cookie));
      return $this->trylogin( $auth_fields['username'] , $auth_fields['password'], true);
    }
    return false;
  }
 
 
  /**
   * Logout user and reset session data
   */
  function logout(){
    $this->_unset_cookie();
    $this->session->sess_destroy();
  }
   
 
    /**
   * set login cookie
   *
   * @return  void
   */
  function _set_cookie($username,$password)
  {
    $this->init();
    
    $auth_fields = array();
    $auth_fields['username'] = $username;
    $auth_fields['password'] = $password;
    $auth_data = serialize($auth_fields);
    
    $cookie = array('name' => $this->auth_namespace, 'value' => $auth_data, 'expire' => $this->cookie_expiration);
    set_cookie($cookie);
  }

  /**
   * unset login cookie
   *
   * @return  void
   */
  function _unset_cookie()
  {
    
      $this->init();
    $cookie = array('name' => '', 'value' => '', 'expire' => time() - 3600, 'path' => '/', 'domain' => $this->getDomain() );
    set_cookie($cookie);
    
  }
 
  
  function getDomain () {
      if ( isset($_SERVER['HTTP_HOST']) )
        {
        $dom = $_SERVER['HTTP_HOST']; // Get domain
        // Strip www from the domain
        if (strtolower(substr($dom, 0, 4)) == 'www.') { $dom = substr($dom, 4); }
        // Check if a port is used, and if it is, strip that info
        $uses_port = strpos($dom, ':');
        if ($uses_port) { $dom = substr($dom, 0, $uses_port); }
        // Add period to Domain (to work with or without www and on subdomains)
        $dom = '.' . $dom;
        }
        else
        {
        $dom = false;
        }
    return $dom;
    }

  /**
   * Check stored user_id  (user is logged)
   *
   * @return  bool  user is logged
   */
  function is_logged()
  {
    $this->init();
    
    $user_id = $this->session->userdata('user_id');
    $ip_address = $this->session->userdata('ip_address');
    
    if(!$user_id) return false; //no valid session available;
    
    if($ip_address!=$this->ci->input->ip_address()){//hacking attemp;
      $this->logout();
      return false; 
    }
    return true;
  }


  /**
   * Get stored user role
   *
   * @return  int role_id
   */
  function get_role()
  {
    return $this->session->userdata('role_id');
  }
 
  /**
   * Get stored user_id
   *
   * @return  int user_id
   */
  function get_user_id()
  {
    return $this->session->userdata('user_id');
  }
 
  /**
   * Get stored user data 
   *
   * @return  mixed an array of logged user data, or the single value for the given key (i.e. get_user_data("user_name"))
   */
  function get_user_data($key=null)
  {
    return $this->session->userdata($key);
  }
  
  /**
   * Check user role
   *
   * @param   int  $role_id 
   * @param   bool $strict ("root" is also "admin", "operator" etc..)
   * @return  bool user has the role_id (or, if strict==false) or his role is more important 
   */
  function check_role($role_id, $strict=false)
  {
    $this->init();
    
    //not logged  
    if (!$this->is_logged())  return false;
    $rid = $this->session->userdata('role_id');
    if (($strict && ($rid == $role_id)) || (!$strict && ($rid <= $role_id))){
      return true;
    } else {
      return false;
   }
  } 
 

  /**
   * Checks if user exist
   *
   * @param  string  $username
   * @return  bool  user exist
   */
  function user_exists($username)
  {
    $this->init();
    
    $this->db->select("user_id");
    $this->db->from("users");
    $this->db->where($this->field_username,$username);
    $query = $this->db->get();
    return $query->num_rows();
  }
 
  
  /**
   * Check if account is active
   *
   * @param  string  $username 
   * @return  bool  active
   */
  function is_active($username)
  {
    $this->init();
    
    $this->db->select("active");
    $this->db->from("users");
    $this->db->where($this->field_username,$username);
    $this->db->where("active","y");
    $query = $this->db->get();
    return $query->num_rows();
  }
  
  
  function noAuth(){
      redirect ("cpage/page/noauth");
  }
  
  
  function lockedPage($class, $id){
  
    $info = $this->getLockInfo($class, $id);
    redirect ("cpage/locked/".$info["time"]."/".$info["interval"]);
    
  }
  
  
  function permission($class = null, $action = null, $id = null){
      $this->init();

        if (!$this->is_logged()){
            $role = -1;
        }
    
        //is root
        //can do everything
        if ($this->check_role(1)) return true;
        
        //security
        $role = $this->get_role();
        
        if($this->db_permission_check($class, $action, $role)) {
            return true;    
        } else {
            return false;
        }
  }
    
  
  function check_permission($class = null, $action = null, $id = null){
      $this->init();

    //not logged  
    
    if ($class == "cpage"){
        //home page open
        return true;
    } 
    if (!$this->is_logged()){
        // check access permission for guest    
        if($this->db_permission_check("app","acccess",-1)){
            return true;
        } else {
            $this->noAuth();
        }
    }
    
    //is root
    //can do everything
    if ($this->check_role(1)) {
        if ($action == "edit" and !isset($_REQUEST["submit"])) { //only edit form first loading
            if ($this->checkLock($class, $id, $this->get_user_id())){
                //ok
                return true;
            } else {
                $this->lockedPage($class, $id);
            } 
        }
        return true;    
    }
    
    
    //default true
    $ok = true;

    //security
    $role = $this->get_role();
    
    //permission check
    if(!$this->db_permission_check($class, $action, $role)) {
        $ok = false;    
    } 
    
    //only for operator role 4 and dbamin role 3
    if($ok == true and ($role == 4 or $role == 3) and ($class == "pform" or $class == "patient") 
    and ($action == "view" or $action == "edit" or $action == "delete" or $action == "admin")){
        //check centre matching
        $user_centre = $this->get_centre();
        $patient_centre = $this->get_patient_centre($class, $id);
        //permission check
        if($patient_centre <> -1 and $user_centre <> $patient_centre ) {
            $ok = false;    
        } 
    }
    
      //take action
    if($ok == true) {
        //now check locking at form first loading
        if ($action == "edit"  AND !isset($_REQUEST["submit"])) {
            if ($this->checkLock($class, $id, $this->get_user_id())){
            //ok
            return true;
            } else {
                $this->lockedPage($class, $id);
                return true;
            }     
            return true;    
        }
    } else {
        $this->noAuth();
    }
  }
  
  function db_permission_check($class_id, $action_id, $role_id) {
      $q = "SELECT * from security_permission_value WHERE permission_id =1";
    $r = mysql_fetch_assoc(mysql_query($q));
    if (preg_match('/\b'.$class_id."_".$action_id."_".$role_id.'\b/', $r["value"])) {
        return true;    
    } 
    return false;
  }
  
  
  /**
   * Check if user has a permission
   *
   * @param  int  $permission_id
   * @return  bool  has permission
   */
  function has_permission($permission_id)
  { 
    $this->init();
    
    //not logged  
    if (!$this->is_logged())  return false;

    //is root
    if ($this->check_role(1)) return true;

    //security
    $role = $this->db->escape($this->get_role());
    $permission = $this->db->escape($permission_id);
    $uid = $this->db->escape($this->get_user_id());
    
    //role-permission
    $role_permission = false; //by default we assume that it's not allowed
    $query = $this->db->query("SELECT 1 FROM security_role_permission WHERE (role_id=$role AND permission_id=$permission) OR (role_id=$role AND permission_id=1)");
    if ($query->num_rows())
    {
      $row = $query->row();
      $role_permission = (bool)$row->allow_deny;
    }
    
    //user-permission (allow-deny)
    $query = $this->db->query("SELECT allow_deny FROM security_user_permission WHERE (user_id=$uid AND permission_id=$permission) OR (user_id=$uid AND permission_id=1)");
    if ($query->num_rows())
    {
      $row = $query->row();
      $user_permission = (bool)$row->allow_deny;
      return $user_permission;
    }
    
    return $role_permission;

  }
  
  function get_user_email($id){
      
      $q = "SELECT email FROM users WHERE user_id = $id";
      $rs = mysql_query($q);
      $r = mysql_fetch_assoc($rs);
      return $r["email"];
      
  }
  
  function get_centre(){
      $id = $this->session->userdata('user_id');
      $q = "SELECT centre FROM users WHERE user_id = $id";
      $rs = mysql_query($q);
      $r = mysql_fetch_assoc($rs);
      return $r["centre"];
      
  }
  
  // return patient centre if exist otherwise -1
  function get_patient_centre($class = "root", $id = "0"){
        if($class == "root"){
            return -1;
        }
        if($class == "patient"){
            $q = "SELECT serialized FROM patient  
            WHERE patient_id = $id";
            $r = mysql_fetch_array(mysql_query($q));
            $unser = unserialize($r["serialized"]);
            $centre = $unser["centre"];
            return $centre;
        }
        list($pclass, $pid, $name) = $this->getParentNode($class,$id);
        $p = "";
        $class = $pclass; $id = $pid;        
        while ($class <> "root"){
            list($pclass, $pid, $name) = $this->getParentNode($class,$id);        
            if($class == "patient"){
                $q = "SELECT serialized FROM patient  
                WHERE patient_id = $id";
                $r = mysql_fetch_array(mysql_query($q));
                $unser = unserialize($r["serialized"]);
                $centre = $unser["centre"];
                return $centre;
            }
            $class = $pclass; $id = $pid;             
        }     
        return -1;
    }

    function getParentNode($class, $id){
        if(!$class > "" or !$id > ""){
            return array("root", 0, "Root");
        } 
        $title = $this->object_table[$class]["pathName"];
        $q = "SELECT pclass, pid, $title FROM {$this->object_table[$class]["table"]} 
        WHERE {$this->object_table[$class]["id"]} = $id";
        $r = mysql_fetch_array(mysql_query($q));
        return array($r["pclass"], $r["pid"], stripslashes($r[$title])); 
    }
    
    
    function isLocked($class, $id){
        $lockingInterval = 15*60; //sec
        $q = "SELECT *, UNIX_TIMESTAMP(locktime) as time FROM locking WHERE class = '$class' and id = $id";
        $rs = mysql_query($q);
        if (mysql_numrows($rs)>0){
            $r = mysql_fetch_assoc($rs);
            $lapse = time() - $r["time"];
            if ( $lapse < $lockingInterval ){
                return ceil(($lockingInterval-$lapse)/60); //waiting time in minutes
            } 
            else {
                return 0;
            }
        } 
        else {
            return 0;
        }
    
    }
    
    function getLockInfo($class, $id){
        
        $info = array();
        $q = "SELECT *, UNIX_TIMESTAMP(locktime) as time FROM locking WHERE class = '$class' and id = $id";
        $rs = mysql_query($q);
        if (mysql_numrows($rs)>0){
            $r = mysql_fetch_assoc($rs);
            $info["time"] = $r["time"];
            $info["interval"] = "15";
        } 
        return $info;
    
    }
    
    
    function releaseLock($class, $id){
        
        $q = "DELETE FROM locking WHERE class = '$class' and id = $id";
        $rs = mysql_query($q);
        
    }
    
    function setLock($class, $id, $userid){
        
        $this->releaseLock($class, $id);
        $q = "INSERT INTO locking SET class = '$class', id = $id, user_id = $userid";
        if (!mysql_query($q)){print mysql_error(); exit;}
        
    }
    
    
    function checkLock ($class, $id, $userid){
    
        $wait = $this->isLocked($class, $id);
        
        if ( $wait == 0){
            $this->setLock($class, $id, $userid);
            return true;
        } else {
            return false;
        }
        
    }
    
 
}

?>