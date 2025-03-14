<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

/**
 * Name:  Ion Auth Model
 *
 * Author:  Ben Edmunds
 * 		   ben.edmunds@gmail.com
 * 	  	   @benedmunds
 *
 * Added Awesomeness: Phil Sturgeon
 *
 * Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
 *
 * Created:  10.01.2009
 *
 * Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
 *
 * Requirements: PHP5 or above
 *
 */
class Ion_auth_model extends CI_Model
{

     /**
      * Holds an array of tables used
      *
      * @var array
      * */
     public $tables = array();

     /**
      * activation code
      *
      * @var string
      * */
     public $activation_code;

     /**
      * forgotten password key
      *
      * @var string
      * */
     public $forgotten_password_code;

     /**
      * new password
      *
      * @var string
      * */
     public $new_password;

     /**
      * Identity
      *
      * @var string
      * */
     public $identity;

     /**
      * Where
      *
      * @var array
      * */
     public $_ion_where = array();

     /**
      * Select
      *
      * @var array
      * */
     public $_ion_select = array();

     /**
      * Like
      *
      * @var array
      * */
     public $_ion_like = array();

     /**
      * Limit
      *
      * @var string
      * */
     public $_ion_limit = NULL;

     /**
      * Offset
      *
      * @var string
      * */
     public $_ion_offset = NULL;

     /**
      * Order By
      *
      * @var string
      * */
     public $_ion_order_by = NULL;

     /**
      * Order
      *
      * @var string
      * */
     public $_ion_order = NULL;

     /**
      * Hooks
      *
      * @var object
      * */
     protected $_ion_hooks;

     /**
      * Response
      *
      * @var string
      * */
     protected $response = NULL;

     /**
      * message (uses lang file)
      *
      * @var string
      * */
     protected $messages;

     /**
      * error message (uses lang file)
      *
      * @var string
      * */
     protected $errors;

     /**
      * error start delimiter
      *
      * @var string
      * */
     protected $error_start_delimiter;

     /**
      * error end delimiter
      *
      * @var string
      * */
     protected $error_end_delimiter;

     /**
      * caching of users and their groups
      *
      * @var array
      * */
     public $_cache_user_in_group = array();

     /**
      * caching of groups
      *
      * @var array
      * */
     protected $_cache_groups = array();

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->load->config('ion_auth', TRUE);
          $this->load->helper('cookie');
          $this->load->helper('date');

          //Load the session, CI2 as a library, CI3 uses it as a driver
          if (substr(CI_VERSION, 0, 1) == '2') {
               $this->load->library('session');
          } else {
               $this->load->driver('session');
          }

          $this->lang->load('ion_auth');

          //initialize db tables data
          $this->tables = $this->config->item('tables', 'ion_auth');

          //initialize data
          $this->identity_column = $this->config->item('identity', 'ion_auth');
          $this->store_salt = $this->config->item('store_salt', 'ion_auth');
          $this->salt_length = $this->config->item('salt_length', 'ion_auth');
          $this->join = $this->config->item('join', 'ion_auth');


          //initialize hash method options (Bcrypt)
          $this->hash_method = $this->config->item('hash_method', 'ion_auth');
          $this->default_rounds = $this->config->item('default_rounds', 'ion_auth');
          $this->random_rounds = $this->config->item('random_rounds', 'ion_auth');
          $this->min_rounds = $this->config->item('min_rounds', 'ion_auth');
          $this->max_rounds = $this->config->item('max_rounds', 'ion_auth');


          //initialize messages and error
          $this->messages = array();
          $this->errors = array();
          $this->message_start_delimiter = $this->config->item('message_start_delimiter', 'ion_auth');
          $this->message_end_delimiter = $this->config->item('message_end_delimiter', 'ion_auth');
          $this->error_start_delimiter = $this->config->item('error_start_delimiter', 'ion_auth');
          $this->error_end_delimiter = $this->config->item('error_end_delimiter', 'ion_auth');

          //initialize our hooks object
          $this->_ion_hooks = new stdClass;

          //load the bcrypt class if needed
          if ($this->hash_method == 'bcrypt') {
               if ($this->random_rounds) {
                    $rand = rand($this->min_rounds, $this->max_rounds);
                    $rounds = array('rounds' => $rand);
               } else {
                    $rounds = array('rounds' => $this->default_rounds);
               }

               $this->load->library('bcrypt', $rounds);
          }

          $this->trigger_events('model_constructor');
     }

     /**
      * Misc functions
      *
      * Hash password : Hashes the password to be stored in the database.
      * Hash password db : This function takes a password and validates it
      * against an entry in the users table.
      * Salt : Generates a random salt value.
      *
      * @author Mathew
      */

     /**
      * Hashes the password to be stored in the database.
      *
      * @return void
      * @author Mathew
      * */
     public function hash_password($password, $salt = false, $use_sha1_override = FALSE)
     {
          if (empty($password)) {
               return FALSE;
          }

          //bcrypt
          if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt') {
               return $this->bcrypt->hash($password);
          }


          if ($this->store_salt && $salt) {
               return sha1($password . $salt);
          } else {
               $salt = $this->salt();
               return $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
          }
     }

     /**
      * This function takes a password and validates it
      * against an entry in the users table.
      *
      * @return void
      * @author Mathew
      * */
     public function hash_password_db($id, $password, $use_sha1_override = FALSE)
     {
          if (empty($id) || empty($password)) {
               return FALSE;
          }

          $this->trigger_events('extra_where');

          $query = $this->db->select('usr_password, usr_salt')
               ->where('usr_id', $id)
               ->limit(1)
               ->get($this->tables['users']);

          $hash_password_db = $query->row();

          if ($query->num_rows() !== 1) {
               return FALSE;
          }

          // bcrypt
          if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt') {
               if ($this->bcrypt->verify($password, $hash_password_db->usr_password)) {
                    return TRUE;
               }

               return FALSE;
          }

          // sha1
          if ($this->store_salt) {
               $db_password = sha1($password . $hash_password_db->usr_salt);
          } else {
               $salt = substr($hash_password_db->usr_password, 0, $this->salt_length);

               $db_password = $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
          }

          if ($db_password == $hash_password_db->usr_password) {
               return TRUE;
          } else {
               return FALSE;
          }
     }

     /**
      * Generates a random salt value for forgotten passwords or any other keys. Uses SHA1.
      *
      * @return void
      * @author Mathew
      * */
     public function hash_code($password)
     {
          return $this->hash_password($password, FALSE, TRUE);
     }

     /**
      * Generates a random salt value.
      *
      * @return void
      * @author Mathew
      * */
     public function salt()
     {
          return substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
     }

     /**
      * Activation functions
      *
      * Activate : Validates and removes activation code.
      * Deactivae : Updates a users row with an activation code.
      *
      * @author Mathew
      */

     /**
      * activate
      *
      * @return void
      * @author Mathew
      * */
     public function activate($id, $code = false)
     {
          $this->trigger_events('pre_activate');

          if ($code !== FALSE) {
               $query = $this->db->select($this->identity_column)
                    ->where('usr_activation_code', $code)
                    ->limit(1)
                    ->get($this->tables['users']);

               $result = $query->row();

               if ($query->num_rows() !== 1) {
                    $this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));
                    $this->set_error('activate_unsuccessful');
                    return FALSE;
               }

               $identity = $result->{$this->identity_column};

               $data = array(
                    'usr_activation_code' => NULL,
                    'usr_active' => 1
               );

               $this->trigger_events('extra_where');
               $this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));
          } else {
               $data = array(
                    'usr_activation_code' => NULL,
                    'usr_active' => 1
               );


               $this->trigger_events('extra_where');
               $this->db->update($this->tables['users'], $data, array('usr_id' => $id));
          }


          $return = $this->db->affected_rows() == 1;
          if ($return) {
               $this->trigger_events(array('post_activate', 'post_activate_successful'));
               $this->set_message('activate_successful');
          } else {
               $this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));
               $this->set_error('activate_unsuccessful');
          }


          return $return;
     }

     /**
      * Deactivate
      *
      * @return void
      * @author Mathew
      * */
     public function deactivate($id = NULL)
     {
          $this->trigger_events('deactivate');

          if (!isset($id)) {
               $this->set_error('deactivate_unsuccessful');
               return FALSE;
          }

          $activation_code = sha1(md5(microtime()));
          $this->activation_code = $activation_code;

          $data = array(
               'usr_activation_code' => $activation_code,
               'usr_active' => 0
          );

          $this->trigger_events('extra_where');
          $this->db->update($this->tables['users'], $data, array('usr_id' => $id));

          $return = $this->db->affected_rows() == 1;
          if ($return)
               $this->set_message('deactivate_successful');
          else
               $this->set_error('deactivate_unsuccessful');

          return $return;
     }

     public function clear_forgotten_password_code($code)
     {

          if (empty($code)) {
               return FALSE;
          }

          $this->db->where('usr_forgotten_password_code', $code);

          if ($this->db->count_all_results($this->tables['users']) > 0) {
               $data = array(
                    'usr_forgotten_password_code' => NULL,
                    'usr_forgotten_password_time' => NULL
               );

               $this->db->update($this->tables['users'], $data, array('usr_forgotten_password_code' => $code));

               return TRUE;
          }

          return FALSE;
     }

     /**
      * reset password
      *
      * @return bool
      * @author Mathew
      * */
     public function reset_password($identity, $new)
     {
          $this->trigger_events('pre_change_password');

          if (!$this->identity_check($identity)) {
               $this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
               return FALSE;
          }

          $this->trigger_events('extra_where');

          $query = $this->db->select('usr_id, usr_password, usr_salt')
               ->where($this->identity_column, $identity)
               ->limit(1)
               ->get($this->tables['users']);

          if ($query->num_rows() !== 1) {
               $this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
               $this->set_error('password_change_unsuccessful');
               return FALSE;
          }

          $result = $query->row();

          $new = $this->hash_password($new, $result->salt);

          //store the new password and reset the remember code so all remembered instances have to re-login
          //also clear the forgotten password code
          $data = array(
               'usr_password' => $new,
               'usr_remember_code' => NULL,
               'usr_forgotten_password_code' => NULL,
               'usr_forgotten_password_time' => NULL,
          );

          $this->trigger_events('extra_where');
          $this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));

          $return = $this->db->affected_rows() == 1;
          if ($return) {
               $this->trigger_events(array('post_change_password', 'post_change_password_successful'));
               $this->set_message('password_change_successful');
          } else {
               $this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
               $this->set_error('password_change_unsuccessful');
          }

          return $return;
     }

     /**
      * change password
      *
      * @return bool
      * @author Mathew
      * */
     public function change_password($identity, $old, $new)
     {
          $this->trigger_events('pre_change_password');

          $this->trigger_events('extra_where');

          $query = $this->db->select('usr_id, usr_password, salt')
               ->where($this->identity_column, $identity)
               ->limit(1)
               ->get($this->tables['users']);

          if ($query->num_rows() !== 1) {
               $this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
               $this->set_error('password_change_unsuccessful');
               return FALSE;
          }

          $user = $query->row();

          $old_password_matches = $this->hash_password_db($user->id, $old);

          if ($old_password_matches === TRUE) {
               //store the new password and reset the remember code so all remembered instances have to re-login
               $hashed_new_password = $this->hash_password($new, $user->salt);
               $data = array(
                    'usr_password' => $hashed_new_password,
                    'usr_remember_code' => NULL,
               );

               $this->trigger_events('extra_where');
               $this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));

               $successfully_changed_password_in_db = $this->db->affected_rows() == 1;
               if ($successfully_changed_password_in_db) {
                    $this->trigger_events(array('post_change_password', 'post_change_password_successful'));
                    $this->set_message('password_change_successful');
               } else {
                    $this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
                    $this->set_error('password_change_unsuccessful');
               }

               return $successfully_changed_password_in_db;
          }

          $this->set_error('password_change_unsuccessful');
          return FALSE;
     }

     /**
      * Checks username
      *
      * @return bool
      * @author Mathew
      * */
     public function username_check($username = '', $id = '')
     {
          $this->trigger_events('username_check');

          if (empty($username)) {
               return FALSE;
          }

          $this->trigger_events('extra_where');

          if (!empty($id)) {
               $this->db->where('usr_id !=', $id);
          }

          return $this->db->where('usr_username', $username)
               ->count_all_results($this->tables['users']) > 0;
     }

     /**
      * Checks email
      *
      * @return bool
      * @author Mathew
      * */
     public function email_check($email = '', $id = '')
     {
          $this->trigger_events('email_check');

          if (empty($email)) {
               return FALSE;
          }

          $this->trigger_events('extra_where');
          if (!empty($id)) {
               $this->db->where('usr_id !=', $id);
          }
          return $this->db->where('usr_email', $email)
               ->count_all_results($this->tables['users']) > 0;
     }

     /**
      * Identity check
      *
      * @return bool
      * @author Mathew
      * */
     public function identity_check($identity = '')
     {
          $this->trigger_events('identity_check');

          if (empty($identity)) {
               return FALSE;
          }

          return $this->db->where($this->identity_column, $identity)
               ->count_all_results($this->tables['users']) > 0;
     }

     /**
      * Insert a forgotten password key.
      *
      * @return bool
      * @author Mathew
      * @updated Ryan
      * */
     public function forgotten_password($identity)
     {
          if (empty($identity)) {
               $this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_unsuccessful'));
               return FALSE;
          }

          $key = $this->hash_code(microtime() . $identity);

          $this->forgotten_password_code = $key;

          $this->trigger_events('extra_where');

          $update = array(
               'usr_forgotten_password_code' => $key,
               'usr_forgotten_password_time' => time()
          );

          $this->db->update($this->tables['users'], $update, array($this->identity_column => $identity));

          $return = $this->db->affected_rows() == 1;

          if ($return)
               $this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_successful'));
          else
               $this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_unsuccessful'));

          return $return;
     }

     /**
      * Forgotten Password Complete
      *
      * @return string
      * @author Mathew
      * */
     public function forgotten_password_complete($code, $salt = FALSE)
     {
          $this->trigger_events('pre_forgotten_password_complete');

          if (empty($code)) {
               $this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
               return FALSE;
          }

          $profile = $this->where('usr_forgotten_password_code', $code)->users()->row(); //pass the code to profile

          if ($profile) {

               if ($this->config->item('forgot_password_expiration', 'ion_auth') > 0) {
                    //Make sure it isn't expired
                    $expiration = $this->config->item('forgot_password_expiration', 'ion_auth');
                    if (time() - $profile->usr_forgotten_password_time > $expiration) {
                         //it has expired
                         $this->set_error('forgot_password_expired');
                         $this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
                         return FALSE;
                    }
               }

               $password = $this->salt();

               $data = array(
                    'usr_password' => $this->hash_password($password, $salt),
                    'usr_forgotten_password_code' => NULL,
                    'usr_active' => 1,
               );

               $this->db->update($this->tables['users'], $data, array('usr_forgotten_password_code' => $code));

               $this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_successful'));
               return $password;
          }

          $this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
          return FALSE;
     }

     /**
      * register
      *
      * @return bool
      * @author Mathew
      * */
     public function register($username, $password, $email, $additional_data = array(), $groups = array())
     {
          $this->trigger_events('pre_register');

          $manual_activation = $this->config->item('manual_activation', 'ion_auth');

          if ($this->identity_column == 'usr_email' && $this->email_check($email)) {
               $this->set_error('account_creation_duplicate_email');
               return FALSE;
          } elseif ($this->identity_column == 'usr_username' && $this->username_check($username)) {
               $this->set_error('account_creation_duplicate_username');
               return FALSE;
          }

          // If username is taken, use username1 or username2, etc.
          if ($this->identity_column != 'usr_username') {
               $original_username = $username;
               for ($i = 0; $this->username_check($username); $i++) {
                    if ($i > 0) {
                         $username = $original_username . $i;
                    }
               }
          }

          // IP Address
          $ip_address = $this->_prepare_ip($this->input->ip_address());
          $salt = $this->store_salt ? $this->salt() : FALSE;
          $password = $this->hash_password($password, $salt);

          // Users table.
          $data = array(
               'usr_username' => $username,
               'usr_password' => $password,
               'usr_email' => $email,
               'usr_ip_address' => $ip_address,
               'usr_created_on' => time(),
               'usr_last_login' => time(),
               'usr_active' => ($manual_activation === false ? 1 : 0)
          );

          if ($this->store_salt) {
               $data['usr_salt'] = $salt;
          }

          //filter out any data passed that doesnt have a matching column in the users table
          //and merge the set user data and the additional data
          $user_data = array_merge($this->_filter_data($this->tables['users'], $additional_data), $data);

          $this->trigger_events('extra_set');

          $this->db->insert($this->tables['users'], $user_data);

          $id = $this->db->insert_id();

          if (!empty($groups)) {
               //add to groups
               foreach ($groups as $group) {
                    $this->add_to_group($group, $id);
               }
          }

          //add to default group if not already set
          $default_group = $this->where('name', $this->config->item('default_group', 'ion_auth'))->group()->row();
          if ((isset($default_group->id) && !isset($groups)) || (empty($groups) && !in_array($default_group->id, $groups))) {
               $this->add_to_group($default_group->id, $id);
          }

          $this->trigger_events('post_register');

          return (isset($id)) ? $id : FALSE;
     }

     /**
      * login
      *
      * @return bool
      * @author Mathew
      * */
     public function login($identity, $password, $remember = FALSE)
     {
          $this->trigger_events('pre_login');
          if (empty($identity) || empty($password)) {
               $this->set_error('login_unsuccessful');
               return FALSE;
          }

          $this->trigger_events('extra_where');

          $query = $this->db->select($this->identity_column . ', usr_emp_code, usr_username, usr_showroom, usr_division, usr_email, usr_rol, usr_id, usr_password, usr_active, usr_last_login, usr_avatar, usr_appdownloadlink, ' .
               $this->tables['user_access'] . '.cua_access AS user_access,' .
               TABLE_PREFIX . 'users_groups.group_id,' . TABLE_PREFIX . 'groups.grp_slug AS grp_slug,' .
               TABLE_PREFIX . 'designation.desig_slug,' . TABLE_PREFIX . 'designation.desig_id')
               ->join($this->tables['user_access'], $this->tables['user_access'] . '.cua_group_id = ' . $this->tables['users'] . '.usr_id', 'left')
               ->join(TABLE_PREFIX . 'users_groups', TABLE_PREFIX . 'users_groups.user_id = ' . $this->tables['users'] . '.usr_id', 'left')
               ->join(TABLE_PREFIX . 'groups', TABLE_PREFIX . 'groups.id = ' . TABLE_PREFIX . 'users_groups.group_id', 'left')
               ->join(TABLE_PREFIX . 'designation', TABLE_PREFIX . 'designation.desig_id = ' . $this->tables['users'] . '.usr_designation_new', 'left')
               // ->join(TABLE_PREFIX . 'role', TABLE_PREFIX . 'role.rol_id = ' . $this->tables['users'] . '.usr_rol', 'left')  . TABLE_PREFIX . 'role.rol_access AS user_access_new'
               ->where($this->identity_column, $this->db->escape_str($identity))
               ->limit(1)
               ->get($this->tables['users']);
          //debug($query->row());
          if ($this->is_time_locked_out($identity)) {

               //Hash something anyway, just to take up time
               $this->hash_password($password);

               $this->trigger_events('post_login_unsuccessful');
               $this->set_error('login_timeout');

               return FALSE;
          }

          if ($query->num_rows() === 1) {
               $user = $query->row();
               $password = $this->hash_password_db($user->usr_id, $password);

               if ($password === TRUE) {
                    if ($user->usr_active == 0) {
                         $this->trigger_events('post_login_unsuccessful');
                         $this->set_error('login_unsuccessful_not_active');

                         return FALSE;
                    }

                    $this->set_session($user);

                    $this->update_last_login($user->usr_id);

                    $this->clear_login_attempts($identity);

                    if ($remember && $this->config->item('remember_users', 'ion_auth')) {
                         $this->remember_user($user->usr_id);
                    }

                    $this->trigger_events(array('post_login', 'post_login_successful'));
                    $this->set_message('login_successful');

                    return TRUE;
               }
          }

          //Hash something anyway, just to take up time
          $this->hash_password($password);

          $this->increase_login_attempts($identity);

          $this->trigger_events('post_login_unsuccessful');
          $this->set_error('login_unsuccessful');

          return FALSE;
     }

     /**
      * is_max_login_attempts_exceeded
      * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)
      *
      * @param string $identity
      * @return boolean
      * */
     public function is_max_login_attempts_exceeded($identity)
     {
          if ($this->config->item('track_login_attempts', 'ion_auth')) {
               $max_attempts = $this->config->item('maximum_login_attempts', 'ion_auth');
               if ($max_attempts > 0) {
                    $attempts = $this->get_attempts_num($identity);
                    return $attempts >= $max_attempts;
               }
          }
          return FALSE;
     }

     /**
      * Get number of attempts to login occured from given IP-address or identity
      * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)
      *
      * @param	string $identity
      * @return	int
      */
     function get_attempts_num($identity)
     {
          if ($this->config->item('track_login_attempts', 'ion_auth')) {
               $ip_address = $this->_prepare_ip($this->input->ip_address());

               $this->db->select('1', FALSE);
               $this->db->where('ip_address', $ip_address);
               if (strlen($identity) > 0)
                    $this->db->or_where('login', $identity);

               $qres = $this->db->get($this->tables['login_attempts']);
               return $qres->num_rows();
          }
          return 0;
     }

     /**
      * Get a boolean to determine if an account should be locked out due to
      * exceeded login attempts within a given period
      *
      * @return	boolean
      */
     public function is_time_locked_out($identity)
     {

          return $this->is_max_login_attempts_exceeded($identity) && $this->get_last_attempt_time($identity) > time() - $this->config->item('lockout_time', 'ion_auth');
     }

     /**
      * Get the time of the last time a login attempt occured from given IP-address or identity
      *
      * @param	string $identity
      * @return	int
      */
     public function get_last_attempt_time($identity)
     {
          if ($this->config->item('track_login_attempts', 'ion_auth')) {
               $ip_address = $this->_prepare_ip($this->input->ip_address());

               $this->db->select_max('time');
               $this->db->where('ip_address', $ip_address);
               if (strlen($identity) > 0)
                    $this->db->or_where('login', $identity);
               $qres = $this->db->get($this->tables['login_attempts'], 1);

               if ($qres->num_rows() > 0) {
                    return $qres->row()->time;
               }
          }

          return 0;
     }

     /**
      * increase_login_attempts
      * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)
      *
      * @param string $identity
      * */
     public function increase_login_attempts($identity)
     {
          if ($this->config->item('track_login_attempts', 'ion_auth')) {
               $ip_address = $this->_prepare_ip($this->input->ip_address());
               return $this->db->insert($this->tables['login_attempts'], array('ip_address' => $ip_address, 'login' => $identity, 'time' => time()));
          }
          return FALSE;
     }

     /**
      * clear_login_attempts
      * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)
      *
      * @param string $identity
      * */
     public function clear_login_attempts($identity, $expire_period = 86400)
     {
          if ($this->config->item('track_login_attempts', 'ion_auth')) {
               $ip_address = $this->_prepare_ip($this->input->ip_address());

               $this->db->where(array('ip_address' => $ip_address, 'login' => $identity));
               // Purge obsolete login attempts
               $this->db->or_where('time <', time() - $expire_period, FALSE);

               return $this->db->delete($this->tables['login_attempts']);
          }
          return FALSE;
     }

     public function limit($limit)
     {
          $this->trigger_events('limit');
          $this->_ion_limit = $limit;

          return $this;
     }

     public function offset($offset)
     {
          $this->trigger_events('offset');
          $this->_ion_offset = $offset;

          return $this;
     }

     public function where($where, $value = NULL)
     {
          $this->trigger_events('where');

          if (!is_array($where)) {
               $where = array($where => $value);
          }

          array_push($this->_ion_where, $where);

          return $this;
     }

     public function like($like, $value = NULL)
     {
          $this->trigger_events('like');

          if (!is_array($like)) {
               $like = array($like => $value);
          }

          array_push($this->_ion_like, $like);

          return $this;
     }

     public function select($select)
     {
          $this->trigger_events('select');

          $this->_ion_select[] = $select;

          return $this;
     }

     public function order_by($by, $order = 'desc')
     {
          $this->trigger_events('order_by');

          $this->_ion_order_by = $by;
          $this->_ion_order = $order;

          return $this;
     }

     public function row()
     {
          $this->trigger_events('row');

          $row = $this->response->row();
          $this->response->free_result();

          return $row;
     }

     public function row_array()
     {
          $this->trigger_events(array('row', 'row_array'));

          $row = $this->response->row_array();
          $this->response->free_result();

          return $row;
     }

     public function result()
     {
          $this->trigger_events('result');

          $result = $this->response->result();
          $this->response->free_result();

          return $result;
     }

     public function result_array()
     {
          $this->trigger_events(array('result', 'result_array'));

          $result = $this->response->result_array();
          $this->response->free_result();

          return $result;
     }

     public function num_rows()
     {
          $this->trigger_events(array('num_rows'));

          $result = $this->response->num_rows();
          $this->response->free_result();

          return $result;
     }

     /**
      * users
      *
      * @return object Users
      * @author Ben Edmunds
      * */
     public function users($groups = NULL)
     {
          $this->trigger_events('users');

          if (isset($this->_ion_select) && !empty($this->_ion_select)) {
               foreach ($this->_ion_select as $select) {
                    $this->db->select($select);
               }

               $this->_ion_select = array();
          } else {
               //default selects
               $this->db->select(array(
                    $this->tables['users'] . '.*',
                    $this->tables['users'] . '.id as id',
                    $this->tables['users'] . '.id as user_id'
               ));
          }

          //filter by group id(s) if passed
          if (isset($groups)) {
               //build an array if only one group was passed
               if (is_numeric($groups)) {
                    $groups = array($groups);
               }

               //join and then run a where_in against the group ids
               if (isset($groups) && !empty($groups)) {
                    $this->db->distinct();
                    $this->db->join(
                         $this->tables['users_groups'],
                         $this->tables['users_groups'] . '.' . $this->join['users'] . '=' . $this->tables['users'] . '.usr_id',
                         'inner'
                    );

                    $this->db->join(
                         $this->tables['user_access'],
                         $this->tables['user_access'] . '.cua_user_id' . '=' . $this->tables['users'] . '.usr_id',
                         'left'
                    );

                    $this->db->where_in($this->tables['users_groups'] . '.' . $this->join['groups'], $groups);
               }
          }

          $this->trigger_events('extra_where');

          //run each where that was passed
          if (isset($this->_ion_where) && !empty($this->_ion_where)) {
               foreach ($this->_ion_where as $where) {
                    $this->db->where($where);
               }

               $this->_ion_where = array();
          }

          if (isset($this->_ion_like) && !empty($this->_ion_like)) {
               foreach ($this->_ion_like as $like) {
                    $this->db->or_like($like);
               }

               $this->_ion_like = array();
          }

          if (isset($this->_ion_limit) && isset($this->_ion_offset)) {
               $this->db->limit($this->_ion_limit, $this->_ion_offset);

               $this->_ion_limit = NULL;
               $this->_ion_offset = NULL;
          } else if (isset($this->_ion_limit)) {
               $this->db->limit($this->_ion_limit);

               $this->_ion_limit = NULL;
          }

          //set the order
          if (isset($this->_ion_order_by) && isset($this->_ion_order)) {
               $this->db->order_by($this->_ion_order_by, $this->_ion_order);

               $this->_ion_order = NULL;
               $this->_ion_order_by = NULL;
          }

          $this->response = $this->db->get($this->tables['users']);

          return $this;
     }

     /**
      * user
      *
      * @return object
      * @author Ben Edmunds
      * */
     public function user($id = NULL)
     {
          $this->trigger_events('user');

          //if no id was passed use the current users id
          $id || $id = $this->session->userdata('user_id');

          $this->limit(1);
          $this->where($this->tables['users'] . '.usr_id', $id);

          $this->users();

          return $this;
     }

     /**
      * get_users_groups
      *
      * @return array
      * @author Ben Edmunds
      * */
     public function get_users_groups($id = FALSE)
     {
          $this->trigger_events('get_users_group');

          //if no id was passed use the current users id
          $id || $id = $this->session->userdata('user_id');

          return $this->db->select($this->tables['users_groups'] . '.' . $this->join['groups'] . ' as id, ' . $this->tables['groups'] . '.name, ' . $this->tables['groups'] . '.description')
               ->where($this->tables['users_groups'] . '.' . $this->join['users'], $id)
               ->join($this->tables['groups'], $this->tables['users_groups'] . '.' . $this->join['groups'] . '=' . $this->tables['groups'] . '.id')
               ->get($this->tables['users_groups']);
     }

     /**
      * add_to_group
      *
      * @return bool
      * @author Ben Edmunds
      * */
     public function add_to_group($group_id, $user_id = false)
     {
          $this->trigger_events('add_to_group');

          //if no id was passed use the current users id
          $user_id || $user_id = $this->session->userdata('user_id');

          //check if unique - num_rows() > 0 means row found
          if ($this->db->where(array($this->join['groups'] => (int) $group_id, $this->join['users'] => (int) $user_id))->get($this->tables['users_groups'])->num_rows())
               return false;

          if ($return = $this->db->insert($this->tables['users_groups'], array($this->join['groups'] => (int) $group_id, $this->join['users'] => (int) $user_id))) {
               if (isset($this->_cache_groups[$group_id])) {
                    $group_name = $this->_cache_groups[$group_id];
               } else {
                    $group = $this->group($group_id)->result();
                    $group_name = $group[0]->name;
                    $this->_cache_groups[$group_id] = $group_name;
               }
               $this->_cache_user_in_group[$user_id][$group_id] = $group_name;
          }
          return $return;
     }

     /**
      * remove_from_group
      *
      * @return bool
      * @author Ben Edmunds
      * */
     public function remove_from_group($group_ids = false, $user_id = false)
     {
          $this->trigger_events('remove_from_group');

          // user id is required
          if (empty($user_id)) {
               return FALSE;
          }

          // if group id(s) are passed remove user from the group(s)
          if (!empty($group_ids)) {
               if (!is_array($group_ids)) {
                    $group_ids = array($group_ids);
               }

               foreach ($group_ids as $group_id) {
                    $this->db->delete($this->tables['users_groups'], array($this->join['groups'] => (int) $group_id, $this->join['users'] => (int) $user_id));
                    if (isset($this->_cache_user_in_group[$user_id]) && isset($this->_cache_user_in_group[$user_id][$group_id])) {
                         unset($this->_cache_user_in_group[$user_id][$group_id]);
                    }
               }

               $return = TRUE;
          }
          // otherwise remove user from all groups
          else {
               if ($return = $this->db->delete($this->tables['users_groups'], array($this->join['users'] => (int) $user_id))) {
                    $this->_cache_user_in_group[$user_id] = array();
               }
          }
          return $return;
     }

     /**
      * groups
      *
      * @return object
      * @author Ben Edmunds
      * */
     public function groups()
     {
          $this->trigger_events('groups');

          //run each where that was passed
          if (isset($this->_ion_where) && !empty($this->_ion_where)) {
               foreach ($this->_ion_where as $where) {
                    $this->db->where($where);
               }
               $this->_ion_where = array();
          }

          if (isset($this->_ion_limit) && isset($this->_ion_offset)) {
               $this->db->limit($this->_ion_limit, $this->_ion_offset);

               $this->_ion_limit = NULL;
               $this->_ion_offset = NULL;
          } else if (isset($this->_ion_limit)) {
               $this->db->limit($this->_ion_limit);

               $this->_ion_limit = NULL;
          }

          //set the order
          if (isset($this->_ion_order_by) && isset($this->_ion_order)) {
               $this->db->order_by($this->_ion_order_by, $this->_ion_order);
          }

          $this->response = $this->db->get($this->tables['groups']);

          return $this;
     }

     /**
      * group
      *
      * @return object
      * @author Ben Edmunds
      * */
     public function group($id = NULL)
     {
          $this->trigger_events('group');

          if (isset($id)) {
               $this->db->where($this->tables['groups'] . '.id', $id);
          }

          $this->limit(1);

          return $this->groups();
     }

     /**
      * update
      *
      * @return bool
      * @author Phil Sturgeon
      * */
     public function update($id, array $data)
     {
          $this->trigger_events('pre_update_user');

          $user = $this->user($id)->row();

          $this->db->trans_begin();

          if (array_key_exists($this->identity_column, $data) && $this->identity_check($data[$this->identity_column]) && $user->{$this->identity_column} !== $data[$this->identity_column]) {
               $this->db->trans_rollback();
               $this->set_error('account_creation_duplicate_' . $this->identity_column);

               $this->trigger_events(array('post_update_user', 'post_update_user_unsuccessful'));
               $this->set_error('update_unsuccessful');

               return FALSE;
          }

          // Filter the data passed
          $data = $this->_filter_data($this->tables['users'], $data);

          if (array_key_exists('username', $data) || array_key_exists('password', $data) || array_key_exists('email', $data)) {
               if (array_key_exists('password', $data)) {
                    if (!empty($data['password'])) {
                         $data['password'] = $this->hash_password($data['password'], $user->salt);
                    } else {
                         // unset password so it doesn't effect database entry if no password passed
                         unset($data['password']);
                    }
               }
          }

          $this->trigger_events('extra_where');
          $this->db->update($this->tables['users'], $data, array('id' => $user->id));

          if ($this->db->trans_status() === FALSE) {
               $this->db->trans_rollback();

               $this->trigger_events(array('post_update_user', 'post_update_user_unsuccessful'));
               $this->set_error('update_unsuccessful');
               return FALSE;
          }

          $this->db->trans_commit();

          $this->trigger_events(array('post_update_user', 'post_update_user_successful'));
          $this->set_message('update_successful');
          return TRUE;
     }

     /**
      * delete_user
      *
      * @return bool
      * @author Phil Sturgeon
      * */
     public function delete_user($id)
     {
          $this->trigger_events('pre_delete_user');

          $this->db->trans_begin();

          // remove user from groups
          $this->remove_from_group(NULL, $id);

          // delete user from users table should be placed after remove from group
          $this->db->delete($this->tables['users'], array('id' => $id));

          // if user does not exist in database then it returns FALSE else removes the user from groups
          if ($this->db->affected_rows() == 0) {
               return FALSE;
          }

          if ($this->db->trans_status() === FALSE) {
               $this->db->trans_rollback();
               $this->trigger_events(array('post_delete_user', 'post_delete_user_unsuccessful'));
               $this->set_error('delete_unsuccessful');
               return FALSE;
          }

          $this->db->trans_commit();

          $this->trigger_events(array('post_delete_user', 'post_delete_user_successful'));
          $this->set_message('delete_successful');
          return TRUE;
     }

     /**
      * update_last_login
      *
      * @return bool
      * @author Ben Edmunds
      * */
     public function update_last_login($id)
     {
          $this->trigger_events('update_last_login');

          $this->load->helper('date');

          $this->trigger_events('extra_where');

          $this->db->update($this->tables['users'], array('usr_last_login' => time()), array('usr_id' => $id));

          return $this->db->affected_rows() == 1;
     }

     /**
      * set_lang
      *
      * @return bool
      * @author Ben Edmunds
      * */
     public function set_lang($lang = 'en')
     {
          $this->trigger_events('set_lang');

          // if the user_expire is set to zero we'll set the expiration two years from now.
          if ($this->config->item('user_expire', 'ion_auth') === 0) {
               $expire = (60 * 60 * 24 * 365 * 2);
          }
          // otherwise use what is set
          else {
               $expire = $this->config->item('user_expire', 'ion_auth');
          }

          set_cookie(array(
               'name' => 'lang_code',
               'value' => $lang,
               'expire' => $expire
          ));

          return TRUE;
     }

     /**
      * remember_user
      *
      * @return bool
      * @author jrmadsen67
      * */
     public function set_session($user)
     {
          $this->trigger_events('pre_set_session');
          $total_missedCount = $this->followMissedCountTotal($user->usr_id, $user->grp_slug, $user->usr_showroom);
          $session_data = array(
               'usr_identity' => $user->{$this->identity_column},
               'usr_username' => $user->usr_username,
               'usr_email' => $user->usr_email,
               'usr_user_id' => $user->usr_id, //everyone likes to overwrite id so we'll use user_id
               'usr_old_last_login' => $user->usr_last_login,
               'usr_user_access' => $user->user_access,
               // 'usr_role' => $user->user_access_new,
               'grp_slug' => $user->grp_slug,
               'grp_id' => $user->group_id,
               'usr_avatar' => $user->usr_avatar,
               'usr_showroom' => $user->usr_showroom,
               'usr_division' => $user->usr_division,
               'usr_appdownloadlink' => $user->usr_appdownloadlink,
               'usr_division' => $user->usr_division,
               'follow_missed_count' => $total_missedCount,
               'desig_slug' => $user->desig_slug,
               'desig_id' => $user->desig_id,
               'usr_emp_code' => $user->usr_emp_code,
               'usr_rol' => $user->usr_rol
          );

          $this->session->set_userdata($session_data);

          $this->trigger_events('post_set_session');
          return TRUE;
     }

     /**
      * Missed followup count for showing menu bar
      * @return int
      * @auther Jafer
      * @date 31-JAN-2022
      */
     function followMissedCountTotal($usr_id, $grp_slug, $showroom)
     {
          $this->db->query("SET time_zone = '+05:30'");
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_users = TABLE_PREFIX . 'users';

          if ($grp_slug == 'TL') {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $usr_id)
                    ->get($this->tbl_users)->row()->usr_id);
               array_push($mystaffs, $usr_id);
          }
          if ($grp_slug == 'SE') {
               $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $usr_id);
          } else if ($grp_slug == 'MG') {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id = ' . $showroom);
          } else if ($grp_slug == 'TL') {
               if (check_permission('followup', 'showfollowupmyshowroom')) {
                    $this->db->where($this->tbl_enquiry . '.enq_showroom_id = ' . $showroom);
               } else {
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               }
          } else if (!is_roo_user()) {
               $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $usr_id);
          }
          return $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses)
               ->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)')
               ->order_by($this->tbl_enquiry . '.enq_next_foll_date DESC')->count_all_results($this->tbl_enquiry);
     }

     /**
      * remember_user
      *
      * @return bool
      * @author Ben Edmunds
      * */
     public function remember_user($id)
     {
          $this->trigger_events('pre_remember_user');

          if (!$id) {
               return FALSE;
          }

          $user = $this->user($id)->row();

          $salt = sha1($user->password);

          $this->db->update($this->tables['users'], array('remember_code' => $salt), array('id' => $id));

          if ($this->db->affected_rows() > -1) {
               // if the user_expire is set to zero we'll set the expiration two years from now.
               if ($this->config->item('user_expire', 'ion_auth') === 0) {
                    $expire = (60 * 60 * 24 * 365 * 2);
               }
               // otherwise use what is set
               else {
                    $expire = $this->config->item('user_expire', 'ion_auth');
               }

               set_cookie(array(
                    'name' => 'identity',
                    'value' => $user->{$this->identity_column},
                    'expire' => $expire
               ));

               set_cookie(array(
                    'name' => 'remember_code',
                    'value' => $salt,
                    'expire' => $expire
               ));

               $this->trigger_events(array('post_remember_user', 'remember_user_successful'));
               return TRUE;
          }

          $this->trigger_events(array('post_remember_user', 'remember_user_unsuccessful'));
          return FALSE;
     }

     /**
      * login_remembed_user
      *
      * @return bool
      * @author Ben Edmunds
      * */
     public function login_remembered_user()
     {
          $this->trigger_events('pre_login_remembered_user');

          //check for valid data
          if (!get_cookie('identity') || !get_cookie('remember_code') || !$this->identity_check(get_cookie('identity'))) {
               $this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_unsuccessful'));
               return FALSE;
          }

          //get the user
          $this->trigger_events('extra_where');
          $query = $this->db->select($this->identity_column . ', usr_id, usr_username, usr_email, usr_last_login')
               ->where($this->identity_column, get_cookie('identity'))
               ->where('remember_code', get_cookie('remember_code'))
               ->limit(1)
               ->get($this->tables['users']);

          //if the user was found, sign them in
          if ($query->num_rows() == 1) {
               $user = $query->row();

               $this->update_last_login($user->usr_id);

               $this->set_session($user);

               //extend the users cookies if the option is enabled
               if ($this->config->item('user_extend_on_login', 'ion_auth')) {
                    $this->remember_user($user->usr_id);
               }

               $this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_successful'));
               return TRUE;
          }

          $this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_unsuccessful'));
          return FALSE;
     }

     /**
      * create_group
      *
      * @author aditya menon
      */
     public function create_group($group_name = FALSE, $group_description = '', $additional_data = array())
     {
          // bail if the group name was not passed
          if (!$group_name) {
               $this->set_error('group_name_required');
               return FALSE;
          }

          // bail if the group name already exists
          $existing_group = $this->db->get_where($this->tables['groups'], array('name' => $group_name))->num_rows();
          if ($existing_group !== 0) {
               $this->set_error('group_already_exists');
               return FALSE;
          }

          $data = array('name' => $group_name, 'description' => $group_description);

          //filter out any data passed that doesnt have a matching column in the groups table
          //and merge the set group data and the additional data
          if (!empty($additional_data))
               $data = array_merge($this->_filter_data($this->tables['groups'], $additional_data), $data);

          $this->trigger_events('extra_group_set');

          // insert the new group
          $this->db->insert($this->tables['groups'], $data);
          $group_id = $this->db->insert_id();

          // report success
          $this->set_message('group_creation_successful');
          // return the brand new group id
          return $group_id;
     }

     /**
      * update_group
      *
      * @return bool
      * @author aditya menon
      * */
     public function update_group($group_id = FALSE, $group_name = FALSE, $additional_data = array())
     {
          if (empty($group_id))
               return FALSE;

          $data = array();

          if (!empty($group_name)) {
               // we are changing the name, so do some checks
               // bail if the group name already exists
               $existing_group = $this->db->get_where($this->tables['groups'], array('name' => $group_name))->row();
               if (isset($existing_group->id) && $existing_group->id != $group_id) {
                    $this->set_error('group_already_exists');
                    return FALSE;
               }

               $data['name'] = $group_name;
          }


          // IMPORTANT!! Third parameter was string type $description; this following code is to maintain backward compatibility
          // New projects should work with 3rd param as array
          if (is_string($additional_data))
               $additional_data = array('description' => $additional_data);


          //filter out any data passed that doesnt have a matching column in the groups table
          //and merge the set group data and the additional data
          if (!empty($additional_data))
               $data = array_merge($this->_filter_data($this->tables['groups'], $additional_data), $data);


          $this->db->update($this->tables['groups'], $data, array('id' => $group_id));

          $this->set_message('group_update_successful');

          return TRUE;
     }

     /**
      * delete_group
      *
      * @return bool
      * @author aditya menon
      * */
     public function delete_group($group_id = FALSE)
     {
          // bail if mandatory param not set
          if (!$group_id || empty($group_id)) {
               return FALSE;
          }

          $this->trigger_events('pre_delete_group');

          $this->db->trans_begin();

          // remove all users from this group
          $this->db->delete($this->tables['users_groups'], array($this->join['groups'] => $group_id));
          // remove the group itself
          $this->db->delete($this->tables['groups'], array('id' => $group_id));

          if ($this->db->trans_status() === FALSE) {
               $this->db->trans_rollback();
               $this->trigger_events(array('post_delete_group', 'post_delete_group_unsuccessful'));
               $this->set_error('group_delete_unsuccessful');
               return FALSE;
          }

          $this->db->trans_commit();

          $this->trigger_events(array('post_delete_group', 'post_delete_group_successful'));
          $this->set_message('group_delete_successful');
          return TRUE;
     }

     public function set_hook($event, $name, $class, $method, $arguments)
     {
          $this->_ion_hooks->{$event}[$name] = new stdClass;
          $this->_ion_hooks->{$event}[$name]->class = $class;
          $this->_ion_hooks->{$event}[$name]->method = $method;
          $this->_ion_hooks->{$event}[$name]->arguments = $arguments;
     }

     public function remove_hook($event, $name)
     {
          if (isset($this->_ion_hooks->{$event}[$name])) {
               unset($this->_ion_hooks->{$event}[$name]);
          }
     }

     public function remove_hooks($event)
     {
          if (isset($this->_ion_hooks->$event)) {
               unset($this->_ion_hooks->$event);
          }
     }

     protected function _call_hook($event, $name)
     {
          if (isset($this->_ion_hooks->{$event}[$name]) && method_exists($this->_ion_hooks->{$event}[$name]->class, $this->_ion_hooks->{$event}[$name]->method)) {
               $hook = $this->_ion_hooks->{$event}[$name];

               return call_user_func_array(array($hook->class, $hook->method), $hook->arguments);
          }

          return FALSE;
     }

     public function trigger_events($events)
     {
          if (is_array($events) && !empty($events)) {
               foreach ($events as $event) {
                    $this->trigger_events($event);
               }
          } else {
               if (isset($this->_ion_hooks->$events) && !empty($this->_ion_hooks->$events)) {
                    foreach ($this->_ion_hooks->$events as $name => $hook) {
                         $this->_call_hook($events, $name);
                    }
               }
          }
     }

     /**
      * set_message_delimiters
      *
      * Set the message delimiters
      *
      * @return void
      * @author Ben Edmunds
      * */
     public function set_message_delimiters($start_delimiter, $end_delimiter)
     {
          $this->message_start_delimiter = $start_delimiter;
          $this->message_end_delimiter = $end_delimiter;

          return TRUE;
     }

     /**
      * set_error_delimiters
      *
      * Set the error delimiters
      *
      * @return void
      * @author Ben Edmunds
      * */
     public function set_error_delimiters($start_delimiter, $end_delimiter)
     {
          $this->error_start_delimiter = $start_delimiter;
          $this->error_end_delimiter = $end_delimiter;

          return TRUE;
     }

     /**
      * set_message
      *
      * Set a message
      *
      * @return void
      * @author Ben Edmunds
      * */
     public function set_message($message)
     {
          $this->messages[] = $message;

          return $message;
     }

     /**
      * messages
      *
      * Get the messages
      *
      * @return void
      * @author Ben Edmunds
      * */
     public function messages()
     {
          $_output = '';
          foreach ($this->messages as $message) {
               $messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
               $_output .= $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
          }

          return $_output;
     }

     /**
      * messages as array
      *
      * Get the messages as an array
      *
      * @return array
      * @author Raul Baldner Junior
      * */
     public function messages_array($langify = TRUE)
     {
          if ($langify) {
               $_output = array();
               foreach ($this->messages as $message) {
                    $messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
                    $_output[] = $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
               }
               return $_output;
          } else {
               return $this->messages;
          }
     }

     /**
      * set_error
      *
      * Set an error message
      *
      * @return void
      * @author Ben Edmunds
      * */
     public function set_error($error)
     {
          $this->errors[] = $error;

          return $error;
     }

     /**
      * errors
      *
      * Get the error message
      *
      * @return void
      * @author Ben Edmunds
      * */
     public function errors()
     {
          $_output = '';
          foreach ($this->errors as $error) {
               $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
               $_output .= $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
          }

          return $_output;
     }

     /**
      * errors as array
      *
      * Get the error messages as an array
      *
      * @return array
      * @author Raul Baldner Junior
      * */
     public function errors_array($langify = TRUE)
     {
          if ($langify) {
               $_output = array();
               foreach ($this->errors as $error) {
                    $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
                    $_output[] = $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
               }
               return $_output;
          } else {
               return $this->errors;
          }
     }

     protected function _filter_data($table, $data)
     {
          $filtered_data = array();
          $columns = $this->db->list_fields($table);

          if (is_array($data)) {
               foreach ($columns as $column) {
                    if (array_key_exists($column, $data))
                         $filtered_data[$column] = $data[$column];
               }
          }

          return $filtered_data;
     }

     protected function _prepare_ip($ip_address)
     {
          if ($this->db->platform() === 'postgre' || $this->db->platform() === 'sqlsrv' || $this->db->platform() === 'mssql') {
               return $ip_address;
          } else {
               return inet_pton($ip_address);
          }
     }

     public function get_all_users_with_group()
     {
          $this->trigger_events('get_all_users_with_groups');

          return $this->db->select(
               $this->tables['users'] . '.*, ' .
                    $this->tables['users_groups'] . '.' . $this->join['groups'] . ' as group_id, ' .
                    $this->tables['groups'] . '.name as group_name, ' .
                    $this->tables['groups'] . '.description as group_desc'
          )
               ->join($this->tables['users_groups'], $this->tables['users_groups'] . '.' . $this->join['users'] . '=' . $this->tables['users'] . '.usr_id')
               ->join($this->tables['groups'], $this->tables['users_groups'] . '.' . $this->join['groups'] . '=' . $this->tables['groups'] . '.id')
               ->get($this->tables['users'])->result_array();
     }

     function removeAvatar($id)
     {
          $this->trigger_events('removeAvatar');
          if (!empty($id) && $this->db->update($this->tables['users'], array('avatar' => ''), array('id' => $id))) {
               return true;
          } else {
               return false;
          }
     }
}
